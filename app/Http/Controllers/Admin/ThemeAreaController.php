<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThemeArea;

class ThemeAreaController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        ThemeArea::create([
            'name' => $data['name']
        ]);

        return back()->with('success', 'Area tematica creata');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $themeArea = ThemeArea::findOrFail($id);

        $themeArea->update([
            'name' => $data['name']
        ]);

        return back()->with('success', 'Area tematica aggiornata');
    }

    // DELETE
    public function destroy($id)
    {
        ThemeArea::findOrFail($id)->delete();

        return back()->with('success', 'Area tematica eliminata');
    }
}
