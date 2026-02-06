<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFeedback
 */
class Feedback extends Model
{
   protected $table ="feedback";
   protected $fillable =['order_id','user_id','product_id','rating','message'];

   public function getorder(){
      return $this->belongsTo(Order::class,'order_id','id');
   }
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
