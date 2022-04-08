<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 11:52 PM ---------
 */

namespace SimpleCMS\ACL\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\ACL\Models\GroupModel;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'slug'  => 'super-admin',
                'name'  => 'Super Admin Group',
                'description' => 'Super Admin Group',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'id'    => 2,
                'slug'  => 'admin',
                'name'  => 'Admin Group',
                'description' => 'Admin Group',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'id'    => 3,
                'slug'  => 'investor',
                'name'  => 'Investor Group',
                'description' => 'Investor Group',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'id'    => 4,
                'slug'  => 'umkm',
                'name'  => 'UMKM Group',
                'description' => 'UMKM Group',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];
        GroupModel::insert($roles);
    }
}
