<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('ActionsTableSeeder');
		$this->call('ActionRolesTableSeeder');
		$this->call('RoleUsersTableSeeder');
	}

}