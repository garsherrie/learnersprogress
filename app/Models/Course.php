<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function subject(){
    	 return $this->hasMany('App\Models\Subject');
    }
    public function usercourse(){
         return $this->hasMany('App\Models\Usercourse');
    }
    public function usersubject(){
        return $this->hasMany('App\Models\Usersubject');
    }
    public function usercourseprogress(){
        return $this->hasMany('App\Models\Usercourseprogress');
    }
    public function usersubjectprogress(){
        return $this->hasMany('App\Models\Usersubjectprogress');
    }

}
