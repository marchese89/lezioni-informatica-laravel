<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UploadPhotoAdminController extends Controller
{
    public function upload(Request $request)
    {

        $user = User::where('email', auth()->user()->email)->first();

        $id = $user->id;

        $admin = Admin::where('user_id',$id)->first();
        if($admin->photo !== null){
            File::delete(base_path('\public'). $admin->photo);
        }
        $file = $request->file('file');
        $name = $file->hashName();
        $file->move(base_path('\public\files'),$name);

        $path = '/files/' . $name;

        $admin->photo = $path;

        $admin->save();

        return redirect('mod-foto-admin');
    }

}
