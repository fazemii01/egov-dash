<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqModel;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $faqs = FaqModel::when(
            $q,
            fn($qb) =>
            $qb->where('statement', 'like', "%{$q}%")
                ->orWhere('answer', 'like', "%{$q}%")
        )
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.apps.faq.list', [
            'faqs' => $faqs,
            'q' => $q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faq = new FaqModel();
        return view('pages.apps.faq.modals.CreateFaq', compact('faq'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'statement' => ['required', 'string', 'max:1000'],
            'answer' => ['required', 'string'],
        ]);

        $faq = FaqModel::create([
            'statement' => $validated['statement'],
            'answer' => $validated['answer'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('faq-management.faq.index')
            ->with('success', 'FAQ berhasil dibuat.')
            ->with('scroll_to', $faq->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $faq = FaqModel::findOrFail($id);
        return view('pages.apps.faq.modals.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faq = FaqModel::findOrFail($id);
        return view('pages.apps.faq.modals.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaqModel $faq)
    {
        $validated = $request->validate([
            'statement' => ['required', 'string', 'max:1000'],
            'answer' => ['required', 'string'],
        ]);

        // Update data
        $faq->statement = $validated['statement'];
        $faq->answer = $validated['answer'];
        $faq->updated_at = now();
        $faq->save();

        return redirect()
            ->route('faq-management.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqModel $faq)
    {
        $faq->delete();

        return redirect()
            ->route('faq-management.faq.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}
