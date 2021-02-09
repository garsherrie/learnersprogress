<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole=Role::where('name','admin')->first();
         $studentRole=Role::where('name','student')->first();

         $admin=User::create([
         	'name'=>'Admin User',
         	'email'=>'admin@admin.com',
         	'password'=>Hash::make('password'),
            'role_id'=>1
     	]);

          $student=User::create([
         	'name'=>'User Student',
         	'email'=>'student@student.com',
         	'password'=>Hash::make('password'),
            'role_id'=>2
     	]);


          $admin->roles()->attach($adminRole);
          $student->roles()->attach($studentRole);
    }
}
