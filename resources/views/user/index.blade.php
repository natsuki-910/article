@extends('layout')
@section('title','投稿者の一覧')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>投稿者の一覧</h2>
        @if (session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg')}}    
        </p>
        @endif

        <table class="table table-striped">
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>記事へ</th>
            </tr>

            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                  
                </tr>
            @endforeach

        </table>
    </div>
</div>
@endsection
