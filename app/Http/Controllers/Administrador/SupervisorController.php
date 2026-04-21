<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supervisor;

class SupervisorController extends Controller
{

    public function __construct(){
        $this->middleware('adlog');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $supervisores = Supervisor::where('id_administrador',GetId())->paginate(15);
        return view('administradores.supervisores.index',['supervisores'=>$supervisores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(ValidarMail($request->mail)){
            return redirect('administracion/supervisores')->with('error','Ingresar un correo diferente, con el que intentó ya está registrado.');
        }
        $supervisor = new Supervisor();
        $supervisor->id = GetUuid();
        $supervisor->id_administrador=GetId();
        $supervisor->nombres = $request->nombres;
        $supervisor->apellidos = $request->apellidos;
        $supervisor->mail = $request->mail;      
        $supervisor->telefono = $request->telefono;        
        $supervisor->pass = '';
        $supervisor->token = '';   
        $supervisor->save();
        return redirect('administracion/supervisores')->with('success','Datos Guardados.');
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
        if(ValidarMail($request->mail)){
            return redirect('administracion/supervisores')->with('error','Ingresar un correo diferente, con el que intentó ya está registrado.');
        }
        $supervisor = Supervisor::find($id);
        
        $supervisor->nombres = $request->nombres;
        $supervisor->apellidos = $request->apellidos;
        
        if(isset($request->mail))
        $supervisor->mail = $request->mail;
        
        $supervisor->save();
        return redirect('administracion/supervisores')->with('success','Datos Guardados.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supervisor = Supervisor::find($id);
        $supervisor->delete();
        return redirect('administracion/supervisores')->with('error','Registro Borrado.');
    }


    function BorrarSupervisor($id){        

        $supervisor = Supervisor::find($id);

        return view('administradores.supervisores.destroy',['supervisor'=>$supervisor]);
    }
}
