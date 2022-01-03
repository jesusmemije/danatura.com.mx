<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Productos;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $productos=Productos::all();

        return view('admin.productos.index',['productos'=> $productos]);
    }

    /**Todo lo relacionado con las categorias de productos */

    public function categorias()
    {
        //

        $categorias=DB::table('categorias')->get();

        return view('admin.productos.categorias',['categorias'=> $categorias]);
    }

    public function nueva_categoria(Request $request){


        $hecho= DB::table('categorias')->insert([
            'tipo' => $request->nombrecategoria,
        ]);

        if($hecho){

            return redirect()->back()->with('success', 'La categoría se ha guardado correctamente.');  
        }else{

            return redirect()->back()->with('success', 'La categoría no se pudo registrar, intentelo de nuevo.');  
        }


    }

    
    public function editar_categoria(Request $request){

        
        DB::table('categorias')
        ->where('id','=',$request->idedit,)
        ->update([
           
           'tipo'=>$request->nuevonombre,
       ]);

        return redirect()->back()->with('success', 'Categoría actualizada');  
    }

    public function destroy_categoria(Request $request){

        
        DB::table('categorias')->where('id', '=', $request->id)->delete();
        return redirect()->back()->with('success', 'Categoría eliminada');  
    }

    public function respuesta_duda(Request $request)
    {
        //

        $dudas=DB::table('dudas_comentarios')
        ->where('id','=',$request->id)
        ->update([
            'respuesta'=>$request->respuesta
        ]);

        return redirect()->back()->with('success', 'Duda/Comentario actualizada');  
    }
    public function dudas_destroy(Request $request)
    {
        //

        DB::table('dudas_comentarios')->where('id', '=', $request->id)->delete();
        return redirect()->back()->with('success', 'Duda/Comentario eliminada');  
    }
    
    public function lista_dudas()
    {
        //

        $dudas=DB::table('dudas_comentarios')->get();


        return view('admin.productos.lista_dudas',['dudas'=> $dudas]);
    }

    public function lista_contacto()
    {
        //

        $contactos=DB::table('contacto')->get();

        return view('admin.productos.lista_contacto',['contactos'=> $contactos]);
    }


    public function  nl_correo_destroy(Request $request){
            
        DB::table('newsletter_subs')->where('id', '=', $request->id)->delete();
        return redirect()->back()->with('success', 'Subscriptor eliminado');  
    }
    public function newsletter_list(){

        $newsletter=DB::table('newsletter')->get();

        return view('admin.productos.newsletter_list',['newsletter'=> $newsletter]);
    }

    public function newsletter()
    {
        //

        $newsletter=DB::table('newsletter_subs')->get();

        return view('admin.productos.newsletter',['newsletter'=> $newsletter]);
    }

    public function newsletter_newv(Request $request){
        return view('admin.productos.newsletterv');
    }

    public function newsletter_new(Request $request){
        $validado=$request->validate([
            'correo' => 'email',
         
        ]);


        $existe= DB::table('newsletter_subs')
        ->where('correo','=',$request->correo)
        ->first();

        if(!empty($existe)){
            $response=['mensaje'=>"ya existe"];
            return redirect()->back()->with('error', 'repetido');  
            die();
        }


      
    

        $hecho= DB::table('newsletter_subs')->insert([
            'correo' => $request->correo,
        ]);

        if($hecho){
            $response=['mensaje'=>"bien"];
            return redirect()->back()->with('mensaje', 'bien');  
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $categorias=DB::table('categorias')->get();

        $producto=new Productos();

       return view('admin.productos.create',['producto'=> $producto,"categorias"=>$categorias]);
       unset($producto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


        $domain='http://';
        $galeria="";
        $asset=$_SERVER['DOCUMENT_ROOT'].'/assets/productos/';
        $asset_bd="$domain{$_SERVER['HTTP_HOST']}/assets/productos/";
     

        //Para la imagen.
        //Se guardan las imagenes del proyecto.
        if ($request->hasFile('fotografia')) {

            for ($i = 0; $i < sizeof($request->fotografia); $i++) {
                $nombre_img = $_FILES['fotografia']['name'][$i];
                $nombre_img=str_replace(' ', '', $nombre_img);
                $url = time() . $nombre_img;

                $fullurl=$asset_bd.$url;

               

                $galeria=$galeria.$fullurl.'|';
                
               move_uploaded_file($_FILES['fotografia']['tmp_name'][$i], $asset. $url);
            }
        }

       

      
        $producto=new Productos();

        $producto->nombre= $request->nombre;
        $producto->sabor= $request->sabor;
        $producto->descripcion= $request->descripcion;
        $producto->gramos= $request->gramos;
        $producto->precio= $request->precio;
        $producto->precio_mayorista= $request->precio_mayorista;
        $producto->precio_nutriologo= $request->precio_nutriologo;
       // $producto->fotografia= $url;
        $producto->galeria= $galeria;
        $producto->stock=$request->stock;

        if(!empty($request->nuevo)){
            $producto->nuevo=1;
        }else{
            $producto->nuevo=0;
        }
      

        $saved=$producto->save();

        //Para la categoría.
        $categoria= DB::table('categoriasproductos')->insert([
            'id_producto'=>$producto->id,
            'id_categoria'=>$request->categoria,
        ]);

        


        if($saved){
            //print_r("si");
            return redirect()->back()->with('success', 'good');  
        }else{
            //print_r("no");
            return redirect()->back()->with('error', 'bad');  
        }

         //Illuminate\Database\Eloquent\Factories\HasFactory'
        
        

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $producto=Productos::find($id);

        $producto = DB::table('productos')
        ->select('productos.*','cp.id_categoria as id_categoria')
        ->leftJoin('categoriasproductos as cp','productos.id','=','cp.id_producto')
        ->where('productos.id','=',$id)
        ->first();

      

      

        $categorias=DB::table('categorias')->get();
        
        
        return view('admin.productos.edit',['producto'=> $producto,'up'=> true,'categorias'=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

       
        $domain='http://';
        $galeria="";
        $asset=$_SERVER['DOCUMENT_ROOT'].'/pruebas/danatura/public/assets/productos/';
        $asset_bd="$domain{$_SERVER['HTTP_HOST']}/pruebas/danatura/public/assets/productos/";
     
        //Para la imagen.
        //Se guardan las imagenes del proyecto.
        
        if ($request->hasFile('fotografia')) {

            for ($i = 0; $i < sizeof($request->fotografia); $i++) {
                $nombre_img = $_FILES['fotografia']['name'][$i];
                $nombre_img=str_replace(' ', '', $nombre_img);
                $url = time() . $nombre_img;

                
                $fullurl=$asset_bd.$url;

               

                $galeria=$galeria.$fullurl.'|';
                
             move_uploaded_file($_FILES['fotografia']['tmp_name'][$i], $asset. $url);
            }
        }

        
      
        $galeria_real=$request->galeria.$galeria;


        $producto=Productos::find($id);
    
     

        $producto->nombre= $request->nombre;
        $producto->sabor= $request->sabor;
        $producto->descripcion= $request->descripcion;
        $producto->gramos= $request->gramos;
        $producto->precio= $request->precio;

        $producto->galeria=$galeria_real;
       

       $producto->precio_mayorista= $request->precio_mayorista;
       $producto->precio_nutriologo= $request->precio_nutriologo;
       $producto->stock=$request->stock;

       if(!empty($request->nuevo)){
        $producto->nuevo=1;
    }else{
        $producto->nuevo=0;
    }
  

        $updated=$producto->save();


         //Para la categoría.
         $categoria= DB::table('categoriasproductos')
         ->where('id_producto','=',$producto->id,)
         ->update([
            
            'id_categoria'=>$request->categoria,
        ]);


        if($updated){
            //print_r("si");
            return redirect()->back()->with('success', 'good');  
        }else{
            //print_r("no");
            return redirect()->back()->with('error', 'bad');  
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        Productos::destroy($id);
        return redirect()->back()->with('success', 'good');  
    }
}
