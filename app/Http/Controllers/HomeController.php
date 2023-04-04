<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class HomeController extends Controller
{
    //
      public function index()
    {
         $posts = Movie::getMovie();
        return view('index', [
            "title" => "MwoMovie",
            'posts' => $posts,
            "active" => 'home'
        ]);
    }
}
