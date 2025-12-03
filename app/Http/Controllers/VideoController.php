<?php

namespace App\Http\Controllers;

use App\Models\VideoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $videos = VideoModel::with('user')
            ->when($q, fn($qb) => $qb->where('title', 'like', "%{$q}%"))
            ->orderBy('created_at','asc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.apps.video.list', [
            'videos' => $videos,
            'q' => $q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $video = new VideoModel();
        return view('pages.apps.video.modals.CreateVideo', compact('video'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'url', 'max:500'], // Sekarang untuk YouTube URL
            'created_at' => ['nullable', 'date'],
        ]);

        VideoModel::create([
            'title' => $validated['title'],
            'file' => $validated['file'], // Simpan YouTube link
            'id_user' => Auth::id(),
            'created_at' => $validated['created_at'] ?? now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('video-management.video.index')
            ->with('success', 'Video YouTube berhasil ditambahkan.')
            ->with('scroll_to', VideoModel::latest()->first()->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $video = VideoModel::with('user')->findOrFail($id);
        return view('pages.apps.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $video = VideoModel::findOrFail($id);
        return view('pages.apps.video.modals.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoModel $video)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'url', 'max:500'],
            'created_at' => ['nullable', 'date'],
        ]);

        // Update data
        $video->title = $validated['title'];
        $video->file = $validated['file'];
        $video->created_at = $validated['created_at'] ?? $video->created_at;
        $video->updated_at = now();
        $video->save();

        return redirect()
            ->route('video-management.video.index')
            ->with('success', 'Video YouTube berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoModel $video)
    {
        $video->delete();

        return redirect()
            ->route('video-management.video.index')
            ->with('success', 'Video YouTube berhasil dihapus.');
    }
}