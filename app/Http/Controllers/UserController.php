<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users=User::paginate(5);
        return view('users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all()->pluck('name', 'id');
        return view('users.create', compact('roles'));
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->only('name', 'rut', 'email')
            +[
                'password' => bcrypt($request->input('password')),
            ]);

        $roles = $request->input('roles', []);
        $user->syncRoles($roles);
        return redirect()->route('users.show', $user->id)->with('success', 'Usuario creado correctamente.');
    }

    public function Show(User $user)
    {
        //$user = User::findOrFail($id);
        //dd($user);
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        //$user = User::findOrFail($id);
        //dd($user);
        $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        //$user=User::findOrFail($id);
        $data = $request->only('name','rut','email');
        $password=$request->input('password');
        if($password)
            $data['password']=bcrypt($password);
        //if(trim($request->password)=='')
        //{
        //    $data=$request->except('password');
        //}
        //else {
        //    $data=$request->all();
        //    $data['password']=bcrypt($request->password);
        //}
        $user->update($data);
        $roles = $request->input('roles', []);
        $user->syncRoles('roles');
        return redirect()->route('users.show', $user->id)->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        if(auth()->user()->id == $user->id){
            return redirect()->route('users.index');
        }
        $user -> delete();
        return back()->with('success', 'Usuario eliminado correctamente');
    }
}