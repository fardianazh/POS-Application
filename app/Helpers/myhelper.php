<?php

use App\Models\Transaction;
use Carbon\Carbon;

function no_invoice(){
    $check_code = Transaction::whereDate('created_at', Carbon::today())->count();

    if($check_code == 0){
        $code_transaction = 'LM' . date('dmy') . '0001';
        return $code_transaction;
    } else {
        $get_transaction = Transaction::orderBy('id','desc')->whereDate('created_at', Carbon::today())->first();
        $sub = substr($get_transaction->code_transaction, 8,4) +1;
        $string = sprintf('%04s', $sub);
        
        $code_transaction = 'LM' . date('dmy') . $string;
        return $code_transaction;
    }
}

function rupiah($parameter){
    $string = number_format($parameter, 0, ',', '.');

    return $string;
}