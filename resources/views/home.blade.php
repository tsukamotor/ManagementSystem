@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品一覧画面</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <!--↓↓ 検索機能 ↓↓-->
                    検索フォーム
                    <div>
                        <form action="{{ route('home') }}" method="GET">
                            <label>商品名：</label>
                            <input type="text"  name="keyword">

                            <label>　メーカー名：</label>
                            <select name="drpCompany">
                                <option value="">選択してください</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->company_name}}"
                                    @if($company=='{{ $company->company_name}}') selected
                                    @endif>{{ $company->company_name}}</option>
                                @endforeach
                            </select>

                            <input type="submit" class="btn btn-primary btn-sm" value="検索">
                        </form>
                        <!--↑↑ 検索機能 ↑↑-->
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID　</th>
                                <th>商品画像　</th>
                                <th>商品名　</th>
                                <th>価格(円)　</th>
                                <th>在庫数(個)　</th>
                                <th>メーカー名　</th>
                                <th>
                                    <td><a href="{{ route('add') }}" class="btn btn-primary btn-sm">新規作成</a></td>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ asset('storage/images/' . $product->img_path) }}"></td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->company_name}}</td>
                                    <td><a href="{{ route('information', $product->id) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                    <td>
                                        <form action="{{ route('destroy', ['id'=>optional($product)->id]) }}" method="GET">
                                            @csrf
                                            <input type="submit" name="delete" value="削除" onClick="return delete_alert()" class="btn btn-danger btn-sm">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td>検索結果はありません。</td>
                            @endforelse
                            <!--↓↓ 読み込み ↓↓-->
                            <script src="{{ asset('/js/delete.js') }}"></script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
