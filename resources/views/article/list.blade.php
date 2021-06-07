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
        
        
        
        {{-- <form method="GET" class="form-inline my-2 my-lg-0 ml-2" > --}}
        {{-- @csrf --}}
        {{-- </form> --}} 
        
        <table class="table table-striped">
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
                <td><a href="/article/{{ $article->id }}">{{ $article->title }}</a></td>
                <td><a href="/article/{{ $article->id }}">{!! nl2br(e(Str::limit($article->content,10))) !!}</a></td>
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

        <div class="paginate">
            {{ $articles->links() }}
        </div>
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
        
        $('#get_articles').on('click', function() {

            var keyword = $('#keyword').val();
            // console.log(keyword);
        //     var request = $.ajax({
        //         type: 'GET',
        //         url: '/article/search/' + keyword,
        //         // url: '/article/search/',
        //         cache: false,
        //         data: { keyword: keyword },
        //         // data: keyword,
        //         dataType: 'json',
        //         timeout: 3000
        //     });
        //         // console.log(request);

        //     /* 成功時 */
        //     request.done(function(data) {
        //         console.log(data);
        //         alert("通信に成功しました");
        //     });

        //     /* 失敗時 */
        //     request.fail(function(jqXHR, textStatus, errorThrown) {

        //         // 通信失敗時の処理
        //             console.log("ajax通信に失敗しました");
        //             console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
        //             console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
        //             console.log("errorThrown    : " + errorThrown.message); // 例外情報
        //             console.log("URL            : " + url);
        //     });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            url:'/article/search/' + keyword,
            type:'POST',
            data:{
                'keyword': keyword
            },
            dataType:'json',
            // contentType: '',
            }).done(function (data){
                console.log(data);
                alert("通信に成功しました");
                $('.article-list').remove();

                $.each(data.articles, function (index, value) {
                    let id = value.id;
                    let title = value.title;
                    let content = value.content.substr(0,9) + '...';
                    let updated = value.updated_at; 
                    let user_name = value.user.name;
                    let html = `
                            <tr>
                                <td>${id}</td>
                                <td>${title}</td>
                                <td>${content}</td>
                                <td>${updated}</td>
                                <td>${user_name}</td>
                            </tr>
                            ` ;

                    $('.table').append(html); 
                });

            }).fail(function(jqXHR,textStatus,errorThrown){
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                console.log("errorThrown    : " + errorThrown.message); // 例外情報
                console.log("URL            : " + url);

            });
        });
    });

    

    

</script>

@endsection