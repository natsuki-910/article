@extends('layout')
@section('title','記事一覧')
@section('content')
@extends('layouts.app')


    <div class="container mt-4">

        <div class="mb-4">
        <p>{{ $user_name }}の投稿一覧</p>
        </div>

        @foreach ($articles as $article)
            <div class="card mb-4">
                <div class="card-header">
                    タイトル: {{ $article->title }}
                    投稿者: <a href="{{ route('user.show', $ariticle->user_id) }}">{{ $user_name }}</a>
                </div>
                <div class="card-footer">
                    <span class="mr-2">
                        投稿日時 {{ $article->created_at->format('Y.m.d') }}
                    </span>


    </div>
@endsection