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
}
