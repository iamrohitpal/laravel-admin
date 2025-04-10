<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
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

    public function role_list()
    {
        if (! $this->list) {
            abort(403);
        }

        $data['roles'] = Role::get();

        return view('admin.role.index', compact('data'));
    }

    public function role_form($type, $id)
    {
        $permission = ($id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
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
        $permission = ($request->id == '0') ? $this->create : $this->edit;
        if (! $this->list || ! $permission) {
            abort(403);
        }
        $id = ($request->id == 0) ? null : $request->id;
        $validate = $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
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