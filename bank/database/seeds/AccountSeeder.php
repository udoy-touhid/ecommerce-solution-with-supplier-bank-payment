<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountSeeder extends Seeder
{
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
    public function run()
    {
        DB::table('accounts')->insert([
           'card_name' =>  'Nazmul Islam',
           'card_no' =>'1234123123312',
           'secret' =>'12232',
           'balance' =>'10000',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
       ]);
        
        DB::table('accounts')->insert([
           'card_name' =>  'Daraz',
           'card_no' =>'54545454534343',
           'secret' =>'12232',
           'balance' =>'10000',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
       ]);
        
        DB::table('accounts')->insert([
           'card_name' =>  'Ali Baba',
           'card_no' =>'23131231312131',
           'secret' =>'12232',
           'balance' =>'10000',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
       ]);
    }
}
