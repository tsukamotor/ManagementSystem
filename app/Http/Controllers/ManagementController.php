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
        $products = new Product();
        $product = $products->getId($id);
        
        $product->delete();
        return redirect()->route('home')->with('flash_message', 'ID：'.$id.'の商品を一覧から削除しました');
    }

    //詳細画面
    public function showInformation($id){
        $products = new Product();
        $product = $products->getId($id);

        return view('information', ['product' => $product,]);
    }

    //新規登録画面
    public function showAdd(Request $request, Product $product){
        $companies = new Company();
        $company_list = $companies->getList();

        return view('add', compact('product','company_list'));
    }

    //新規登録処理
    public function update(ManagementRequest $request, Product $product ,Company $company){
        // トランザクション開始
        DB::beginTransaction();

        try {// 登録処理
            $products = new Product();
            $query = $products->productId($request, $product);

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
        $products = new Product();
        $product = $products->getId($id);

        $companies = new Company();
        $company_list = $companies->getList();

        return view('edit', ['product' => $product ,'company_list' => $company_list]);
    }

    //編集処理
    public function editUpdate($id, ManagementRequest $request, Product $product ,Company $company){
        $companies = new Company();
        $company_list = $companies->getList();

        $products = new Product();
        $product = $products->getId($id);

        // トランザクション開始
        DB::beginTransaction();
    
        try {// 登録処理
            $query = $products->productId($request, $product);

            // トランザクション開始してからここまでのDB操作を適用
            DB::commit();
            return view('edit', compact('product', 'company_list'))->with('flash_message', '商品情報を更新しました');

        } catch (\Exception $e) {
            // トランザクション開始してからここまでのDB操作を無かったことにする
            DB::rollback();
            return back();
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
        $keyword = $request->input('keyword');
        $drpCompany = $request->input('drpCompany');

        $product = new Product();
        $query = $product->getQuery();

        $query = $product->getSearch($query, $keyword, $drpCompany);

        $products = $query->get();

        $company_list = new Company();
        $companies = $company_list->getList();
       
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