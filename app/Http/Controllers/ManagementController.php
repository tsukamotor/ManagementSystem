<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;
use App\Http\Requests\ManagementRequest;

class ManagementController extends Controller
{
    //削除
    public function destroy($id){
        // productsテーブルから指定のIDのレコード1件を取得
        $product = Product::find($id);
        // レコードを削除
        $product->delete();
        // 削除したらhome画面にリダイレクト
        return redirect()->route('home')->with('flash_message', 'ID：'.$id.'の商品を一覧から削除しました');
    }

    //詳細画面
    public function showInformation($id){
        $product = Product::find($id);
        return view('information', ['product' => $product,]);
    }

    //新規登録画面
    public function showAdd(Request $request, Product $product){
        $company_list = Company::all();
        return view('add', compact('product','company_list'));
    }

    //新規登録処理
    public function update(ManagementRequest $request, Product $product ,Company $company){
        $company_list = Company::all();
        $query = Company::all();

        // トランザクション開始
        DB::beginTransaction();

        try {// 登録処理
            // //companiesテーブルをメーカー名で検索。
            // if (DB::table('companies')->where('company_name', $request->company_id)->exists()){
            //     //カラムに存在していれば何もしない
            // } else {
            //     //カラムに存在していなければ、companiesテーブルに新規登録
            //     $company->company_name = $request->company_id;
            //     $company->save();
            // }

            //companiesテーブルからIDを検索
            $query = Company::whereCompany_name($request->company_id)->first();

            //productテーブルにメーカーIDを代入
            $product->company_id = $query->id;

            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
            $path = $request->file('img_path')->store('public/images');
            $product->img_path = basename($path);
            $product->save();

            // トランザクション開始してからここまでのDB操作を適用
            DB::commit();
                
            return redirect()->route('add')->with('flash_message', '商品を新規登録しました');
    
        } catch (\Exception $e) {
            // トランザクション開始してからここまでのDB操作を無かったことにする
            DB::rollback();
            return back();
        }
    }

    //編集画面
    public function showEdit($id) {
        $product = Product::find($id);
        $company_list = Company::all();
        return view('edit', ['product' => $product ,'company_list' => $company_list]);
    }

    //編集処理
    public function editUpdate($id, ManagementRequest $request, Product $product ,Company $company){
        $company_list = Company::all();
        $query = Company::all();

        // トランザクション開始
        DB::beginTransaction();
    
        try {// 登録処理
            // //companiesテーブルをメーカー名で検索。
            // if (DB::table('companies')->where('company_name', $request->company_id)->exists()){
            // } else {
            //     //companiesテーブルに新規登録
            //     $company->company_name = $request->company_id;
            //     $company->save();
            // }

            //companiesテーブルからIDを検索
            $query = Company::whereCompany_name($request->company_id)->first();

            $product = Product::find($id);
            
            //productテーブルにメーカー名を代入
            $product->company_id = $query->id;

            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
            $path = $request->file('img_path')->store('public/images');
            $product->img_path = basename($path);
            $product->save();

            // トランザクション開始してからここまでのDB操作を適用
            DB::commit();
            
            return view('edit', compact('product', 'company_list'))->with('flash_message', '商品情報を更新しました');

        } catch (\Exception $e) {
            // トランザクション開始してからここまでのDB操作を無かったことにする
            DB::rollback();
            return back();
            //return redirect(route('edit'));
        }
    }

    //login画面-usersテーブル
    public function showLogin() {
        $model = new User();
        $users = $model->getLogin();
        return view('login', ['users' => $users]);
    }

    //register画面-usersテーブル
    public function showRegister() {
        $model = new User();
        $users = $model->getRegister();
        return view('register', ['users' => $users]);
    }

    //home画面
    public function showHome(Request $request){

        //検索フォームに入力された値を取得
        $keyword = $request->input('keyword');
        $drpCompany = $request->input('drpCompany');

        $query = Product::query();

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

        $products = $query->get();
        $companies = Company::all();
       
        //dd($products);
        return view('home', compact('products', 'keyword','companies'));
    }

    //画像保存
    public function saveImage(Request $request){
        $image = $request->file('pathImage')->store('public/image');
        $image = str_replace('public/image/', '', $image);

        $image = new Product;
        $image->img_path = $image;

        $image->save();
    }

    //未ログイン時ログイン画面リダイレクト
    public function __construct()
    {
       $this->middleware('auth');
    }
}