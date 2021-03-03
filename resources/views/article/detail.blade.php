@extends('layout')
@section('title','記事詳細')
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>{{ $article->title }}</h1>
        <br>
        <p>◇作成日：{{ $article->created_at }} 　◇更新日：{{ $article->updated_at }}</p>
        <br>
        <p>{{ $article->content }}</p>
        <br>
        
        @if ($article->file_name)
            <img src="{{ asset('storage/images/' . $article->file_name) }}">
        @endif
        
    </div>
</div>

@endsection
