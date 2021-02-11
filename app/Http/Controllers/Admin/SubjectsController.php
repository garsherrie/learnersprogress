<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Usersubject;
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
        //view all the subjects is done by this function
        $course_id = $course_id;
        $subjects=Subject::with(array('course'=>function($query) use ($course_id){
            $query->where('id',$course_id);
        }))->get();

        //get only the subjects in a given course_id
        $filtered_courses = collect($subjects)->map(function($sub){
            if(isset($sub->course)) return $sub;
        })->reject(function($sub){
            return empty($sub);
        });
        $y=count($filtered_courses)+1;

        //all these details are passes to subjects view
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
        //allows you to create and store a subject
        $this->validate($request,['name'=>'required']);
        //create subject
        $subject_name = $request->input('name');
        $subject_number=$request->input('subnum');
        $course_id = $request->input('course_id');
        $subject=new Subject;
        $subject->name=$subject_name;
        $subject->subject_number=$subject_number;
        $subject->course_id=$course_id;
        $subject->save();

        $initial_sub=$subject_number-1;
        $new_perc=$initial_sub/$subject_number;

        $allcourses = count((new Subject)->where(['course_id' => $course_id])->get('id'));

        Usercourseprogress::where(['course_id' => $course_id])->update(['percentage_progress' => DB::raw('`percentage_progress` * ' . $new_perc)]);
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

        $initial_sub = count((new Subject())->where('course_id', $course_id)->get());
        $now_sub=$initial_sub-1;
        //dd($now_sub);

        if($now_sub !==0){
            $new_perc=$initial_sub/$now_sub;
            //dd($new_perc);
            Usercourseprogress::where(['course_id' => $course_id,'completed'=>'no'])->update(['percentage_progress' => DB::raw('`percentage_progress` * ' . $new_perc)]);
        }

        //Usercourseprogress::where(['course_id' => $course_id,'completed'=>'no'])->update(['percentage_progress' => DB::raw('`percentage_progress` * ' . $new_perc)]);


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
