<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Matter;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\Order;
use App\Models\OrderProduct;


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

    public function mieiCorsi(Request $request)
    {
        $userId = $request->user()->id;

        $orderIds = Order::where('student_id', $userId)->pluck('id');

        $productRows = OrderProduct::whereIn('id_ordine', $orderIds)->get();

        $courseIds = [];

        foreach ($productRows as $row) {
            if ($row->tipo_prodotto == 0) {
                $lesson = Lesson::find($row->id_prodotto);
                if ($lesson) {
                    $courseIds[] = $lesson->course_id;
                }
            }

            if ($row->tipo_prodotto == 2) {
                $exercise = Exercise::find($row->id_prodotto);
                if ($exercise) {
                    $courseIds[] = $exercise->course_id;
                }
            }
        }

        $courseIds = array_unique($courseIds);

        $courses = Course::with('matter.theme_area')
            ->whereIn('id', $courseIds)
            ->get();

        return view('studente.elenco-corsi', compact('courses'));
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
