<?php

namespace App\Http\Controllers;

use App\Models\{fwall,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FwallController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lista = User::all()->where('adm', 0)->sortBy('name');
        return view ('usuarios', ['usuarios'=>$lista]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $checkUs=User::all()->where('name', 'like', $request->name)->first();
        $checkMa=User::all()->where('email', 'like', $request->email)->first();
        if (isset($checkUs->name)){
            $err = 'mensajeNo';
            $msj = 'El USUARIO '.$request->name.' ya existe';
        }elseif(isset($checkMa->email)){
            $err = 'mensajeNo';
            $msj = 'El EMAIL '.$request->email.' ya existe';
        }else{
            if ($request->password==$request->password_confirmation){
                $agrego = new User();
                $agrego->name = $request->name;
                $agrego->email = $request->email;
                $agrego->password = Hash::make($request->password);
                $agrego->adm = '0';
                $agrego->save();
                $err = 'mensajeOk';
                $msj = $request->name.' agregado correctamente';
            }else{
                $err = 'mensajeNo';
                $msj = ' Las Claves no coinciden';
    }
    }
        return redirect()->route('lista.index')->with($err,$msj);

    } 

    /**
     * Display the specified resource.
     */
    public function show(fwall $fwall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(fwall $fwall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function del(Request $request)
    {
        if (isset($request->usuario)){
            User::where('name', $request->us )->delete();
            $msj= "Del id ".$request->us." se eliminó solo de la rutina de escaneo.";
        }
        if (isset($request->todo)){
            User::where('name', $request->us )->delete();
            fwall::where('userId', $request->us)->delete();
            $msj= "Del id ".$request->us." se eliminó rutina de escaneo e historial de bloqueos.";
        }
        if (isset($request->registro)){
            fwall::where('userId', $request->us)->delete();
            $msj= "Del id ". $request->us." se eliminó solo historial de bloqueos.";
        }
        return redirect()->route('lista.index')->with('mensajeOk',$msj);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fwall $fwall)
    {
        //
    }
}
