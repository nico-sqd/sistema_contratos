<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contrato;
use App\Models\Monto;
use App\Models\BoletaGarantia;
use App\Models\MontoBoleta;
use App\Models\Modalidad;
use App\Models\TipoMoneda;
use App\Models\Convenio;
use App\Models\Proveedor;
use App\Models\User;
use App\Models\EstadoContrato;
use App\Models\Files;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $contratos = Contrato::with('convenio')
        ->whereHas('convenio', function (Builder $query) use ($texto) {
            $query->whereRaw('UPPER(id_licitacion) LIKE ?', ['%' . strtoupper($texto) . '%']);
            $query->orWhere('vigencia_inicio','LIKE','%'.$texto.'%');
            $query->orWhere('vigencia_fin','LIKE','%'.$texto.'%');
            $query->orWhereRaw('UPPER(admin) LIKE ?', ['%' . strtoupper($texto) . '%']);
            $query->orWhereRaw('UPPER(convenio) LIKE ?', ['%' . strtoupper($texto) . '%']);
        })
        ->orwhereHas('proveedor', function (Builder $query) use ($texto) {
            $query->Where('rut_proveedor','LIKE','%'.$texto.'%');
        })
        ->orwhereHas('user', function (Builder $query) use ($texto) {
            $query->whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($texto) . '%']);
        })
        //->whereRelation('Convenio', 'admin', Auth::id()) //--------(filrar contratos por id)------------
        ->orderBy('id','asc')
        ->paginate(5);
        return view('contratos.index', compact('contratos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contratos.create',['proveedor'=>Proveedor::all(),'referente'=>User::role('Referente')->get(),'admin'=>User::role('Administrador')->get(),
        'tipomoneda'=>TipoMoneda::all(),'tipoboleta'=>BoletaGarantia::all(),
        'modalidad'=>Modalidad::all(),'montoboletagarantia'=>MontoBoleta::all(),'id_licitacion'=>Convenio::all(),
        'monto'=>Monto::all(),'contratos'=>Contrato::all(),'estadocontrato'=>EstadoContrato::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        //dd($request->descripcion);
        $convenios = Convenio::create(array_merge($request->only('id_licitacion', 'convenio', 'rut_proveedor','rut','vigencia_inicio','vigencia_fin','admin')));
        $montoboleta = Monto::create($request->only('moneda', 'id_tipo_moneda'));
        $boletagarantia = MontoBoleta::create($request->only('id_boleta','id_tipo_boleta')); //crear ID Boleta garant??a en migraci??n, controlador y vista.
        $contrato = Contrato::create(array_merge($request->only('id_licitacion','id_contrato','res_adjudicacion','res_apruebacontrato','rut_proveedor','rut','id_modalidad','aumento_contrato','res_aumento','id_tipo_moneda','estado_contrato','descripcion'),
        ['id_monto'=>$montoboleta->id,'rut_proveedor'=>$convenios->rut_proveedor,'rut'=>$convenios->rut,'id_licitacion'=>$convenios->id,'id_boleta'=>$boletagarantia->id_tipo_boleta,'id_monto_boleta'=>$boletagarantia->id]));
        /**$archivo = $request->all();
        $archivo['uuid'] = (string) Str::uuid();
        $archivo['user_rut'] = $convenios->user->id;

        if($request->hasFile('nombre_archivo')){
            $archivo['nombre_archivo'] = $request->file('nombre_archivo')->getClientOriginalName();
            $request->file('nombre_archivo')->storeAs('folder_file',$archivo['nombre_archivo']);
        }
        //dd($request);
        Files::create($archivo);**/
        return redirect()->route('contratos.index', $contrato->id)->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        return view('contratos.show', compact('contrato'), ['proveedores'=>Proveedor::all(),'convenios'=>Convenio::all(),'estadocontraot'=>EstadoContrato::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrato $contratos)
    {
        return view('contratos.edit', compact('contratos'),['tipomoneda'=>TipoMoneda::all(),'tipoboleta'=>BoletaGarantia::all(),
        'modalidad'=>Modalidad::all(),'montoboletagarantia'=>MontoBoleta::all(),'id_licitacion'=>Convenio::all(),'monto'=>Monto::all(),
        'proveedor'=>Proveedor::all(),'referente'=>User::role('Referente')->get(),'admin'=>User::role('Administrador')->get(),
        'estadocontrato'=>EstadoContrato::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Contrato $contrato)
    {
        $montoboleta = $contrato->monto;
        $boletagarantia = $contrato->montoboleta;
        $user = $contrato->convenio->user;
        $convenios = $contrato->convenio;
        $user->update($request->only('name'));
        $convenios->update(array_merge($request->only('rut_proveedor','rut','id_licitacion', 'convenio', 'vigencia_inicio','vigencia_fin','admin')));
        $montoboleta->update($request->only('moneda', 'id_tipo_moneda'));
        $boletagarantia->update($request->only('id_boleta','id_tipo_boleta'));
        $contrato->update(array_merge($request->only('id_licitacion','id_contrato','res_adjudicacion','res_apruebacontrato','id_modalidad','aumento_contrato','res_aumento','id_tipo_moneda','estado_contrato','descripcion'),['id_licitacion'=>$convenios->id]));
        return redirect()->route('contratos.index', $contrato->id)->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrato $contrato)
    {
        $contrato -> delete();
        return redirect()->route('contratos.index');
    }
}
