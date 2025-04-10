<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $guarded = ['id'];

    public function specifications()
    {
        return $this->hasManyThrough(
            DB::table('product_specifications')->getModel(), // Use raw table name
            'product_id', 'id'
        );
    }
}
