<?php

namespace App\Http\Controllers;

use App\DataTables\GalleryDataTable;
use App\Models\GalleryModel as Gallery;
use App\Models\DetailGalleryModel as DetailGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GalleryDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.gallery.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gallery = new Gallery;
        $mode = 'create';
        return view('pages.apps.gallery.form', compact('gallery', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'activity' => ['required', 'string', 'max:255'],
            'time' => ['required', 'string'],
            'place' => ['required', 'string'],
            'photos.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'title_photo.*' => ['nullable', 'string', 'max:255'],
            'caption.*' => ['nullable', 'string'],
        ]);

        try {
            // CREATE GALLERY
            $gallery = Gallery::create([
                'activity' => $validated['activity'],
                'time' => $validated['time'],
                'place' => $validated['place'],
            ]);

            // HANDLE MULTIPLE PHOTOS
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $photoPath = $photo->store('gallery', 'public');

                    DetailGallery::create([
                        'gallery_id' => $gallery->id,
                        'photo' => $photoPath,
                        'title_photo' => $request->title_photo[$index] ?? null,
                        'caption' => $request->caption[$index] ?? null,
                    ]);
                }
            }

            return redirect()
                ->route('gallery-management.gallery.index')
                ->with('success', 'Gallery berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat gallery: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gallery = Gallery::with('photos')->findOrFail($id);
        return view('pages.apps.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Gallery::with('photos')->findOrFail($id);
        $mode = 'edit';
        return view('pages.apps.gallery.form', compact('gallery', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'activity' => ['required', 'string', 'max:255'],
            'time' => ['required', 'string'],
            'place' => ['required', 'string'],
            'new_photos.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'new_title_photo.*' => ['nullable', 'string', 'max:255'],
            'new_caption.*' => ['nullable', 'string'],
        ]);

        try {
            $gallery = Gallery::findOrFail($id);

            // UPDATE GALLERY DATA
            $gallery->update([
                'activity' => $validated['activity'],
                'time' => $validated['time'],
                'place' => $validated['place'],
            ]);

            // HANDLE NEW PHOTOS
            if ($request->hasFile('new_photos')) {
                foreach ($request->file('new_photos') as $index => $photo) {
                    $photoPath = $photo->store('gallery', 'public');

                    DetailGallery::create([
                        'gallery_id' => $gallery->id,
                        'photo' => $photoPath,
                        'title_photo' => $request->new_title_photo[$index] ?? null,
                        'caption' => $request->new_caption[$index] ?? null,
                    ]);
                }
            }

            // HANDLE UPDATE EXISTING PHOTOS (jika perlu)
            if ($request->has('existing_photos')) {
                foreach ($request->existing_photos as $photoId => $photoData) {
                    $photo = DetailGallery::find($photoId);
                    if ($photo) {
                        $photo->update([
                            'title_photo' => $photoData['title_photo'] ?? null,
                            'caption' => $photoData['caption'] ?? null,
                        ]);
                    }
                }
            }

            return redirect()
                ->route('gallery-management.gallery.index')
                ->with('success', 'Gallery berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui gallery: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gallery = Gallery::with('photos')->findOrFail($id);

            // Delete all photos
            foreach ($gallery->photos as $photo) {
                if ($photo->photo) {
                    Storage::disk('public')->delete($photo->photo);
                }
                $photo->delete();
            }

            // Delete gallery
            $gallery->delete();

            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Gallery berhasil dihapus!'
                ], 200);
            }

            return redirect()
                ->route('gallery-management.gallery.index')
                ->with('success', 'Gallery berhasil dihapus!');
        } catch (\Exception $e) {
            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus gallery: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->route('gallery-management.gallery.index')
                ->with('error', 'Gagal menghapus gallery!');
        }
    }

    /**
     * Delete single photo
     */
    public function deletePhoto($id)
    {
        try {
            $photo = DetailGallery::findOrFail($id);

            if ($photo->photo) {
                Storage::disk('public')->delete($photo->photo);
            }

            $photo->delete();

            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto berhasil dihapus!'
                ], 200);
            }

            return back()->with('success', 'Foto berhasil dihapus!');
        } catch (\Exception $e) {
            // Handle AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus foto: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus foto!');
        }
    }

    /**
     * Kelola foto gallery
     */
    public function photos($id)
    {
        $gallery = Gallery::with('photos')->findOrFail($id);
        return view('pages.apps.gallery.photos', compact('gallery'));
    }

    /**
     * Store new photos to gallery
     */
    public function storePhotos(Request $request, $id)
    {
        $validated = $request->validate([
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'title_photo.*' => ['nullable', 'string', 'max:255'],
            'caption.*' => ['nullable', 'string'],
        ]);

        try {
            $gallery = Gallery::findOrFail($id);

            // HANDLE MULTIPLE PHOTOS
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $photoPath = $photo->store('gallery', 'public');

                    DetailGallery::create([
                        'gallery_id' => $gallery->id,
                        'photo' => $photoPath,
                        'title_photo' => $request->title_photo[$index] ?? null,
                        'caption' => $request->caption[$index] ?? null,
                    ]);
                }
            }

            return redirect()
                ->route('gallery-management.gallery.photos', $gallery->id)
                ->with('success', 'Foto berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan foto: ' . $e->getMessage());
        }
    }
}
