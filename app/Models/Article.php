<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // テーブル名
    protected $table = 'articles';

    //可変項目
    protected $fillable =
    [
        'id',
        'user_id',
        'title',
        'content',
        'file_name',
        
    ];

    //主キーのセット(PRIMARY KEYを持つカラム)
    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }



}
