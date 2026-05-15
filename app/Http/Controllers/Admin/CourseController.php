<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Matter;
use App\Models\Lesson;
use App\Models\Exercise;


class CourseController extends Controller
{
    public function index()
    {
        $materie = Matter::with('theme_area')->get();
        $corsi = Course::with('matter.theme_area')->get();
        return view('admin.nuovo-corso', compact('materie', 'corsi'));
    }

    public function list()
    {
        $corsi = Course::with('matter.theme_area')->get();

        return view('admin.elenco-corsi', compact('corsi'));
    }

    public function edit(int $id)
    {
        $corso = Course::findOrFail($id);

        $lezioni = Lesson::where('course_id', $id)->get();
        $esercizi = Exercise::where('course_id', $id)->get();

        return view('admin.modifica-corso', compact('corso', 'lezioni', 'esercizi'));
    }

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
