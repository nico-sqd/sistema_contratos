<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Direccion;

class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('direccion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $direccion = Direccion::create($request->only('direccion', 'comuna', 'region'));
        $proveedor = Proveedor::create(array_merge($request->only('nombre_proveedor', 'rut_proveedor', 'representante','rut_representante','mail_representante','telefono_representante'),['direccion_id'=>$direccion->id]));
        return redirect()->route('proveedor.index', $proveedor->id)->with('success', 'Usuario creado correctamente.');
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
    public function edit(Direccion $direccion)
    {
        return view('direccion.edit', compact('direccion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedores, Direccion $direccion)
    {
        $direccion->update($request->only('direccion', 'comuna', 'region'));
        $proveedores->update(array_merge($request->only('nombre_proveedor', 'rut_proveedor', 'representante','rut_representante','mail_representante','telefono_representante'),['direccion_id'=>$direccion->id]));

        return redirect()->route('proveedor.index', $proveedores->id)->with('success', 'Usuario actualizado correctamente.');
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
    }
}
