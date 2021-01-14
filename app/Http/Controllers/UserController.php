<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * ユーザーの記事一覧を表示する
     * 
     * @return view
     */
    public function show()
    {
        //Articleのデータを全部取得
        // $articles = Article::all();

        //article.listのbladeの中に$articleを配列の形で渡す
        // return view('article.list', ['articles' => $articles]);
        
        $users = User::with('articles')->find(1);
        // return $user;
        return view('user.show', ['users' => $users]);
    }
}
