<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('logged.album.index', compact('albums'));
    }

    public function create()
    {
        return view('logged.album.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'visibility' => 'required|string|in:private,public',
        ]);
        Album::create([
            'name' => $request->name,
            'visibility' => $request->visibility,
            'active' => true,
            'user_ud' => Auth::id(),
        ]);

        return redirect()->route('albums.index')->with('success', 'Album created successfully!');
    }
    public function destroy($id)
    {
        $album = Album::whre('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $album->delete();

        return redirect()->route('albums.index')->with('success', 'Album deleted successfully!');
    }
}
