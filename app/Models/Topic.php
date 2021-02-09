<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function choices()
    {
        return $this->hasMany("App\Models\Choice", "topic_id", "id");
    }
}
