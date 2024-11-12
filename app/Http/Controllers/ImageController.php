<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $images = Media::where('user_id', Auth::id())
            ->where('file_type', 'LIKE', 'image/%')
            ->when($search, function ($query) use ($search) {
                return $query->where('filename', 'like', '%' . $search . '%');
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(15);

        return view('logged.image.index', compact('images', 'search', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'image_upload' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:12288'
            ],
            [
                'image_upload.required' => 'Please select an image',
                'image_upload.file' => 'Please select a valid file',
                'image_upload.image' => 'Please select a valid image',
                'image_upload.mimes' => 'Please select a valid image type: jpeg, png, jpg, gif.',
                'image_upload.max' => 'Please select a valid image size: max 12MB'
            ]
        );

        try {
            if (!Auth::check()) {
                return redirect()->back()->withErrors('Unauthenticated user');
            }

            $file = $request->file('image_upload');

            if (!$this->isValidImageType($file->getMimeType())) {
                return redirect()->back()->withErrors('Invalid image type');
            }

            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'users/' . Auth::id() . '/images/' . $fileName;

            Storage::makeDirectory(dirname($filePath));

            if (!Storage::put($filePath, file_get_contents($file))) {
                throw new Exception('Failed to save file');
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
                $this->cleanupFile($filePath);
                throw new Exception('Failed to save media record');
            }

            return redirect()->back()->with('success', 'Image uploaded successfully!');
        } catch (Exception $e) {
            if (isset($filePath)) {
                $this->cleanupFile($filePath);
            }

            Log::error('Image upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error uploading image. Please try again.');
        }
    }
    public function addToAlbum(Request $request, $mediaId)
    {
        $request->valdiate([
            'album_id' => 'required|exists:albums,id',
        ]);
        $media = media::where('id', $mediaId)
            ->where('user_id', Auth::id())
            ->where('filte_type', 'LIKE', 'image/%')
            ->firstOrFail();
        $album = Album::where('id', $request->album_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $album->media()->attach($media->id);

        return redirect()->back()->with('success', 'Image added to album successfully!');
    }
    public function show($mediaId)
    {
        $media = Media::where('id', $mediaId)
            ->where('user_id', Auth::id())
            ->where('file_type', 'LIKE', 'image/%')
            ->firstOrFail();

        if (!Storage::exists($media->file_path)) {
            abort(404);
        }

        return new StreamedResponse(function () use ($media) {
            $stream = Storage::readStream($media->file_path);
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $media->file_type,
            'Content-Disposition' => 'inline; filename="' . $media->filename . '"',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    private function isValidImageType($mimeType)
    {
        return in_array($mimeType, [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/jpg'
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
