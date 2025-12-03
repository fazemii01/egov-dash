<?php

namespace App\Http\Controllers;

use App\DataTables\NewsDataTable;
use App\Models\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NewsDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.news.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $news = new NewsModel;
        $mode = 'create';
        return view('pages.apps.news.form', compact('news', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'headline' => ['required', 'string', 'max:255'],
            'images'   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'content'  => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);

        // HANDLE FILE UPLOAD
        $imagePath = null;
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('news', 'public');
        }

        try {
            // SIMPAN KE DB
            $item = NewsModel::create([
                'headline' => $validated['headline'],
                'images'   => $imagePath,
                'content'  => $validated['content'],
                'id_user'  => auth()->id(),
                'published_at' => $validated['published_at']
            ]);

            return redirect()
                ->route('news-management.news.index')
                ->with('success', 'News created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create news: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsModel $news)
    {
        $news = NewsModel::findOrFail($news->id);
        $news->update(['count_view' => $news->count_view + 1]);
        return view('pages.apps.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $news = NewsModel::findOrFail($id);
        $mode = 'edit';
        return view('pages.apps.news.form', compact('news', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'headline' => ['required', 'string', 'max:255'],
            'images'   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'content'  => ['required', 'string'],
            'published_at'  => ['nullable', 'date'],
        ]);



        try {
            $news = NewsModel::findOrFail($id);

            // HANDLE REUPLOAD GAMBAR (hapus lama kalau ada)
            if ($request->hasFile('images')) {
                if ($news->images) {
                    Storage::disk('public')->delete($news->images);
                }
                $news->images = $request->file('images')->store('news', 'public');
            }

            // UPDATE KOLOM LAIN
            $news->headline = $validated['headline'];
            $news->content = $validated['content'];
            $news->published_at = $validated['published_at'];
            $news->save();

            // PERBAIKAN: Redirect ke index, bukan kembali ke form edit
            return redirect()
                ->route('news-management.news.index')
                ->with('success', 'News updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update news: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $news = NewsModel::findOrFail($id);
            $news->delete();

            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'News deleted successfully!'
                ], 200);
            }

            return redirect()
                ->route('news-management.news.index')
                ->with('success', 'News deleted successfully!');
        } catch (\Exception $e) {
            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete news: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->route('news-management.news.index')
                ->with('error', 'Failed to delete news!');
        }
    }
}
