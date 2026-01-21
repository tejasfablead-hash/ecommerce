<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
  protected $table = "category_parent";
  protected $fillable = ['category'];

  public function getcategory()
  {
    return $this->hasOne(Category::class, 'parent_id', 'id');
  }
}
