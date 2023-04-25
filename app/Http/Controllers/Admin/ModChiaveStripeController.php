<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModChiaveStripeController extends Controller
{

    function modifica(Request $request){
        $chiave = $request->input('chiave');
        $admin = auth()->user()->admin;

        $admin->stripe_private_key = $chiave;

        $admin->save();

        return redirect('mod-chiave-priv-stripe');
    }
}
