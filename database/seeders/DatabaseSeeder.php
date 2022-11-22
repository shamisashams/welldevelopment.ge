<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call([
            LanguageSeeder::class,
            PageSeeder::class,
            PageSeeder2::class,
            SettingSeeder::class,
            SettingSeeder2::class,
            UserSeeder::class,
            PageSectionsSeeder::class,
            AttributeSeeder::class
        ]);
    }
}
