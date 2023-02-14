<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    public function varients1(){
        return $this->belongsTo(ProductVariant::class,'product_variant_one')->where('variant_id',1);
    }
    public function varients2(){
        return $this->belongsTo(ProductVariant::class,'product_variant_two')->where('variant_id',2);
    }
    public function varients3(){
        return $this->belongsTo(ProductVariant::class,'product_variant_three')->where('variant_id',6);
    }
    // public function varients1(){
    //     return $this->hasOne(ProductVariant::class,'product_variant_one');
    // }
}
