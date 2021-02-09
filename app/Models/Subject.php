<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id'
    ];
     public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    public function topic(){
    	 return $this->hasMany('App\Models\Topic');
    }
    public function usersubject(){
        return $this->hasMany('App\Models\Usersubject');
    }
    public function usersubjectprogress(){
        return $this->hasMany('App\Models\Usersubjectprogress');
    }
}
