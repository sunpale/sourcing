<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function viewImage($path,$filename){
        $file = storage_path('app/private/images/'.$path.'/'.$filename);
        return response()->file($file);
    }

    public function viewThumbnail($path,$filethumb){
        $file = storage_path('app/private/images-conversions/'.$path.'/'.$filethumb);
        return response()->file($file);
    }
}
