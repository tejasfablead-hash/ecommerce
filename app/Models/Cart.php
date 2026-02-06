<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCart
 */
class Cart extends Model
{
    protected $table ="carts";
    
     protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'price'
    ];

    public function getproduct(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
