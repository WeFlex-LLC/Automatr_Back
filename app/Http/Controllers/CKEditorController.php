<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tinify\Source;
use Tinify\Tinify;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            //$request->file('upload')->move(public_path('images'), $fileName);
            $optimizer = new Tinify();
            $optimizer->setKey("dlPPcwgBlTrplzpCbnJgxGkyPM0561M7");
            $file = Source::fromBuffer(file_get_contents($request->file('upload')->getPathname()));
            $file->toFile(public_path('images')."/".$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image successfully uploaded'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}
