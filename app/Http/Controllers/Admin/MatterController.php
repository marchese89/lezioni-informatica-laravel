<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matter;
use App\Models\ThemeArea;

class MatterController extends Controller
{
    public function index()
    {
        $materie = Matter::with('theme_area')->get();
        $aree_t = ThemeArea::all();
        return view('admin.materie', compact('materie', 'aree_t'));
    }

    public function publicIndex(int $id_at)
    {
        $materie = Matter::where('theme_area_id', $id_at)->get();
        return view('public.materie', compact('materie'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'area-t' => 'required|exists:theme_areas,id',
            'materia' => 'required|string|max:255',
        ]);

        Matter::create([
            'name' => $data['materia'],
            'theme_area_id' => $data['area-t'],
        ]);

        return redirect()->back()->with('success', 'Materia creata');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $materia = Matter::findOrFail($id);

        $materia->update([
            'name' => $data['nome'],
        ]);

        return redirect()->back()->with('success', 'Materia aggiornata');
    }

    public function destroy($id)
    {
        $materia = Matter::findOrFail($id);
        $materia->delete();

        return redirect()->back()->with('success', 'Materia eliminata');
    }
}
