<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Choice;
use App\Models\Usercourseprogress;
use App\Models\Usersubjectprogress;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $course_id = $course_id;
        $subjects=Subject::with(array('course'=>function($query) use ($course_id){
            $query->where('id',$course_id);
        }))->get();
        $filtered_courses = collect($subjects)->map(function($sub){
            if(isset($sub->course)) return $sub;
        })->reject(function($sub){
            return empty($sub);
        });

        $y=count($filtered_courses)+1;
        //dd($y);
        return view('admin.courses.subjects.subject')->with(['subjects'=>$filtered_courses,'course_id'=>$course_id])->with('y',$y);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         //return view('admin.courses.subjects.createsubjects');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request,['name'=>'required']);
        //create subject
        $subject_name = $request->input('name');
        $subject_number=$request->input('subnum');
        //dd($subject_number);
        $course_id = $request->input('course_id');
        //dd($course_id);
        $subject=new Subject;
        $subject->name=$subject_name;
        $subject->subject_number=$subject_number;
        $subject->course_id=$course_id;
        //$subject->completed = "";
        $subject->save();

        $initial_sub=$subject_number-1;
        $new_perc=$initial_sub/$subject_number;

        $allcourses = count((new Subject)->where(['course_id' => $course_id])->get('id'));
        //dd($allcourses);


        $users =  Usercourseprogress::where(['course_id' => $course_id])->update(['percentage_progress' => DB::raw('`percentage_progress` * ' . $new_perc)]);
        //dd($users);



        //DB::update('update usercourseprogresses set percentage_progress = ? where course_id = ?', [$new_perc, $course_id]);



        DB::update('update usercourseprogresses set completed = ? where course_id = ?', ["no", $course_id]);
        DB::update('update usercourses set completed = ? where course_id = ?', ["no", $course_id]);

        return redirect('/addsubject/'.$course_id)->with('success','subject created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $subjects = DB::select('select * from subjects where id = ?',[$id]);
        return view('admin.courses.subjects.editsubject',['subjects'=>$subjects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $c=Subject::where('id',$id)->pluck('course_id')->toArray();
        $course_id=$c[0];
        $name = $request->input('name');
        DB::update('update subjects set name = ? where id = ?',[$name,$id]);
        return redirect('/addsubject/'.$course_id)->with('success','course deleted successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(Gate::denies('delete-subjects')){
            //return redirect('/courses');
        }
        $c=Subject::where('id',$id)->pluck('course_id')->toArray();
        $course_id=$c[0];

        DB::delete('delete from subjects where id = ?',[$id]);
        return redirect('/addsubject/'.$course_id)->with('success','subject deleted successfully');
    }
    public function registered($subject_id)
    {

        $users = Usersubjectprogress::join("users", "users.id", "=", "usersubjectprogresses.user_id")
            ->select("users.id", "users.name", "users.email", "usersubjectprogresses.percentage_progress")
            ->where('subject_id', $subject_id)->get();


        //$registered_users=User::where('id',array($users));
        //dd($registered_users);


        return view('admin.courses.usersubjects')->with('users', $users);
    }
}
