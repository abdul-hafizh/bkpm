<?php

namespace Plugins\BkpmUmkm\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BkpmUmkmDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('Plugins\BkpmUmkm\Database\Seeders\UserTableSeeder');
	}
}