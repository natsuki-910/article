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
</table>


{!! $articles->links() !!}

