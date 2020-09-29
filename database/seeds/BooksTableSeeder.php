<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Factory を用いてダミーデータを作成
        factory(\App\Books::class, 50)->create();
    }
}