<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    protected $fillable = [
        'product_variant_one', 'product_variant_two', 'product_variant_three'
    ];
    public function varients_one(){
        return $this->belongsTo(ProductVariant::class,'product_variant_one')->where('variant_id',1);
    }
    public function varients_two(){
        return $this->belongsTo(ProductVariant::class,'product_variant_two')->where('variant_id',2);
    }
    public function varients_three(){
        return $this->belongsTo(ProductVariant::class,'product_variant_three')->where('variant_id',6);
    }
}
