<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Untuk Auth::id()
// use Illuminate\Support\Str; // Untuk Str::endsWith()

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $profiles = ProfileModel::with('user')
            ->when($q, fn($qb) => $qb->where('title', 'like', "%{$q}%"))
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.apps.profile.list', [
            'profiles' => $profiles,
            'q' => $q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profile = new ProfileModel();
        return view('pages.apps.profile.modals.CreateProfile', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240'],
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('profile', 'public');
        }

        ProfileModel::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file' => $filePath,
            'id_user' => Auth::id(), // Auto-set user yang login
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('profile-management.profile.index')
            ->with('success', 'Profile berhasil dibuat.')
            ->with('scroll_to', ProfileModel::latest()->first()->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $profile = ProfileModel::with('user')->findOrFail($id);
        return view('pages.apps.profile.modals.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $profile = ProfileModel::findOrFail($id);
        return view('pages.apps.profile.modals.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfileModel $profile)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240'],
        ]);

        // Handle file upload jika ada file baru
        if ($request->hasFile('file')) {
            // Delete old file
            if ($profile->file) {
                Storage::disk('public')->delete($profile->file);
            }
            $profile->file = $request->file('file')->store('profile', 'public');
        }

        // Update data
        $profile->title = $validated['title'];
        $profile->description = $validated['description'];
        $profile->updated_at = now();
        $profile->save();

        return redirect()
            ->route('profile-management.profile.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileModel $profile)
    {
        // Delete file
        if ($profile->file) {
            Storage::disk('public')->delete($profile->file);
        }
        
        $profile->delete();

        return redirect()
            ->route('profile-management.profile.index')
            ->with('success', 'Profile berhasil dihapus.');
    }
}