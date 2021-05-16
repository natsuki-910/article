<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{

    //  ログインしていないとController内の処理ができないようにする
    public function __construct()
    {
        $this->middleware('auth')->except(['exeSrore']);
    }



    /**
     * 記事一覧の表示と検索
     * 
     * @return view
     */

    public function showList(Request $request)
    {
        $keyword = $request->input('keyword');
    
        $query = Article::query();
    
        if (!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%")->orWhere('content', 'LIKE', "%{$keyword}%");
        }
        
        $articles = $query->paginate(5);

        return view('article.list', compact('articles', 'keyword'));
    }





    /**
     * 記事詳細を表示する
     * @param int $id
     * @return view
     */
    
    public function showDetail($id)//routeのリンクから渡ってくるidを受け取る
    {
        //idの記事の中身を取得
        $article = Article::find($id);

        //もし何らかの理由でidがないものがあったらどうするか(もしnullだったら)
        if(is_null($article)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('articles'));
        };
        
        //articleのdetail.bladeの中に$articleを配列の形で渡す
        return view('article.detail', ['article' => $article]);
    }
    
    

    /**
     * 記事登録画面を表示する
     * 
     * @return view
     */
    
    public function showCreate() 
    {
        return view('article.form');
    }



    /**
     * 記事を登録する
     * 
     * @return view
     */
    
    //ArticleRequestを$requestという変数に入れる→$requestでデータを受け取れるようになる
    public function exeStore(ArticleRequest $request)
    {       
        //ログインしているユーザーのidを取得
        $user = Auth::id();
        
        $files = new Article;

        // 登録する項目に必要な値を代入
        $files->user_id = $user;
        $files->title = $request->title;
        $files->content = $request->content;

        if($request->hasFile('img')) {
            if($request->file('img')->isValid()) {
                $path = $request->file('img')->store('public/images');
                $filename = basename($path);    // パスから、最後の「ファイル名.拡張子」の部分だけ取得　例)sample.jpg 
                $files->file_name = $filename;
            }
        }
        
        try {

            //記事を登録
            $files->save();
            \DB::beginTransaction();
            \DB::commit();
        
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', '記事を登録しました！');
        return redirect(route('articles')); 
    }



    /**
     * 記事編集フォームを表示する
     * @param int $id
     * @return view
     */

    public function showEdit($id)
    {
        //idの記事の中身を取得
        $article = Article::find($id);
        
        if(is_null($article)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('articles'));
        }

        return view('article.edit', ['article' => $article]);
    }



    /**
     * 記事を更新する
     * 
     * @return view
     */
    public function exeUpdate(ArticleRequest $request)
    {   
        //記事のデータを受け取る
        $inputs = $request->all();
        $article = Article::find($inputs['id']);
        
        if($request->hasFile('img')) {
            if($request->file('img')->isValid()) {
                $delFileName = $article->file_name;
                Storage::delete('public/images/' . $delFileName);
                $path = $request->file('img')->store('public/images');
                $filename = basename($path);
                $article->file_name = $filename;
            }
        }

            
        \DB::beginTransaction();
        try { 
            //記事を更新
            $article->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
            ]);

            $article->save();
            \DB::commit();
        
        }   catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', '記事を更新しました！');
        return redirect(route('articles'));
    }



    /**
     * 記事を削除
     * @param int $id
     * @return view
     */

    public function exeDelete($id)
    {
        if(empty($id)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('articles'));
        }
    
        $article = Article::find($id);
        
        try {
            // 取得したデータからfile_nameカラムの情報を取得する
            $delFileName = $article->file_name;
    
            // storage/app/public/imagesから、画像ファイルを削除する
            Storage::delete('public/images/' . $delFileName);
            
            //記事を削除
            Article::destroy($id);
        
        } catch(\Throwable $e) {
            abort(500);
        }        

        \Session::flash('err_msg', '記事を削除しました。');
        return redirect(route('articles'));
    }

}