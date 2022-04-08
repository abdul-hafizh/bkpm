<?php

namespace SimpleCMS\Translation\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Translation\Models\Language;

class TranslatorTranslationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        \DB::unprepared(\File::get(module_path('translation', 'Database/Seeders/db/translator_translation_default.sql')));
    }
}
