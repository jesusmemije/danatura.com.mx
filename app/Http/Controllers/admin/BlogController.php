<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Storage;
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

        $domain='http://';
        $imagen="";
        $asset=$_SERVER['DOCUMENT_ROOT'].'/assets/blogs/';
        $asset_bd="$domain{$_SERVER['HTTP_HOST']}/assets/blogs/";
     

        //Para la imagen.
        //Se guardan las imagenes del proyecto.
        if ($request->hasFile('portada')) {

            for ($i = 0; $i < sizeof($request->portada); $i++) {
                $nombre_img = $_FILES['portada']['name'][$i];
                $nombre_img=str_replace(' ', '', $nombre_img);
                $url = time() . $nombre_img;

                $fullurl=$asset_bd.$url;

               

                $imagen=$imagen.$fullurl.'|';
                
               move_uploaded_file($_FILES['portada']['tmp_name'][$i], $asset. $url);
            }
        }

        $blog = new Blog();
        $blog->portada = $imagen;
        $blog->titulo = $request->titulo;
        $blog->contenido = $request->contenido;
        $blog->resumen = $request->resumen;
        $blog->autor = $request->autor;
        $blog->estatus = $request->estatus;
        $save = $blog->save();

        if( $save ){
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

    public function edit($id)
    {
        $blogs = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blogs'));
    }

    public function update(Request $request, $id)
    {

        $domain='http://';
        $imagen="";
        $asset=$_SERVER['DOCUMENT_ROOT'].'/assets/blogs/';
        $asset_bd="$domain{$_SERVER['HTTP_HOST']}/assets/blogs/";
     
        //Para la imagen.
        //Se guardan las imagenes del proyecto.
        
        if ($request->hasFile('portada')) {

            for ($i = 0; $i < sizeof($request->portada); $i++) {
                $nombre_img = $_FILES['portada']['name'][$i];
                $nombre_img = str_replace(' ', '', $nombre_img);
                $url = time() . $nombre_img;

                
                $fullurl=$asset_bd.$url;

               

                $imagen=$imagen.$fullurl.'|';
                
             move_uploaded_file($_FILES['portada']['tmp_name'][$i], $asset. $url);
            }
        }

        $imagen_real=$request->imagen.$imagen;

        $blog = Blog::findOrFail($id);
        $blog->portada = $imagen_real;
        $blog->titulo = $request->titulo;
        $blog->contenido = $request->contenido;
        $blog->resumen = $request->resumen;
        $blog->autor = $request->autor;
        $blog->estatus = $request->estatus;
        $blog->update();

        if( $blog->update() ){
            return redirect()->route('blogs.index')->with('success', 'good');  
        } else {
            return redirect()->back()->with('error', 'bad');  
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        if( $blog->delete() ){
            return redirect()->back()->with('success', 'good');  
        } else {
            return redirect()->back()->with('error', 'bad');  
        }

        return redirect()->back();
    }

}
