<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;

class ModNomeCertAdminController extends Controller
{
    function modifica(Request $request){
        $id = $request->input('id');
        $nome = $request->input('nome_'. $id);
        $certificate = Certificate::where('id', $id)->first();
        $certificate->nome = $nome;
        $certificate->save();

        return redirect('mod-certif');

    }
}
