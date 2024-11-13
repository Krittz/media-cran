<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Rotas públicas de autenticação
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::get('/signup', function () {
    return view('auth.create');
})->name('signup');
Route::post('/signup', [UserController::class, 'register'])->name('register.post');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Rota principal
    Route::get('/', [MediaController::class, 'index'])->name('home');


    // Grupo de rotas para imagens
    Route::prefix('image')->group(function () {
        Route::get('/', [ImageController::class, 'index'])->name('image');
        Route::post('/', [ImageController::class, 'store'])->name('upload.image');
        Route::get('/{mediaId}', [ImageController::class, 'show'])->name('images.show');
        Route::post('/{mediaId}/album', [ImageController::class, 'addToAlbum'])->name('images.add-to-album');
        Route::delete('/{mediaId}', [ImageController::class, 'destroy'])->name('images.destroy');
    });

    // Grupo de rotas para vídeos
    Route::prefix('video')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('video');
        Route::post('/', [VideoController::class, 'store'])->name('upload.video');
        Route::get('/{mediaId}', [VideoController::class, 'show'])->name('videos.show');
    });


    Route::resource('albums', AlbumController::class);
    Route::post('images/{$mediaId}/add-to-album', [ImageController::class, 'addToAlbum'])->name('images.addToAlbum');


    Route::get('album', function () {
        return view('logged.image.album');
    })->name('album');

    Route::get('collection', function () {
        return view('logged.video.collection');
    })->name('collection');
});

// Adicione uma rota de fallback para capturar URLs inválidas
Route::fallback(function () {
    return redirect()->route('home');
});
