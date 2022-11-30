<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class Product extends Model
{
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function getHome() {
        $products = Product::all();
        //dd($products->companies());
        return $products;
    }

    //salesテーブルと紐づけ（１対多）
    public function sales(){
        return $this->hasMany('App\Models\Sale');
    }

    //companiesテーブルと紐づけ
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

}
