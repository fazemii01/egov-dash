<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact settings - single record management
     */
    public function index()
    {
        // Ambil data pertama atau null jika belum ada
        $contact = ContactModel::first();
        
        return view('pages.apps.contact.list', compact('contact'));
    }

    /**
     * Handle create/update contact settings - single record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'telephon' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:500'],
            'instagram' => ['nullable', 'url', 'max:500'],
            'twitter' => ['nullable', 'url', 'max:500'],
            'location' => ['nullable', 'string'],
            'aplication_version' => ['nullable', 'string', 'max:100'],
            'copyright' => ['nullable', 'string', 'max:255'],
        ]);

        // Cari data existing atau buat baru
        $contact = ContactModel::first();
        
        if ($contact) {
            // UPDATE data existing
            $contact->update([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'telephon' => $validated['telephon'],
                'email' => $validated['email'],
                'facebook' => $validated['facebook'],
                'instagram' => $validated['instagram'],
                'twitter' => $validated['twitter'],
                'location' => $validated['location'],
                'aplication_version' => $validated['aplication_version'],
                'copyright' => $validated['copyright'],
                'updated_at' => now(),
            ]);
            
            $message = 'Contact settings berhasil diperbarui.';
        } else {
            // CREATE data pertama
            $contact = ContactModel::create([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'telephon' => $validated['telephon'],
                'email' => $validated['email'],
                'facebook' => $validated['facebook'],
                'instagram' => $validated['instagram'],
                'twitter' => $validated['twitter'],
                'location' => $validated['location'],
                'aplication_version' => $validated['aplication_version'],
                'copyright' => $validated['copyright'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $message = 'Contact settings berhasil dibuat.';
        }

        return redirect()
            ->route('contact-management.contact.index')
            ->with('success', $message);
    }
}