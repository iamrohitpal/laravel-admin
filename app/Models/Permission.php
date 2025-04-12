<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = ['id'];

    public static function getAllPermission()
    {
        $allPermission = Permission::groupBy('groupby')->get();
        $results = [];
        foreach ($allPermission as $permission) {
            $allData = Permission::getPermissionByGroup($permission->groupby);
            $data['id'] = $permission->id;
            $data['name'] = $permission->name;
            $allType = [];
            foreach ($allData as $allDataByGroup) {
                $allType[] = ['id' => $allDataByGroup->id, 'name' => $allDataByGroup->name];
            }
            $data['permission'] = $allType;
            $results[] = $data;
        }

        return $results;
    }

    public static function getPermissionByGroup($group)
    {
        $allPermission = Permission::where('groupby', $group)->get();

        return $allPermission;
    }

    public static function getPermissionBySlugAndId(string $name, ?string $type = null): bool
    {
        $type = ! empty($type) ? $type : $name;
        $permissionType = Permission::where('slug', $name)->first();
        $allPermission = null;
        if ($permissionType) {
            $allPermission = Permission::where(['slug' => $type, 'groupby' => $permissionType->groupby])->first();
        }

        return Role::HasPermission($allPermission?->id);
    }
}
