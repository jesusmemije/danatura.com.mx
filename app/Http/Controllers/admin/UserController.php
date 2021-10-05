<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios=User::all();

        return view('admin.usuarios.index',['usuarios'=> $usuarios]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('auth.register');
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
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           
        ]);

        $usuario = User::create([
            'name'        => strtoupper($request->name),
            'email'      => $request->email,
            'tipo'      => $request->tipo,
            'password' => Hash::make($request['password'])
           
            
        ])->save();
        
        return back()->with('status', ' Usuario registrado correctamente ');
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

        $usuario=User::find($id);
       


        return view('admin.usuarios.edit',['usuario'=>$usuario]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update_usuario(Request $request){

        $usuario=User::find($request->id_usuario);


        $usuario->name=$request->name;
        $usuario->email=$request->email;
        $usuario->tipo=$request->tipo;

        if($request->password!=''){

            $usuario->password=Hash::make($request['password']);
        }

        $usuario->save();

        if($usuario){
            return back()->with('success', ' Usuario actualizado correctamente ');
        }else{
            return back()->with('success', 'El usuario no se pudo actualizar');
        }


    }

    public function update(Request $request, $id)
    {
        //
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

        User::destroy($id);
        return redirect()->back()->with('success', 'good');
    }
}
