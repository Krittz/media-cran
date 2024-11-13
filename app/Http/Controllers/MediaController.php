<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        // Contagem total de arquivos na tabela 'media' onde active = true
        $totalFiles = Media::count();

        // Contagem de arquivos de tipo 'image/%' onde active = true
        $totalImages = Media::where('file_type', 'LIKE', 'image/%')->count();

        // Contagem de arquivos de tipo 'video/%' onde active = true
        $totalVideos = Media::where('file_type', 'LIKE', 'video/%')->count();

        // Passa as contagens para a view 'logged.home'
        return view('logged.home', compact('totalFiles', 'totalImages', 'totalVideos'));
    }
}
