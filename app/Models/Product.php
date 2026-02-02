<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $table = "products";
    protected $fillable = ['category_id', 'name', 'price','qty','description','status','image'];

    protected $casts = [
    'price' => 'decimal:2',
    'qty' => 'integer',
   
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
