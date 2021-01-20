@extends('layout')
@section('title','投稿者のページ')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>投稿者のページ</h2>
        @if (session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg')}}    
        </p>
        @endif

        <table class="table table-striped">
            <tr>
                <th>data</th>
            </tr>

            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->getData() }}</td>
                </tr>
            @endforeach

        </table>
    </div>
</div>
<script>
function checkDelete(){
    if(window.confirm('削除してよろしいですか？')){
        return true;
    } else {
        return false;
    }
}
</script>
@endsection




{{-- <table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>email</th>
        <th>message</th>
        <th>title</th>
        <th>content</th>
    </tr>
    @foreach ($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->conetnt}}</td>
            <td>
                <ul>
                    @foreach($item->articles as $obj)
                        <li>{{$obj->getData()}}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach
</table> --}}