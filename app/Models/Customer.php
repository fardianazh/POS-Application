<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function transaction(){
        return $this->hasOne('App\Models\Transaction', 'customer_id');
    }
}