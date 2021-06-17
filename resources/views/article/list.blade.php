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

    <p><input type="text" name="keyword" class="form-control mr-sm-2" id="keyword"></p>
    <p><input type="button" value="検索" class="btn btn-primary" id="get_articles"></p>

    <div class="article-table">
        @include('article.list_child')
    </div>

    {{-- <table class="table table-striped">
        <tr>
            <th>No.</th>
            <th>タイトル</th>
            <th>内容</th>
            <th>投稿日</th>
            <th>投稿者</th>
            <th></th>
            <th></th>
        </tr>

        @foreach ($articles as $article)
        <tr class="article-list">
            <td>{{ $article->id }}</td>
            <td><a href="/article/detail/{{ $article->id }}">{{ $article->title }}</a></td>
            <td><a href="/article/detail/{{ $article->id }}">{!! nl2br(e(Str::limit($article->content,10))) !!}</a></td>
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
    </table> --}}


</div>

<script>
    function checkDelete() {
        if(window.confirm('削除してよろしいですか？')){
            return true;
        } else {
            return false;
        }
    }


    $(function() {
        
        //検索ボタンをクリックして検索結果を表示する
        $('#get_articles').on('click', function() {
            var keyword = $('#keyword').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url:'/article/search/' + keyword,
                type:'POST',
                data: {
                    'keyword': keyword
                },
                dataType:'text',

            }).done(function (data) {
                alert("通信に成功しました");
                $('.article-table').html(data);
                $('#keyword').val(keyword);

            }).fail(function(jqXHR,textStatus,errorThrown) {
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                console.log("errorThrown    : " + errorThrown.message); // 例外情報
                console.log("URL            : " + url);

            });
        });


        // ページネーション
        $(document).on('click', '.hogehoge', function () {
            // event.preventDefault(); //既定のクリック処理を無効化
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            var keyword = $('#keyword').val(); //検索ワード取得
           
            var url;

            //keywordの有無でurlを指定
            if(!keyword) {
                url = '/article/show';
            } else {
                url = '/article/search/' + keyword;
            }

            $.ajax ({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url:url, //通信するリクエスト先
                    type:'POST',
                    data: {
                        'page': page
                    }, //サーバーに送信するリクエストデータ
                }).done(function (data) {
                    console.log(data);
                    $('.article-table').html(data);
                    // $('html').html(data);
                    
                    $('#keyword').val(keyword);
            });
        }
    });
</script>

@endsection