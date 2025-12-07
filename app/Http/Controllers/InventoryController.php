<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $medicines = Medicine::orderBy('stock', 'asc')->paginate(10); // Show low stock first
        return view('admin.inventory.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Medicine::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Medicine added to inventory.');
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('admin.inventory.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Medicine::findOrFail($id)->update($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy($id)
    {
        Medicine::findOrFail($id)->delete();
        return back()->with('success', 'Item removed from inventory.');
    }
}