<?php

namespace SimpleCMS\Translation\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Translation\Models\Language;

class TranslatorLanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $languages = [
            [
                'id' => 1,
                'locale' => 'id',
                'name' => 'Indonesia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'locale' => 'en',
                'name' => 'English',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        foreach ($languages as $language) {
            if (! $save = Language::find($language['id']) ){
                Language::create($language);
            }
        }
    }
}
