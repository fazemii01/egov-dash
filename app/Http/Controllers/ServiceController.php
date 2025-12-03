<?php

namespace App\Http\Controllers;

use App\Models\ServiceModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $service = ServiceModels::when($q, fn($qb) =>
        $qb->where('title', 'like', "%{$q}%"))
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.apps.service.list', [
            'service' => $service,
            'q'    => $q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $service = new ServiceModels();
        return view('pages.apps.service.modals.CreateService', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'sop' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'file_download' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,zip,doc,docx', 'max:10240'],
            'created_at' => ['nullable', 'date'],
        ]);

        // Handle file uploads
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'created_at' => $validated['created_at'] ?? now(),
        ];

        // SOP dengan original name
        if ($request->hasFile('sop')) {
            $sopFile = $request->file('sop');
            $sopName = time() . '_' . $sopFile->getClientOriginalName(); // Nama asli + timestamp
            $data['sop'] = $sopFile->storeAs('sop', $sopName, 'public');
        }

        // File download dengan original name
        if ($request->hasFile('file_download')) {
            $fileDownload = $request->file('file_download');
            $fileName = time() . '_' . $fileDownload->getClientOriginalName(); // Nama asli + timestamp
            $data['file_download'] = $fileDownload->storeAs('services', $fileName, 'public');
        }

        // Simpan ke database
        ServiceModels::create($data);

        return redirect()
            ->route('service-management.service.index')
            ->with('success', 'Service berhasil dibuat.')
            ->with('scroll_to', ServiceModels::latest()->first()->id);
    }
    /**
     * Display the specified resource.
     */
    public function show(ServiceModels $service)
    {
        return view('pages.apps.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = ServiceModels::findOrFail($id);
        return view('pages.apps.service.modals.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceModels $service)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'sop' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'file_download' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,zip,doc,docx', 'max:10240'],
            'created_at' => ['nullable', 'date'],
        ]);

        // Update kolom text
        $service->title = $validated['title'];
        $service->content = $validated['content'];
        $service->created_at = $validated['created_at'] ?? $service->created_at;

        // SOP dengan original name
        if ($request->hasFile('sop')) {
            // Delete old file
            if ($service->sop) {
                Storage::disk('public')->delete($service->sop);
            }

            $sopFile = $request->file('sop');
            $sopName = time() . '_' . $sopFile->getClientOriginalName();
            $service->sop = $sopFile->storeAs('sop', $sopName, 'public');
        }

        // File download dengan original name
        if ($request->hasFile('file_download')) {
            // Delete old file
            if ($service->file_download) {
                Storage::disk('public')->delete($service->file_download);
            }

            $fileDownload = $request->file('file_download');
            $fileName = time() . '_' . $fileDownload->getClientOriginalName();
            $service->file_download = $fileDownload->storeAs('services', $fileName, 'public');
        }

        $service->save();

        return redirect()
            ->route('service-management.service.index')
            ->with('success', 'Service berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceModels $service)
    {
        // Hapus file SOP jika ada
        if ($service->sop) {
            Storage::disk('public')->delete($service->sop);
        }

        // Hapus file download jika ada
        if ($service->file_download) {
            Storage::disk('public')->delete($service->file_download);
        }

        $service->delete();

        return redirect()
            ->route('service-management.service.index')
            ->with('success', 'Service berhasil dihapus.');
    }
}
