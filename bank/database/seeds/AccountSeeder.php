<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 *
	 *   $table->bigIncrements('id');
	$table->string('card_name',100);
	$table->string('card_no',50);
	$table->string('secret',64);//sha 256bit
	$table->double('balance')->default(0);

	$table->index(['card_name', 'card_no']);
	 */
	public function run() {
		DB::table('accounts')->insert([
			'card_name' => 'Nazmul Islam',
			'card_no' => '1234123123312',
			'secret' => '1111',
			'balance' => '20000',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);

		DB::table('accounts')->insert([
			'card_name' => 'Daraz',
			'card_no' => '54545454534343',
			'secret' => '1112',
			'balance' => '40000',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);

		DB::table('accounts')->insert([
			'card_name' => 'Ali Baba',
			'card_no' => '23131231312131',
			'secret' => '1113',
			'balance' => '50000',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);
	}
}
