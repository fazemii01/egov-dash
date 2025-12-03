<?php

namespace App\Http\Controllers;

use App\DataTables\BannerDataTable;
use App\Models\BannerModel as Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.banner.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banner = new Banner;
        $mode = 'create';
        return view('pages.apps.banner.form', compact('banner', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'link' => ['nullable', 'string', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'active' => ['required', 'in:y,t'],
        ]);

        // HANDLE FILE UPLOAD
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('banners', 'public');
        }

        try {
            // SIMPAN KE DB
            $item = Banner::create([
                'title' => $validated['title'],
                'file' => $filePath,
                'link' => $validated['link'] ?? null,
                'order' => $validated['order'] ?? 0,
                'active' => $validated['active'],
            ]);

            return redirect()
                ->route('banner-management.banner.index')
                ->with('success', 'Banner berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat banner: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('pages.apps.banner.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $mode = 'edit';
        return view('pages.apps.banner.form', compact('banner', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'link' => ['nullable', 'string', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'active' => ['required', 'in:y,t'],
        ]);

        try {
            $banner = Banner::findOrFail($id);

            // HANDLE REUPLOAD FILE (hapus lama kalau ada)
            if ($request->hasFile('file')) {
                if ($banner->file) {
                    Storage::disk('public')->delete($banner->file);
                }
                $banner->file = $request->file('file')->store('banners', 'public');
            }

            // UPDATE KOLOM LAIN
            $banner->title = $validated['title'];
            $banner->link = $validated['link'] ?? null;
            $banner->order = $validated['order'] ?? 0;
            $banner->active = $validated['active'];
            $banner->save();

            return redirect()
                ->route('banner-management.banner.index')
                ->with('success', 'Banner berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui banner: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);

            // Hapus file dari storage jika ada
            if ($banner->file) {
                Storage::disk('public')->delete($banner->file);
            }

            $banner->delete();

            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner berhasil dihapus!'
                ], 200);
            }

            return redirect()
                ->route('banner-management.banner.index')
                ->with('success', 'Banner berhasil dihapus!');
        } catch (\Exception $e) {
            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus banner: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->route('banner-management.banner.index')
                ->with('error', 'Gagal menghapus banner!');
        }
    }

    /**
     * Download file banner
     */
    public function download($id)
    {
        try {
            $banner = Banner::findOrFail($id);

            if (!$banner->file) {
                return redirect()
                    ->back()
                    ->with('error', 'File tidak ditemukan!');
            }

            $filePath = storage_path('app/public/' . $banner->file);

            if (!file_exists($filePath)) {
                return redirect()
                    ->back()
                    ->with('error', 'File tidak ditemukan di server!');
            }

            return response()->download($filePath, basename($banner->file));

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status banner
     */
    public function toggleStatus($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->active = $banner->active == 'y' ? 't' : 'y';
            $banner->save();

            $status = $banner->active == 'y' ? 'diaktifkan' : 'dinonaktifkan';

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner berhasil ' . $status,
                    'new_status' => $banner->active
                ], 200);
            }

            return redirect()
                ->back()
                ->with('success', 'Banner berhasil ' . $status);

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status banner: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah status banner!');
        }
    }
}
