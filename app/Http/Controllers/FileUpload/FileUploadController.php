<?php

namespace App\Http\Controllers\FileUpload;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUpload\FileUploadRequest;

class FileUploadController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        $requestValidated = $request->validated();

        foreach ($requestValidated['files'] as $file) {

        }


        // TODO:
        //  1. Konwersja na docelowy string
        //  2. Sprawdzenie jaka lista
        //  3. Generowanie pliku PDF


//        $uploadedFiles = [];
//
//        foreach ($request->file('files') as $file) {
//            $path = $file->store('uploads', 'public'); // Zapis do storage/app/public/uploads
//            $uploadedFiles[] = $path;
//        }

        return back();
    }
}
