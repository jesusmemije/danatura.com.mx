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

    public function index_en()
    {
        $blogs = Blog::all();

        return view('front.en.blog.index_en', ['blogs' => $blogs]);
    }

    public function show(Request $request)
    {

        $blog = Blog::find($request->id);

        return view('front.blog.show', ['blog' => $blog]);
    }

    public function show_en(Request $request)
    {

        $blog = Blog::find($request->id);

        return view('front.en.blog.show_en', ['blog' => $blog]);
    }
}
