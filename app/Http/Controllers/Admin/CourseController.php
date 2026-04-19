<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'materia' => 'required|exists:matters,id',
            'corso' => 'required|string|max:255',
        ]);

        Course::create([
            'name' => $data['corso'],
            'matter_id' => $data['materia'],
        ]);

        return back()->with('success', 'Corso creato');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $course = Course::findOrFail($id);

        $course->update([
            'name' => $data['nome'],
        ]);

        return back()->with('success', 'Corso aggiornato');
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();

        return back()->with('success', 'Corso eliminato');
    }
}
