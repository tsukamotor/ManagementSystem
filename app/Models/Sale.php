<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    //productsテーブルと紐づけ
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
