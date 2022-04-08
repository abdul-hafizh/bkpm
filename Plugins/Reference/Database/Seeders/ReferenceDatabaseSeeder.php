<?php

namespace Plugins\Reference\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ReferenceDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('Plugins\Reference\Database\Seeders\UserTableSeeder');
	}
}