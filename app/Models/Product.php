<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','category_id','supplier_id','description','qty','price'];

    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function supplier(){
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }
    public function transactions(){
        return $this->hasMany('App\Models\Transaction', 'product_id');
    }
}