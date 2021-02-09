<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Gate;
use DB;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $users=User::all();
        $users = User::with('roles:name')->get();
        //dd($users);
        // $users = User::with('roles')->get()->map(function($roles){
        //     $roles_name = User->roles()->get()->pluck('name')->all();
        //     return $roles_name;
        // });
        for ($i=0; $i < sizeof($users); $i++) {
            foreach ($users[$i]->roles as $role) {
                $users[$i]['role_name'] = $role->name;
            }
        }
        return view('admin.users.index')->with('users',$users);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        }
        $roles=Role::all();

        return view('admin.users.edit')->with([
            'user'=>$user,
            'roles'=>$roles
        ]);
    }
    public function editmydetails($id)
    {

        $user=User::where('id',$id);
        return view('admin.users.editmydetails')->with(
            'user',$user
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $user->roles()->sync($request->roles);

        $user->name=$request->name;

        $user->email=$request->email;

        $user->save();
        return redirect()->route('admin.users.index');
    }

    public function updatedet(Request $request, $id){
        $name = $request->input('name');
        DB::update('update users set name = ? where id = ?',[$name,$id]);
        return redirect('/home');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if(Gate::denies('delete-users')){ return
            redirect(route('admin.users.index'));
        }
            User::find($user->id)->delete();
        return redirect()->route('admin.users.index');
    }



    // not using this
    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(User $user)
    // {
    //     //
    // }

}
