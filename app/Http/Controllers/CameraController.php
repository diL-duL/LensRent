<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Camera;
use App\Models\Category;

class CameraController extends Controller
{
    public function index()
    {
        $cameras = Camera::with('category')->get();
        $categories = Category::all();
        return view('admin.cameras.index', compact('cameras', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'brand' => 'required',
            'price_per_day' => 'required|integer',
            'description' => 'nullable'
        ]);

        Camera::create($data);
        return back()->with('success', 'Kamera berhasil ditambahkan.');
    }

    public function edit(Camera $camera)
    {
        $categories = Category::all();
        return view('admin.cameras.edit', compact('camera', 'categories'));
    }

    public function update(Request $request, Camera $camera)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'brand' => 'required',
            'price_per_day' => 'required|integer',
            'description' => 'nullable'
        ]);

        $camera->update($data);
        return redirect()->route('cameras.index')->with('success', 'Kamera berhasil diperbarui.');
    }

    public function destroy(Camera $camera)
    {
        $camera->delete();
        return back()->with('success', 'Kamera berhasil dihapus.');
    }
}
