<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ShoeController extends Controller
{
    public function index(Request $request)
    {
        $query = Shoe::active();

        // Filter by the new Category ID
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by the existing Gender string
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $shoes = $query->latest()->get();
        return view('layouts.index', compact('shoes'));
    }

    public function create()
    {
        return view('layouts.create');
    }

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
                $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));

                $result = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                    'folder' => 'solesearch/shoes'
                ]);
                $imagePaths[] = $result['secure_url'];
            }
        }
        Shoe::create([
            'shoe_name' => $request->shoe_name,
            'brand'     => $request->brand,
            'price'     => $request->price,
            'category'  => $request->category,
            'gender'    => $request->gender,
            'color'     => $colors,
            'image_url' => $imagePaths, // This now stores full https://res.cloudinary.com/... links
        ]);

        return redirect()->route('admin.shoes.index')->with('success', 'Shoe added successfully.');
    }

    public function edit(Shoe $shoe)
    {
        return redirect()->route('admin.shoes.index');
    }

    public function update(Request $request, Shoe $shoe)
    {
        $request->validate([
        'shoe_name'   => 'required|string',
        'brand'       => 'required|string',
        'price'       => 'required|numeric',
        'category_id' => 'nullable|exists:categories,id',
        'gender'      => 'nullable|string',
        'color'       => 'nullable|string',
        'images.*'    => 'nullable|image|max:2048',
    ]);

        $colors = array_map('trim', explode(',', $request->color));

        // Start from the existing images still marked as kept
        $keptUrls   = $request->input('existing_images', []);
        $deleteUrls = $request->input('delete_images', []);

        // Delete removed images from Cloudinary
        foreach ($deleteUrls as $url) {
            $publicId = 'solesearch/shoes/' . pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $cloudinary->uploadApi()->destroy($publicId);
        }

        $imagePaths = $keptUrls;

        // Upload any new images (use same method as store())
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
                $result = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                    'folder' => 'solesearch/shoes'
                ]);
                $imagePaths[] = $result['secure_url'];
            }
        }

        $shoe->update([
            'shoe_name'   => $request->shoe_name,
            'brand'       => $request->brand,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'gender'      => $request->gender,
            'color'       => $colors,
            'image_url'   => $imagePaths,
        ]);

        return redirect()->route('admin.shoes.index')->with('success', 'Shoe updated successfully.');
    }

    public function softDelete(Shoe $shoe)
    {
        $shoe->update([
            'is_deleted' => true,
            'deleted_at' => now(),
        ]);

        return redirect()->route('admin.shoes.index')->with('success', 'Shoe moved to trash.');
    }

    public function trash()
    {
        $shoes = Shoe::trashed()->latest('deleted_at')->get();
        return view('layouts.shoes-trash', compact('shoes'));
    }

    public function restore(Shoe $shoe)
    {
        $shoe->update([
            'is_deleted' => false,
            'deleted_at' => null,
        ]);

        return redirect()->route('admin.shoes.trash')->with('success', 'Shoe restored.');
    }

    public function destroy(Shoe $shoe)
    {
        // Delete images from Cloudinary
        foreach ($shoe->image_url ?? [] as $url) {
            $publicId = 'solesearch/shoes/' . pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $cloudinary->uploadApi()->destroy($publicId);
        }

        $shoe->delete();

        return redirect()->route('admin.shoes.trash')->with('success', 'Shoe permanently deleted.');
    }
}
