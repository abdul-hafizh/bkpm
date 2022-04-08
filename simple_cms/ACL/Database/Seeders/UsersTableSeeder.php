<?php

namespace SimpleCMS\ACL\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\ACL\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'group_id' => 1,
                'role_id' => 1,
                'name' => 'SUPER ADMIN',
                'username' => 'superadmin',
                'email' => 'superadmin@whendy.net',
                'password' => \Hash::make('12345678@bcde'),
                'status' => 1,
                'path' => 'users/superadmin-ue384xl1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'group_id' => 2,
                'role_id' => 2,
                'name' => 'ADMIN',
                'username' => 'admin',
                'email' => 'admin@whendy.net',
                'password' => \Hash::make('12345678@bcde'),
                'status' => 1,
                'path' => 'users/admin-ue384xl1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $users[0]['path'] = create_path_default('superadmin-ue384xl1', public_path('users'));
        $users[1]['path'] = create_path_default('admin-ue384xl1', public_path('users'));
        User::insert($users);
    }
}
