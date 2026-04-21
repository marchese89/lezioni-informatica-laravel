<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrazioneController extends Controller
{
    public function carica_utente(Request $request)
    {
        // Validazione
        $data = $request->validate([
            'inputNome' => 'required|string|max:255',
            'inputCognome' => 'required|string|max:255',
            'inputEmail' => 'required|email|unique:users,email',
            'inputPassword' => 'required|string|min:6',
            'inputIndirizzo' => 'required|string|max:255',
            'inputNumeroCivico' => 'required|string|max:10',
            'inputCitta' => 'required|string|max:255',
            'inputProvincia' => 'required|string|max:255',
            'inputCAP' => 'required|string|max:10',
            'inputCF' => 'required|string|max:16',
        ]);

        DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['inputNome'],
                'surname' => $data['inputCognome'],
                'email' => $data['inputEmail'],
                'password' => Hash::make($data['inputPassword']),
                'activation_code' => Str::random(6),
                'remember_token' => Str::random(10),
            ]);

            $user->student()->create([
                'street' => $data['inputIndirizzo'],
                'house_number' => $data['inputNumeroCivico'],
                'city' => $data['inputCitta'],
                'province' => $data['inputProvincia'],
                'postal_code' => $data['inputCAP'],
                'cf' => $data['inputCF'],
                'remember_token' => Str::random(10),
            ]);
        });

        return redirect()->route('registrazione_ok');
    }
}
