<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->delete();
        $posts = array(
            ['id' => 1, 'title' => 'food', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'title' => 'news', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'title' => 'sports', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        );
        DB::table('category')->insert($posts);
    }
}
