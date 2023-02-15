<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    // public function varients(){
    //     return $this->belongsTo(ProductVariant::class,'product_variant_one')->where('variant_id',1);
    // }

}
