<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $blog = new Blog();
        $blog->titulo = $request->titulo;
        $blog->contenido = $request->contenido;
        $blog->autor = $request->autor;
        $blog->estatus = $request->estatus;
        $blog->save();

        if( $blog->save() ){
            return redirect()->back()->with('success', 'good');  
        } else {
            return redirect()->back()->with('error', 'bad');  
        }

        return redirect()->back();
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;
            //Upload File
            $request->file('upload')->move(public_path('images'), $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/' . $filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output 
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
