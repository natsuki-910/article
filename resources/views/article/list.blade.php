@extends('layout')
@section('title','記事一覧')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>記事一覧</h2>
        @if (session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg')}}    
        </p>
        @endif

</div>
        
        <form action="{{ route('serch')}}" method="GET"　class="form-inline my-2 my-lg-0 ml-2">
            <p><input type="text" name="keyword" class="form-control mr-sm-2"　value="{{$keyword}}"></p>
            <p><input type="submit" value="検索" class="btn btn-primary"></p>
        </form>
        
        
        <table class="table table-striped">
            <tr>
                <th>No.</th>
                <th>タイトル</th>
                <th>投稿日</th>
                <th>投稿者</th>
                <th></th>
                <th></th>
            </tr>

            @foreach ($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td><a href="/article/{{ $article->id }}">{{ $article->title }}</a></td>
                <td>{{ $article->updated_at }}</td>
                <td>{{ $article->user->name }}</td>

                @auth
                    @if (($article->user->id) === (Auth::user()->id))
                        <td><button type="button" class="btn btn-primary" onclick="location.href='/article/edit/{{ $article->id }}'">編集</button></td>
                        <form method="post" action="{{ route('delete', $article->id) }}" onSubmit="return checkDelete()">
                            @csrf
                            <td><button type="submit" class="btn btn-primary" onclick=>削除</button></td>
                        </form>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                @endauth
            </tr>    
            @endforeach
        </table>
    </div>
</div>

<script>
    function checkDelete() {
        if(window.confirm('削除してよろしいですか？')){
            return true;
        } else {
            return false;
        }
    }
</script>

@endsection