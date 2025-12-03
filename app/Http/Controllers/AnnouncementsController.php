<?php

namespace App\Http\Controllers;

use App\DataTables\AnnouncementsDataTable;
use App\Models\AnnouncementsModel as Announcements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AnnouncementsDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.announcements.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $announcements = new Announcements;
        $mode = 'create';
        return view('pages.apps.announcements.form', compact('announcements', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file_path' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,zip', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);

        // HANDLE FILE UPLOAD
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('announcements', 'public');
        }

        try {
            // SIMPAN KE DB
            $item = Announcements::create([
                'title' => $validated['title'],
                'file_path' => $filePath,
                'published_at' => $validated['published_at'] ?? now(),
            ]);

            return redirect()
                ->route('announcements-management.announcements.index')
                ->with('success', 'Pengumuman berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcements $announcements)
    {
        return view('pages.apps.announcements.show', compact('announcements'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcements = Announcements::findOrFail($id);
        $mode = 'edit';
        return view('pages.apps.announcements.form', compact('announcements', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,zip', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);

        try {
            $announcements = Announcements::findOrFail($id);

            // HANDLE REUPLOAD FILE (hapus lama kalau ada)
            if ($request->hasFile('file_path')) {
                if ($announcements->file_path) {
                    Storage::disk('public')->delete($announcements->file_path);
                }
                $announcements->file_path = $request->file('file_path')->store('announcements', 'public');
            }

            // UPDATE KOLOM LAIN
            $announcements->title = $validated['title'];
            $announcements->published_at = $validated['published_at'];
            $announcements->save();

            return redirect()
                ->route('announcements-management.announcements.index')
                ->with('success', 'Pengumuman berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $announcements = Announcements::findOrFail($id);

            // Hapus file dari storage jika ada
            if ($announcements->file_path) {
                Storage::disk('public')->delete($announcements->file_path);
            }

            $announcements->delete();

            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengumuman berhasil dihapus!'
                ], 200);
            }

            return redirect()
                ->route('announcements-management.announcements.index')
                ->with('success', 'Pengumuman berhasil dihapus!');
        } catch (\Exception $e) {
            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pengumuman: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->route('announcements-management.announcements.index')
                ->with('error', 'Gagal menghapus pengumuman!');
        }
    }

    /**
     * Download file announcement
     */
    public function download($id)
    {
        try {
            $announcements = Announcements::findOrFail($id);

            if (!$announcements->file_path) {
                return redirect()
                    ->back()
                    ->with('error', 'File tidak ditemukan!');
            }

            $filePath = storage_path('app/public/' . $announcements->file_path);

            if (!file_exists($filePath)) {
                return redirect()
                    ->back()
                    ->with('error', 'File tidak ditemukan di server!');
            }

            return response()->download($filePath, basename($announcements->file_path));

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }
}
