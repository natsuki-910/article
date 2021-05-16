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
        'title',
        'content',
        'user_id',
        'file_name'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}