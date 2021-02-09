<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    use HasFactory;
    public $table='roles';

    public function users(){

    	return $this->belongsToMany('App\Models\User');

    }
}
