<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModIndAdminController extends Controller
{
    function mod_ind(Request $request){
        $indirizzo = $request->input('inputIndirizzo');
        $numeroCivico =  $request->input('inputNumeroCivico');
        $citta =  $request->input('inputCitta');
        $provincia =  $request->input('inputProvincia');
        $cap =    $request->input('inputCAP');

        $admin = auth()->user()->admin;

        $admin->street = $indirizzo;
        $admin->house_number = $numeroCivico;
        $admin->city = $citta;
        $admin->province = $provincia;
        $admin->postal_code = $cap;

        $admin->save();

        return redirect('mod-indirizzo-admin');
    }
}
