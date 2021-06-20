@extends('layout')
@section('title','記事一覧')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>記事一覧</h2>
        @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg')}}
        </p>
        @endif
    </div>

    <p><input type="text" name="keyword" class="form-control mr-sm-2" id="keyword"></p>
    <p><input type="button" value="検索" class="btn btn-primary" id="get_articles"></p>

    <div class="article-table table">
        @include('article.list_child')
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

    $(function() {

        //記事を削除するときの確認画面
        $(document).on('click', '.delete-article', function() {
            var is_delete_confirmed = checkDelete();
            if(is_delete_confirmed) {
                var page = $(this).attr('href');
                window.location.href = page;
            }
        });
        
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
                },
            }).done(function (data) {
                console.log(data);
                $('.article-table').html(data);
                $('#keyword').val(keyword);
            });
        }
    });
</script>

@endsection