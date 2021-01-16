<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;

class UserController extends Controller
{
    /**
     * ユーザーの記事一覧を表示する
     * 
     * @return view
     */
    // public function show(User $user)//書き換え
    // {
    //     $user = User::find($user->id); //idが、リクエストされた$userのidと一致するuserを取得
    //     $aritcles = Article::where('user_id', $user->id) //$userによる投稿を取得
    //         ->orderBy('created_at', 'desc') // 投稿作成日が新しい順に並べる
    //         ->paginate(10); // ページネーション; 
    //     return view('users.show', [
    //         'user_name' => $user->name, // $user名をviewへ渡す
    //         'articles' => $articles, // $userの書いた記事をviewへ渡す
    //     ]);
    // }

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function show()
    {
        $users = User::All();
        return view('user.show', ['users' => $users]);

}
