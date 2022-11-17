<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Page::truncate();
        // Pages array
        $pages = [
            [
                'key' => 'apartments'
            ],
            [
                'key' => 'blogs'
            ],
            [
                'key' => 'search'
            ]


        ];

        // Insert Pages
        Page::insert($pages);
    }
}
