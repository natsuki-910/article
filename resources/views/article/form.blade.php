@extends('layout')
@section('title', '記事投稿')
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>記事投稿フォーム</h2>
        <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data" onSubmit="return checkSubmit()">
        @csrf
            <div class="form-group">
                <label for="title">タイトル</label>
                <input
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    type="text">

                @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="content">本文</label>
                <textarea 
                    id="content" 
                    name="content" 
                    class="form-control" 
                    rows="4">{{ old('content') }}
                </textarea>

                @if ($errors->has('content'))
                    <div class="text-danger">
                        {{ $errors->first('content') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>画像選択</lavel>
                <br>
                <input type="file" name="img" accept=".png,.jpg,.jpeg,image/png,image/jpg">
                
                @if ($errors->has('file_name'))
                    <div class="text-danger">
                        {{ $errors->first('file_name') }}
                    </div>
                @endif   
            </div>

            <div class="mt-5">
                <button type="submit" class="btn btn-primary">投稿する</button>
                <a class="btn btn-secondary" href="{{ route('articles') }}">キャンセル</a>
            </div>
        </form>
    </div>
</div>

<script>
    function checkSubmit() {
        if(window.confirm('送信してよろしいですか？')) {
            return true;
        } else {
            return false;
        }
    }
</script>

@endsection