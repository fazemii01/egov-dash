<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkSiteModel;

class LinkSiteController extends Controller
{

    /**
     * Remove the specified resource from storage.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $links = LinkSiteModel::when(
            $q,
            fn($qb) =>
            $qb->where('name', 'like', "%{$q}%")
                ->orWhere('link', 'like', "%{$q}%")
        )
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.apps.linksite.list', [
            'links' => $links,
            'q' => $q,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $link = new LinkSiteModel();
        return view('pages.apps.linksite.modals.CreateLinkSite', compact('link'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'url', 'max:500'],
        ]);

        $link = LinkSiteModel::create([
            'name' => $validated['name'],
            'link' => $validated['link'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('linksite-management.linksite.index')
            ->with('success', 'Link situs berhasil dibuat.')
            ->with('scroll_to', $link->id);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $link = LinkSiteModel::findOrFail($id);
        return view('pages.apps.linksite.modals.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $link = LinkSiteModel::findOrFail($id);
        return view('pages.apps.linksite.modals.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LinkSiteModel $linksite)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'url', 'max:500'],
        ]);

        // Update data
        $linksite->name = $validated['name'];
        $linksite->link = $validated['link'];
        $linksite->updated_at = now();
        $linksite->save();

        return redirect()
            ->route('linksite-management.linksite.index')
            ->with('success', 'Link situs berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LinkSiteModel $linksite)
    {
        $linksite->delete();

        return redirect()
            ->route('linksite-management.linksite.index')
            ->with('success', 'Link situs berhasil dihapus.');
    }
}
