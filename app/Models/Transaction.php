<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['total_price','user_id','qty','product_id'];

    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}