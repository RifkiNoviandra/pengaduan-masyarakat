<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Storage;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::orderByDesc('id')->paginate(10);
        return view('pages.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('pages.donations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('donations', 'public');
            $validated['image'] = $path;
        }

        $donation = Donation::create($validated);

        return redirect()->route('donations.index', compact('donation'))
            ->with('success', 'Terima kasih atas donasi Anda!');
    }

    public function show(Donation $donation)
    {
        return view('pages.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('pages.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($donation->image && Storage::disk('public')->exists($donation->image)) {
                Storage::disk('public')->delete($donation->image);
            }

            $path = $request->file('image')->store('donations', 'public');
            $validated['image'] = $path;
        }

        $donation->update($validated);

        return redirect()->route('donations.index')
            ->with('success', 'Donasi berhasil diperbarui.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')
            ->with('success', 'Donasi berhasil dihapus.');
    }
}
