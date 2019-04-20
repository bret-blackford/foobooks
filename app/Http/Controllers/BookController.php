<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show($title = null) {
        return view('show')->with(['title'=>$title]);
    }
}
