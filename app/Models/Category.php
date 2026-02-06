<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    protected $table = "category";
    protected $fillable = ['parent_id', 'name', 'image'];

    public function parentcategory()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_id', 'id');
    }
     public function getproduct()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
