@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品情報詳細画面</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table>
                        <thead>
                            <tr>
                                <th>ID　</th>
                                <th>商品画像　</th>
                                <th>商品名　</th>
                                <th>価格(円)　</th>
                                <th>在庫数(個)　</th>
                                <th>メーカー名　</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ optional($product)->id }}</td>
                                <td><img src="{{ asset('storage/images/' . $product->img_path) }}"></td>
                                <td>{{ optional($product)->product_name }}</td>
                                <td>{{ optional($product)->price }}</td>
                                <td>{{ optional($product)->stock }}</td>
                                <td>{{ $product->company->company_name}}</td>
                                <td><a href="{{ route('edit', $product->id) }}" class="btn btn-primary btn-sm">編集</a></td>
                                <td><a href="{{ route('home', $product->id) }}" class="btn btn-primary btn-sm">戻る</a></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
