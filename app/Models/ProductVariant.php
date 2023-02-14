<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    public function varients(){
        return $this->belongsTo(Variant::class,'variant_id');
    }
    // public function varients1(){
    //     return $this->hasOne(ProductVariantPrice::class,'product_variant_one');
    // }
    // public function varients2(){
    //     return $this->hasMany(ProductVariant::class,'product_variant_two');
    // }
    // public function varients3(){
    //     return $this->hasMany(ProductVariant::class,'product_variant_three');
    // }

}
