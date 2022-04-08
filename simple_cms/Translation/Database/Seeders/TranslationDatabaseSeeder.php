<?php

namespace SimpleCMS\Translation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TranslationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(TranslatorLanguageTableSeeder::class);
        $this->call(TranslatorTranslationTableSeeder::class);
    }
}
