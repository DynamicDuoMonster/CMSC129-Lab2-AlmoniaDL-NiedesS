<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShoeController extends Controller
{
    // View all shoes
    public function index()
    {
        $shoes = Shoe::active()->latest()->get();
        return view('layouts.index', compact('shoes'));
    }

    // Show add form
    public function create()
    {
        return view('layouts.create');
    }

    // Store new shoe
    public function store(Request $request)
    {
        $request->validate([
            'shoe_name' => 'required|string',
            'brand'     => 'required|string',
            'price'     => 'required|numeric',
            'category'  => 'nullable|string',
            'gender'    => 'nullable|string',
            'color'     => 'nullable|string',
            'images.*'  => 'nullable|image|max:2048',
        ]);

        $colors = array_map('trim', explode(',', $request->color));

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('shoes', 'public');
            }
        }

        Shoe::create([
            'shoe_name' => $request->shoe_name,
            'brand'     => $request->brand,
            'price'     => $request->price,
            'category'  => $request->category,
            'gender'    => $request->gender,
            'color'     => $colors,
            'image_url' => $imagePaths,
        ]);

        return redirect()->route('admin.shoes.index')->with('success', 'Shoe added successfully.');
    }

    // Show edit form
    public function edit(Shoe $shoe)
    {
        return view('dashboard.shoes.edit', compact('shoe'));
    }

    // Update shoe
    public function update(Request $request, Shoe $shoe)
    {
        $request->validate([
            'shoe_name' => 'required|string',
            'brand'     => 'required|string',
            'price'     => 'required|numeric',
            'category'  => 'nullable|string',
            'gender'    => 'nullable|string',
            'color'     => 'nullable|string',
            'images.*'  => 'nullable|image|max:2048',
        ]);

        $colors = array_map('trim', explode(',', $request->color));

        $imagePaths = $shoe->image_url ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('shoes', 'public');
            }
        }

        $shoe->update([
            'shoe_name' => $request->shoe_name,
            'brand'     => $request->brand,
            'price'     => $request->price,
            'category'  => $request->category,
            'gender'    => $request->gender,
            'color'     => $colors,
            'image_url' => $imagePaths,
        ]);

        return redirect()->route('admin.shoes.index')->with('success', 'Shoe updated successfully.');
    }

    // Soft delete
    public function softDelete(Shoe $shoe)
    {
        $shoe->update([
            'is_deleted' => true,
            'deleted_at' => now(),
        ]);

        return redirect()->route('admin.shoes.index')->with('success', 'Shoe moved to trash.');
    }

    // View trash
    public function trash()
    {
        $shoes = Shoe::trashed()->latest('deleted_at')->get();
        return view('dashboard.shoes.trash', compact('shoes'));
    }

    // Restore from trash
    public function restore(Shoe $shoe)
    {
        $shoe->update([
            'is_deleted' => false,
            'deleted_at' => null,
        ]);

        return redirect()->route('admin.shoes.trash')->with('success', 'Shoe restored.');
    }

    // Hard delete
    public function destroy(Shoe $shoe)
    {
        foreach ($shoe->image_url ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }
        $shoe->delete();

        return redirect()->route('admin.shoes.trash')->with('success', 'Shoe permanently deleted.');
    }
}
