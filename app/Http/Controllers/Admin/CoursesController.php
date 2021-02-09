<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Usercourse;
use App\Models\User;
use App\Models\Usercourseprogress;
use Illuminate\Http\Request;
use DB;
use Gate;
use App\Models\Subject;
use App\Models\Topic;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Course::all();
        return view('admin.courses.course')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.courses.createcourse');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, ['name' => 'required']);
        //create post

        $course = new Course;
        $course->name = $request->input('name');
        $course->save();

        return redirect('/courses')->with('success', 'course created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //$courses=Course::all();

        //return view('admin.courses.editcourse')->with(['courses'=>$courses]);
        $courses = DB::select('select * from courses where id = ?', [$id]);
        return view('admin.courses.editcourse', ['courses' => $courses]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $name = $request->input('name');
        DB::update('update courses set name = ? where id = ?', [$name, $id]);
        return redirect('/courses')->with('success', 'course deleted successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (Gate::denies('delete-courses')) {
            return redirect('/courses');

        }

        DB::delete('delete from courses where id = ?', [$id]);
        return redirect('/courses')->with('success', 'course deleted successfully');
    }

    public function registered($course_id)
    {

        $users = Usercourseprogress::join("users", "users.id", "=", "usercourseprogresses.user_id")
            ->select("users.id", "users.name", "users.email", "usercourseprogresses.percentage_progress")
            ->where('course_id', $course_id)->get();


        //$registered_users=User::where('id',array($users));
        //dd($registered_users);


        return view('admin.courses.usercourses')->with('users', $users);
    }
}
