<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }


    /**
     * 記事一覧を表示する
     * 
     * @return view
     */
    public function showList()
    {
        //Articleのデータを全部取得
        $articles = Article::all();
        // dd($articles);

        //article.listのbladeの中に$articleを配列の形で渡す
        return view('article.list', ['articles' => $articles]);
   
    }
    

    /**
     * 記事詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)//routeのリンクからわたってくるのでidを受け取る
    {
        //idの記事の中身を引っ張ってくる
        $article = Article::find($id);
        
        //もし何らかの理由でidがないものがあったらどうするか(もしnullだったら)
        if(is_null($article)) {
            \Session::flash('err_msg', 'データがありません。');//移動したときに出るメッセージ
            return redirect(route('articles'));//一覧画面に戻す(articlesはrouteの名前)
        }

        //article.detailのbladeの中に$articleを配列の形で渡す
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
    
    //ArticleRewuestを$requestという変数に入れる→$requestでデータを受け取れるようになる
    public function exeStore(ArticleRequest $request)
    {   
        //記事のデータを受け取る
        $inputs = $request->all();
        // dd($request->all());    
        $path = $request->file('img')->store('public/images');

        // パスから、最後の「ファイル名.拡張子」の部分だけ取得します 例)sample.jpg
        $filename = basename($path);
        

        
        $files = new Article;

        // 登録する項目に必要な値を代入します
        $files->title = $request->title;
        // dd($request->title, $request->content,$request->filename );
        $files->content = $request->content;
        $files->file_name = $filename;
        
        // データベースに保存します
        $files->save();
        
        //記事を登録
        // Article::create($inputs);
        
        // try {
        //     // データベースに保存します
        //     $files->save();

        // \DB::beginTransaction();
            
        //     \DB::commit();
        // } catch(\Throwable $e) {
        //     \DB::rollback();
        //     abort(500);
        // }
        // \Session::flash('err_msg', '記事を登録しました。');
        // return redirect(route('articles')); 
    }



     /**
     * 記事編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
        //Articleのデータを全部取得
        $article = Article::find($id);
        
        if(is_null($article)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('articles'));
        }

        //article.listのbladeの中に$articleを配列の形で渡す
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

        \DB::beginTransaction();
        try {
            //記事を更新
            $article = Article::find($inputs['id']);
            $article->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
            ]);
            $article->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', '記事を更新しました。');
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

        try {
            //記事を削除
            Article::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }        

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('articles'));
    }



}
