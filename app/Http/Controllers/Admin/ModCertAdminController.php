<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ModCertAdminController extends Controller
{
    public function upload(Request $request)
    {

        $id =  $request->input('id');
        $certificate = Certificate::where('id', $id)->first();

        if($certificate->percorso_file !== null){
            File::delete(base_path('\public'). $certificate->percorso_file);
        }
        $file = $request->file('file_'. $id);
        $name = $file->hashName();
        $file->move(base_path('\public\files\cert_admin'),$name);

        $path = '/files/cert_admin/' . $name;

        $certificate->percorso_file = $path;

        $certificate->save();

        return redirect('mod-certif');
    }
}
