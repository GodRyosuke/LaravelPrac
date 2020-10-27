<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKakeiboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kakeibo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id');
            $table->integer('month'); // 月
            $table->integer('day'); // 日
            $table->integer('diff')->default(0); // 差額
            $table->string('what', '100')->nullable(); // 用途
            $table->integer('savings')->default(0); // 残高
            $table->string('memo', '500')->nullable(); // メモ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kakeibo');
    }
}
