<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected  $guarded = [];
    public $translatedAttributes = ['name','description'];
    protected $appends = ['image_path' , 'profit','profit_percent'];

    public function category() {
        return $this->belongsTo(Category::class);
    }// end of category

    public function getImagePathAttribute() {
        return asset('uploads/product_images/' . $this->image);
    }// end of image path

    public function getProfitAttribute() {
        $profit = $this->sale_price - $this->purchase_price;
        return $profit;
    }

    public function getProfitPercentAttribute() {
        //$profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $this->getProfitAttribute() * 100 / $this->purchase_price;
        return number_format($profit_percent,2);
    }// end of profit percent
}// end class
