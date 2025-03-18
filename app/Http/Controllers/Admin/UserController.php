<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Auth;
use Hash;
use DB;

class UserController extends Controller
{
    public function user_list()
    {
        if (! Permission::getPermissionBySlugAndId('User')) {
            abort(403);
        }

        $data['users'] = User::get();

        return view('admin.user.index', compact('data'));
    }

    public function user_form($type, $id)
    {
        if (! Permission::getPermissionBySlugAndId('User')) {
            abort(403);
        }

        $data['user'] = User::where('id', $id)->first();
        $data['roles'] = Role::get();

        return view('admin.user.edit', compact('data'));
    }

    public function save_user(Request $request)
    {
        if (! Permission::getPermissionBySlugAndId('User')) {
            abort(403);
        }
        
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$request->id,
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