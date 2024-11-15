<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AudioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $audios = Media::where('user_id', Auth::id())
            ->where('file_type', 'LIKE', 'audio/%')
            ->when($search, function ($query) use ($search) {
                return $query->where('filename', 'like', '%' . $search . '%');
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(12);

        return view('logged.audio.index', compact('audios', 'search', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'audio_upload' => 'required|file|mimetypes:audio/mpeg,audio/wav,audio/ogg,audio/x-wav,audio/x-mpeg,audio/x-mpeg-3,audio/x-mpeg-2,audio/x-mpeg-part,audio/x-pn-realaudio,audio/x-pn-realaudio-plugin,audio/x-pn-realaudio-sample,audio/x-scpls,audio/mp4,audio/x-m4a|max:51200'
            ],
            [
                'audio_upload.required' => 'Please select an audio file',
                'audio_upload.file' => 'Please select a valid file',
                'audio_upload.mimetypes' => 'Please select a valid audio file',
                'audio_upload.max' => 'Please select a valid audio size: max 50MB'
            ]
        );
        


        try {
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors('You must be logged in to upload audios');
            }
            $file = $request->file('audio_upload');

            if (!$this->isValidAudioType($file->getMimeType())) {
                return redirect()->back()->withErrors('Invalid audio type');
            }

            $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
            $filePath = 'users/' . Auth::id() . '/audios/' . $fileName;


            Storage::makeDirectory(dirname($filePath));

            if (!Storage::put($filePath, file_get_contents($file))) {
                throw new Exception('Filed to save file');
            }
            $media = new Media([
                'filename' => $fileName,
                'file_size' => $file->getSize(),
                'file_path' => $filePath,
                'file_type' => $file->getMimeType(),
                'active' => true,
                'user_id' => Auth::id()
            ]);

            if (!$media->save()) {
                $this->cleanUpFile($filePath);
                throw new Exception('Failed to save media record');
            }
            return redirect()->back()->with('success', 'Audio uploaded successfully!');
        } catch (Exception $e) {
            if (isset($filePath)) {
                $this->cleanupFile($filePath);
            }
            Log::error('Audio upload error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error uploading audio');
        }
    }
    public function show($mediaId)
    {
        $media = Media::where('id', $mediaId)
            ->where('user_id', Auth::id())
            ->where('file_type', 'LIKE', 'audio/%')
            ->firstOrFail();

        if (!Storage::exists($media->file_path)) {
            abort(404);
        }

        $stream = Storage::readStream($media->file_path);
        $size = Storage::size($media->file_path);
        $range = request()->header('Range');

        if ($range) {
            return $this->handleRangeRequest($stream, $size, $range, $media);
        }
        return new StreamedResponse(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $media->file_type,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . $media->filename . '"',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    private function handleRangeRequest($stream, $size, $range, $media)
    {
        $end = $size - 1;
        $start = 0;


        if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $range, $matches)) {
            $start = intval($matches[1]);
            if (!empty($matches[2])) {
                $end = intval($matches[2]);
            }
        }
        if ($start > 0 || $end < ($size - 1)) {
            header('HTTP/1.1 206 Partial Content');
        }
        header("Content-Type: {$media->file_type}");
        header("Accept-Ranges: bytes");
        header("Content-Length: " . ($end - $start + 1));
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Disposition: inline; filename=\"{$media->filename}\"");

        $cur = $start;
        fseek($stream, $start);

        while (!feof($stream) && $cur <= $end && (connection_status() === CONNECTION_NORMAL)) {
            echo fread($stream, min(1024 * 16, ($end - $cur + 1)));
            $cur += 1024 * 16;
        }

        fclose($stream);
        exit;
    }

    private function isValidAudioType($mimeType)
    {
        return in_array($mimeType, [
            'audio/mpeg',
            'audio/wav',
            'audio/ogg',
            'audio/x-wav',
            'audio/x-mpeg',
            'audio/x-mpeg-3',
            'audio/x-mpeg-2',
            'audio/x-mpeg-part',
            'audio/x-pn-realaudio',
            'audio/x-pn-realaudio-plugin',
            'audio/x-pn-realaudio-sample',
            'audio/x-scpls'
        ]);
    }
    private function cleanupFile($filePath)
    {
        try {
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        } catch (Exception $e) {
            Log::error('Error cleaning up file: ' . $e->getMessage());
        }
    }
}
