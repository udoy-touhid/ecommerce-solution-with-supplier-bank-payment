<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->insert([
			'name' => 'supplier',
			'email' => 'supplier@gmail.com',
			'password' => bcrypt('supplier'),
		]);

		for ($i = 0; $i < 10; $i++) {

			DB::table('products')->insert([
				'title' => Str::random(8),
				'description' => Str::random(20),
				'image_url' => Str::random(20),
				'quantity' => $i * 10 + 4,
				'price' => $i * $i + 10,
			]);
		}

	}
}
