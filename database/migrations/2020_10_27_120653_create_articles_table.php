<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()//
    {
        if(!Schema::hasTable('articles')) 
        {
            Schema::create('articles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->string('title', 100);
                $table->text('content');
                $table->string('file_name');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
                // // $table->foreign(外部キーカラム)->references(主キーカラム)->on(主キーテーブル);
            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()//削除
    {
        Schema::dropIfExists('articles');
    }
}
