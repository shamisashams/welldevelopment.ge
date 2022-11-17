<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;
use App\Models\Page;

class PageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageSection::truncate();
        //
        $pages = [
            [
                'key' => 'home'
            ],
            [
                'key' => 'about'
            ],



        ];

        $in = [];

        foreach ($pages as $item){
            $in[] = $item['key'];
        }

        $pages = Page::whereIn('key',$in)->get();



        $ins = [];
        $key = 0;
        foreach ($pages as $item){
            switch ($item->key){
                case 'home':
                    for ($i = 0; $i < 1; $i++){
                        $ins[$key]['page_id'] = $item->id;
                        $key++;
                    }
                    break;
                case 'about':
                    for ($i = 0; $i < 1; $i++){
                        $ins[$key]['page_id'] = $item->id;
                        $key++;
                    }
                    break;
                default:
                    $ins[$key]['page_id'] = $item->id;
                    $key++;
            }

        }
        //dd($ins);
        PageSection::insert($ins);
    }
}
