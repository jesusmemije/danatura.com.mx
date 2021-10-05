<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blogs;

class BlogController extends Controller{



    public function index(){

        $blogs=Blogs::all();

       return view('admin.blogs.index',['blogs'=>$blogs]);
    }

    public function create(){

        return view('admin.blogs.create');
    }

    public function store(Request $request){

       $blogs=new Blogs();
       $blogs->titulo=$request->titulo;
       $blogs->cotenido=$request->cotenido;
       $blogs->autor=$request->autor;
       $blogs->estatus=$request->estatus;
        $blogs->save();
       
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
       
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
       
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
       
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
       
            //Upload File
            $request->file('upload')->move(public_path('images'), $filenametostore);
     
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore); 
            $msg = 'Image successfully uploaded'; 
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
              
            // Render HTML output 
            @header('Content-type: text/html; charset=utf-8'); 
            echo $re;
        }
    }

}