<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function users() {
        return $this->hasMany(User::class);
    }

    public static function HasPermission($id)
    {
        $permission = Role::where('id', Auth::user()->role_id)->first();

        if (empty($permission['permissions']) || in_array($id, explode(',', $permission['permissions']))) {
            return true;
        }

        return false;
    }
}
