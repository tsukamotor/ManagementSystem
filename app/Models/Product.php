<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Http\Requests\ManagementRequest;


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
        return $products;
    }

    public function getId($id) {
        $product = Product::find($id);
        return $product;
    }

    public function getQuery() {
        $query = Product::query();
        return $query;
    }

    public function getSearch($query, $keyword, $drpCompany) {
        //テーブル結合
        $query = DB::table('products')  // 主となるテーブル名
            //productsテーブルのカラムを下記のようにする（companiesテーブルのidをcompany_idにカラム名変更。）
            ->select('products.id', 'products.product_name', 'products.price', 'products.stock', 'products.comment', 'products.img_path', 'products.created_at', 'products.updated_at', 'companies.id as company_id', 'companies.company_name')
             // 第一引数に結合するテーブル名、第二引数に主テーブルの結合キー、第四引数に結合するテーブルの結合キーを記述
            ->join('companies', 'products.company_id', '=', 'companies.id');

        if(!empty($drpCompany)) {
            $query->where('company_name', 'LIKE', $drpCompany);
        }

        if(!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }
        return $query;
    }

    //salesテーブルと紐づけ（１対多）
    public function sales(){
        return $this->hasMany('App\Models\Sale');
    }

    //companiesテーブルと紐づけ
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

    //新規/編集登録処理
    public function productId($request, $product){
        //companiesテーブルからIDを検索
        $query = Company::whereCompany_name($request->company_id)->first();

        $product->company_id = $query->id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $path = $request->file('img_path')->store('public/images');
        $product->img_path = basename($path);
        $product->save();
    }

}
