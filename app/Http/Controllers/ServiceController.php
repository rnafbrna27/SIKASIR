<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Category;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $services = Service::with('category')
                       ->latest()
                       ->get();

    return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
    $categories = Category::orderBy('name')->get();

    return view('services.create', compact('categories'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    
        public function store(Request $request)
    {
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'unit' => 'required|max:100',
        'description' => 'nullable',
    ]);

    Service::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'price' => $request->price,
        'unit' => $request->unit,
        'description' => $request->description,
    ]);

    return redirect()->route('services.index')
                     ->with('success', 'Layanan berhasil ditambahkan.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = Category::orderBy('name')->get();

        return view('services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
          $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'unit' => 'required|max:100',
        'description' => 'nullable',
    ]);

    $service->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'price' => $request->price,
        'unit' => $request->unit,
        'description' => $request->description,
    ]);

    return redirect()->route('services.index')
                     ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
         $service->delete();

        return redirect()
        ->route('services.index')
        ->with('success', 'Layanan berhasil dihapus.');
    }
}
