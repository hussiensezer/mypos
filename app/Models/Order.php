<?php

namespace App\Models;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    public function client() {
        return $this->belongsTo(Client::class);
    }
    public function products() {
        return $this->belongsToMany(Product::class,'product_order')->withPivot('quantity');
    }

    public function getCreatedAtAttribute($val){
      return  (new \Carbon\Carbon)->ToFormattedDateString($val);
    }
}
