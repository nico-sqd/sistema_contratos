@extends('layouts.main', ['activePage' => 'administradores', 'titlePage' => 'Administradores'])
@section('content')
    <div class="content">
        <div class="container-fuid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-tittle">Tablas de Administradores</h4>
                                    <div class="row">
                                        <div class="col-7 text-right d-felx">
                                            <form action="{{route('administradores.index_administrador')}}" method="get">
                                                <div class="form-row">
                                                    <div class="col-sm-4 align-self-center" style="text-align: right">
                                                        <input type="text" class="form-control float-right" name="texto" value="{{$texto ?? ''}}" placeholder="Buscar...">
                                                    </div>
                                                    <div class="col-auto align-self-center">
                                                        <input type="submit" class="btn btn-primary float-right" value="Buscar">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="card-category">Datos de Administrador</p>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success" role="success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            @can('super_create')
                                            <a href="{{ route('administradores.create_administrador') }}" class="btn btn-sm btn-facebook">Añadir Usuario</a>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-primary">
                                                <th>Nombre</th>
                                                <th>Correo</th>
                                                <th>RUT</th>
                                                <th>Establecimiento</th>
                                                <th>ROL</th>
                                                <th class="text-right">Acciones</th>
                                            </thead>
                                            <tbody>
                                            @if (count($users)<=0)
                                                <div class="alert alert-danger" style="text-align:center" role="alert">
                                                    <h4>No se han encontrado administradores</h4>
                                                </div>
                                            @endif
                                                @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->rut }}</td>
                                                    <td>{{ $user->getEstablecimiento->establecimiento }}</td>
                                                    <td>
                                                        @forelse ($user->roles as $role)
                                                            <span class="badge badge-info">{{$role->name}}</span>
                                                        @empty
                                                        <span class="badge badge-danger">No roles</span>
                                                        @endforelse
                                                    </td>
                                                    <td class="td-actions text-right">
                                                        @can('admin_show')
                                                        <a href="{{ route('administradores.show_administrador', $user->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                                        @endcan
                                                        @can('admin_edit')
                                                        <a href="{{ route('administradores.edit_administrador', $user->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                                        @endcan
                                                        @can('admin_destroy')
                                                        <form action="{{route('users.delete', $user->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('¿Estás seguro?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit" rel="tooltip">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--footer-->
                                <div class="card-footer ml-auto mr-auto">
                                    {{ $users->links() }}
                                </div>
                                <!--End footer-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
