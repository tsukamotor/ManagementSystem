@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品情報編集画面</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{route('edit', $product->id)}}" method="post" enctype='multipart/form-data'>
                        @csrf
                        {{ method_field('patch') }}

                        <div class="form-group">
                            <label>ID　　　　</label>
                            <td>{{ $product->id }}</td>
                        </div>

                        <div class="form-group">
                            <label>商品名　　</label>
                            <input type="text"  name="product_name" value="{{ old('product_name', $product->product_name) }}" >
                            @if($errors->has('product_name'))
                                <p>{{ $errors->first('product_name') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>メーカー名</label>
                            <!-- <input type="text" list="company_id" name="company_id" value="{{ old('company_id', $product->company->company_name) }}">
                            <datalist name="company_id" id="company_id"> -->
                            <select name="company_id" id="company_id">
                                @foreach ($company_list as $company_lists)
                                    <option value="{{ $company_lists->company_name}}"
                                    @if($company_lists=='{{ $company_lists->company_name}}') selected
                                    @endif>{{ $company_lists->company_name}}</option>
                                @endforeach
                            <!-- </datalist> -->
                            </select>
                            @if($errors->has('company_id'))
                                <p>{{ $errors->first('company_id') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>価格　　　</label>
                            <input type="text"  name="price" value = "{{ old('price', $product->price) }}">
                            @if($errors->has('price'))
                                <p>{{ $errors->first('price') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>在庫数　　</label>
                            <input type="text"  name="stock" value = "{{ old('stock', $product->stock) }}">
                            @if($errors->has('stock'))
                                <p>{{ $errors->first('stock') }}</p>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label>コメント　</label>
                            <textarea type="text"  name="comment">{{ old('comment', $product->comment) }}</textarea>
                            @if($errors->has('comment'))
                                <p>{{ $errors->first('comment') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>商品画像　</label>
                            <input type="file"  name="img_path" value = "{{ old('img_path', $product->img_path) }}">
                            @if($errors->has('img_path'))
                                <p>{{ $errors->first('img_path') }}</p>
                            @endif
                        </div>
                        <div><img src="{{ asset('storage/images/' . $product->img_path) }}"></div>

                        <input type="submit" class="btn btn-primary btn-sm" value="更新"/>
                        <td><a href="{{ route('information', $product->id) }}" class="btn btn-primary btn-sm">戻る</a></td>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
