<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    
    private function check_account_credentials($card_name,$card_no,$secret) {
        
        $account = \App\Account::where('card_name',$card_name)
                ->where('card_no',$card_no)
                ->where('secret',$secret)->first();
        
        return $account;
        
    }
    
    private function check_receiver($card_no) {
        
        $account = \App\Account::where('card_no',$card_no)->first();
        
        return $account;
        
    }
    
    private function transfer_amount($card_to,$card_from,$amount) {
        
        try {
            $transaction = new \App\Transaction();
            $transaction->account_from = $card_from;
            $transaction->account_to = $card_to;
            $transaction->amount = $amount;

            $flag_transaction = $transaction->save();
            
            if($flag_transaction==true)
            {
                $flag_credit_transfer = $this->change_account_balance($card_from, $amount, false) 
                        && $this->change_account_balance($card_to, $amount, true);
             
                return $flag_credit_transfer;
            }
            
        
        } catch (Exception $exc) {
            
            return false;
        }
        
    }
    
    private function change_account_balance($card_no,$balance,$add_flag) {
        
        $account = \App\Account::where('card_no',$card_no)->first();
        
        if($add_flag==false)
            $balance = -$balance;
        
        $account->balance += $balance;
        return $account->save();
    }


    public function make_payment() {
        
        $card_name = request('card_name');
        $card_no = request('card_no');
        $secret = request('secret');
        $account_to = request('account_to');
        $amount_to_send = request('amount_to_send');
        
        $sender = $this->check_account_credentials($card_name, $card_no, $secret);
        
        if($sender==null || $sender->count()<=0)
            return 'Invalid Account Info';
        
        $receiver = $this->check_receiver($account_to);
        
        if($receiver==null || $receiver->count()<=0)
            return 'Invalid Receiver';
        
        if($sender->balance<$amount_to_send)
            return 'Not Sufficient Balance';
        
        $flag = $this->transfer_amount($account_to, $card_no, $amount_to_send);
        if($flag==true)
            return 'Payment Successful';
        else 
            return 'Unsuccessful';
    }
}
