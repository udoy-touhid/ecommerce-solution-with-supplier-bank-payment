<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//
		DB::table('users')->insert([
			'name' => 'user',
			'email' => 'user@gmail.com',
			'password' => bcrypt('user'),
		]);

		DB::table('user_accounts')->insert([
			'user_id' => 1,
			'card_no' => '1234123123312', //nazmul
			'secret' => '1111',
		]);
	}
}
