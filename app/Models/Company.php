<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    protected $table = 'companies';
    
    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name',        
    ];

    public function getList() {
        $companies = Company::all();
        return $companies;
    }

    //productsテーブルと紐づけ（１対多）
    public function products()
    {
        return $this->hasMany('App\Models\Product');
        //return $this->hasMany(Product::class);
    }
}
