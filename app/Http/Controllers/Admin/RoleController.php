<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Auth;
use Hash;
use DB;

class RoleController extends Controller
{
    public function role_list()
    {
        if (! Permission::getPermissionBySlugAndId('Role')) {
            abort(403);
        }

        $data['roles'] = Role::get();

        return view('admin.role.index', compact('data'));
    }

    public function role_form($type, $id)
    {
        if (! Permission::getPermissionBySlugAndId('Role')) {
            abort(403);
        }

        $data['role'] = Role::where('id', $id)->first();
        $data['type'] = [
            'all'    => 'All',
            'custom' => "Custom",
        ];
        $data['permission'] = Permission::getAllPermission();

        return view('admin.role.edit', compact('data'));
    }

    public function save_role(Request $request)
    {
        if (! Permission::getPermissionBySlugAndId('Role')) {
            abort(403);
        }

        $validate = $request->validate([
            'name' => 'required|unique:roles,name,'.$request->id,
            'permission_type' => 'required',
        ]);

        Role::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'description' => $request->description,
            'permission_type' => $request->permission_type,
            'permissions' => $request->permissions ? implode(',', $request->permissions) : null
        ]);

        return to_route('role_list')->with('success', 'Role created/updated successfully');
    }
}