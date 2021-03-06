@extends('layouts.main', ['activePage' => 'permissions', 'titlePage' => 'Permisos'])
@section('content')
    <div class="content">
        <div class="container-fuid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-tittle">Permisos</h4>
                                    <p class="card-category">Permisos Registrados</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            @can('admin_create')
                                            <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-facebook">Añadir Permiso</a>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-primary">
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Guard</th>
                                                <th>Created_at</th>
                                                <th class="text-right">Acciones</th>
                                            </thead>
                                            <tbody>
                                                @forelse ($permissions as $permission)
                                                <tr>
                                                    <td>{{ $permission->id }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>{{ $permission->guard_name }}</td>
                                                    <td>{{ $permission->created_at }}</td>
                                                     <td class="td-actions text-right">
                                                        @can('admin_show')
                                                        <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                                        @endcan
                                                        @can('admin_edit')
                                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                                        @endcan
                                                        @can('admin_destroy')
                                                        <form action="{{route('permissions.destroy', $permission->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('¿Estás seguro?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit" rel="tooltip">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @empty
                                                No permissions registered yet.
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--footer-->
                                <div class="card-footer ml-auto mr-auto">
                                    {{ $permissions ?? ''->links() }}
                                </div>
                                <!--End footer-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
