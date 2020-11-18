<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // factory(\App\Category::class,50)->create();
        //factory(\App\Product::class,50)->create();
        factory(\App\Image::class,50)->create();


    }
}
