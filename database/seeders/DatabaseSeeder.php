<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(1)->create();
        Category::create([
            'name'=>'Adventure books',
        ]);
        Category::create([
            'name'=>'Thriller books',
        ]);
        Category::create([
            'name'=>'Fantasy books',
        ]);
        \App\Models\Product::factory(15)->create();

    }
}
