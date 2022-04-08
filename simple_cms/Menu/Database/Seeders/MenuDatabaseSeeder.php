<?php

namespace SimpleCMS\Menu\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Menu\Models\MenuModel;

class MenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        $menus = [
            [
                'id'    => 1,
                'slug' => 'adminlte3',
                'name' => 'AdminLTE3',
                'option' => json_encode([]),
                'status' => 1,
                'presenter' => "\\SimpleCMS\\Menu\\Presenters\\Admin\\Adminlte3Presenter::class",
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id'    => 2,
                'slug' => 'menu-primary',
                'name' => 'Menu Primary',
                'option' => json_encode([["id" => 1, "type" => "custom", "status" => 1, "target" => "_self", "icon" => "fas fa-home", "url" => url('/'), "title" => "HOME", "label" => "HOME", "classcss" => ""]]),
                'status' => 1,
                'presenter' => '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ];
        MenuModel::insert($menus);
    }
}
