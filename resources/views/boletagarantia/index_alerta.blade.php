@extends('layouts.main', ['activePage' => 'contratos', 'titlePage' => 'Documentos de Garantía'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('boletagarantia.index_alerta')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-tittle">Documentos de Garantía</h4>
                            <p class="card-category">Documentos por vencer</p>
                        </div>
                        <div class="card-body">
                        <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('home') }}" class="btn btn-facebook"><i class="material-icons">home</i> Home</a>
                                </div>
                            </div>
                        <!--footers-->
                        <!--End footer-->
                    </div>
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>Documento Garantía</th>
                                <th>Institución</th>
                                <th>N° Documento</th>
                                <th>Monto</th>
                                <th>Fecha Vencimiento</th>
                            </thead>
                            <tbody>
                                @foreach($montoboleta as $boleta)
                                    @foreach ($id_boleta as $id)
                                        @if ($id == $boleta->id)
                                        <tr>
                                            @if ($boleta->boletagarantia->documentos_garantia == 'Otro')
                                                <td>{{ $boleta->otraboleta }}</td>
                                            @else
                                                <td>{{ $boleta->boletagarantia->documentos_garantia }}</td>
                                            @endif
                                            <td>{{ $boleta->institucion }}</td>
                                            <td>{{ $boleta->id_boleta }}</td>
                                            @if ($boleta->tipomoneda->Nombre_tipo == 'CLP')
                                            <td>$ {{ number_format($boleta->monto_boleta) }} {{$boleta->tipomoneda->Nombre_tipo}}</td>
                                            @endif
                                            @if ($boleta->tipomoneda->Nombre_tipo == 'USD')
                                            <td>$ {{ number_format($boleta->monto_boleta,2,',','.') }} {{$boleta->tipomoneda->Nombre_tipo}}</td>
                                            @endif
                                            @if ($boleta->tipomoneda->Nombre_tipo == 'UF')
                                            <td>$ {{ number_format($boleta->monto_boleta) }} {{$boleta->tipomoneda->Nombre_tipo}}</td>
                                            @endif
                                            <td>{{ $boleta->fecha_vencimiento }}</td>
                                            <td class="td-actions text-right">
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
