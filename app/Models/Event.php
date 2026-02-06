<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    protected $table = "events";
    protected $fillable = ['title','description','event_date','user_id'];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
