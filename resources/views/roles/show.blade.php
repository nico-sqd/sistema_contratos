@extends('layouts.main',['activePage' => 'roles', 'titlePage' =>'Detalles del Rol'])
@section('content')
<div class="content">
    <div class="conteiner-fuid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="card-title">Permisos</div>
                        <p class="card-category">Vista detallada del permiso {{ $role->name}}</p>
                       </div>
                       <!--Body-->
                       <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('roles.index') }}" class="btn btn-success"><i class="material-icons">arrow_back</i></a>
                                </div>
                            </div>
                           <div class="row">
                               <div class="col-md-6">
                                   <div class="card card-user">
                                       <div class="card-body">
                                           <p class="card-text">
                                               <div class="autor">
                                                   <a href="#">
                                                       <img src="{{ asset('/img/faces/default-avatar.png')}}" alt="image" class="avatar col-sm-4">
                                                       <h5 class="title" mt-3>{{ $role->name}}</h5>
                                                   </a>
                                                   <p class="description">
                                                   {{ $role->guard_name}}  <br>
                                                   Creacion del Rol: {{ $role->created_at}}  <br>
                                                   </p>
                                               </div>
                                        </p>
                                         <div class="card-description">
                                            @forelse ($role->permissions as $permission)
                                                <span class="badge rounded-pill bg-dark text-white">{{ $permission->name }}</span>
                                            @empty
                                                <span class="badge badge-danger bg-danger">no Permissions</span>
                                            @endforelse
                                        </div>
                                       </div>
                                       <div class="card-footer">
                                        <div class="button-container">
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning "><i class="material-icons">edit</i></a>
                                       </div>
                                   </div>
                               </div><!-- end card user -->
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
