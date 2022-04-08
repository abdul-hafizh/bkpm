<?php

namespace SimpleCMS\Wilayah\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WilayahDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $format = 'dapodik';
        Model::unguard();
        \DB::unprepared(\File::get(module_path('wilayah', 'Database/Seeders/'. $format .'/negara.sql')));
        \DB::unprepared(\File::get(module_path('wilayah', 'Database/Seeders/'. $format .'/provinsi.sql')));
        \DB::unprepared(\File::get(module_path('wilayah', 'Database/Seeders/'. $format .'/kabupaten.sql')));
        \DB::unprepared(\File::get(module_path('wilayah', 'Database/Seeders/'. $format .'/kecamatan.sql')));
        \DB::unprepared(\File::get(module_path('wilayah', 'Database/Seeders/'. $format .'/desa.sql')));
    }
}
