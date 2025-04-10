<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    private bool $list;
    private bool $create;
    private bool $edit;
    private bool $delete;
    public function __construct()
    {
        $this->list = Permission::getPermissionBySlugAndId('Product');
        $this->create = Permission::getPermissionBySlugAndId('Product', 'Create');
        $this->edit = Permission::getPermissionBySlugAndId('Product', 'Edit');
        $this->delete = Permission::getPermissionBySlugAndId('Product', 'Delete');
    }

    public function user_list()
    {
        if (! $this->list) {
            abort(403);
        }

        $data['users'] = User::get();

        return view('admin.user.index', compact('data'));
    }

    public function user_form($type, $id)
    {
        $permission = ($id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }

        $data['user'] = User::where('id', $id)->first();
        $data['roles'] = Role::get();

        return view('admin.user.edit', compact('data'));
    }

    public function save_user(Request $request)
    {
        $permission = ($request->id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }
        $id = ($request->id == 0) ? null : $request->id;
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'role_id' => 'required',
            'password' => $request->id == '0' ? 'required' : 'nullable',
        ]);

        $user = User::find($request->id);
    
        $password = ($request->id == '0' || !empty($request->password)) 
            ? Hash::make($request->password) 
            : ($user ? $user->password : null);

        User::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => (int) $request->role_id,
            'password' => $password
        ]);

        return to_route('user_list')->with('success', 'User created/updated successfully');
    }
}