<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        $faker = Faker\Factory::create('ja_JP');
        for ($i = 1; $i <= 15; $i++) {
            $author = [
                "name" => $faker->name,
                "kana" => "チョシャメイ".$i,
                "created_at" => $now,
                "updated_at" => $now,
            ];
            DB::table('authors')->insert($author);
        }
    }
}
