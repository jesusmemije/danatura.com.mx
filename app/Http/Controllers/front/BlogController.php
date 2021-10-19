<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('front.blog.index', ['blogs' => $blogs]);
    }

    public function show( $id )
    {
        $blog = Blog::find( $id );
        return view('front.blog.show', ['blog' => $blog]);
    }

}
