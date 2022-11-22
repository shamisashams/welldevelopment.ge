<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {

        //
        $attributes = [
            [
                'code' => 'status',
                'type' => 'select'
            ],
            [
                'code' => 'condition',
                'type' => 'select'
            ],
        ];

        foreach ($attributes as $item){
            $attribute = Attribute::query()->create($item);

        }


    }
}
