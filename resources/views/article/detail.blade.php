@extends('layout')
@section('title','記事詳細')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>{{ $article->title }}</h2>
        <p>作成日：{{ $article->created_at }}</p>
        <p>更新日：{{ $article->updated_at }}</p>
        <img src="{{ asset('storage/images/' . $article->file_name) }}">
        <p>{{ $article->content }}</p>
    </div>
</div>
@endsection
