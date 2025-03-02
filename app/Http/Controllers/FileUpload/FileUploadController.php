<?php

namespace App\Http\Controllers\FileUpload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|mimes:txt|max:2048',
        ]);


//        $uploadedFiles = [];
//
//        foreach ($request->file('files') as $file) {
//            $path = $file->store('uploads', 'public'); // Zapis do storage/app/public/uploads
//            $uploadedFiles[] = $path;
//        }

        return back();
    }
}
