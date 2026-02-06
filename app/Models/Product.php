<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
     protected $table = "products";
    protected $fillable = ['category_id', 'name', 'price','qty','discount','discount_value','description','status','image'];

    protected $casts = [
    'price' => 'decimal:2',
    'qty' => 'integer',
     'discount_value' => 'decimal:2',
   
];

    public function getcategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}
    public function getcart(){
         return $this->hasOne(Cart::class,'product_id','id');
    }
}
