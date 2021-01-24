<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;

class UserController extends Controller
{
    /**
     * ユーザー一覧を表示する
     * 
     * @return view
     */

    
    //ログインしていないとController内の処理ができないようにする
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Request $request)
    {
        //ログインしているユーザーを取得
        // $user = Auth::user();
        // dd($user->id);

        $items = User::all();
        // $items = Article::with('user')->get();
        // dd($items);
        return view('user.index', ['items' => $items]);
    }

    /**
     * 特定のユーザーの記事一覧を表示する
     * 
     * @return view
     */
    public function show(User $user)
    {
        $user = User::find($user->id);
        dd($user);//idが、リクエストされた$userのidと一致するuserを取得
        $articles = Article::where('user_id', $user->id) //$userによる投稿を取得
            ->orderBy('created_at', 'desc') // 投稿作成日が新しい順に並べる
            ->paginate(10); // ページネーション; 

        return view('user.show', [
            'user_name' => $user->name, // $user名をviewへ渡す
            'articles' => $articles, // $userの書いた記事をviewへ渡す
        ]);
    }
    
}
