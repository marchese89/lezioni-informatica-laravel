<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feedback;

class HomeController extends Controller
{
    public function index()
    {
        $admin = User::where('role', 'admin')->first()->admin;

        $feedbacks = Feedback::with('student.user')->get();

        $avg = $feedbacks->avg('punteggio');

        return view('index', compact('admin', 'feedbacks', 'avg'));
    }
}
