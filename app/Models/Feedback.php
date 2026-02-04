<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
   protected $table ="feedback";
   protected $fillable =['name','email','subject','message','order_id'];

   public function getorder(){
      return $this->belongsTo(Order::class,'order_id','id');
   }
}
