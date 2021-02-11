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
        //getting all the courses from the database
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
        //takes us to the view that creates a new course
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
        //this is how you create and store a new course
        $this->validate($request, ['name' => 'required']);

        $course = new Course;
        $course->name = $request->input('name');
        $course->save();

        //after saving the course it redirects you to view all courses
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
        //here you can edit the course details
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
        //the edited course detais are stored in course database.
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
        //this function allows you to delete a course, permission is given to admins only
        if (Gate::denies('delete-courses')) {
            return redirect('/courses');
        }

        DB::delete('delete from courses where id = ?', [$id]);
        return redirect('/courses')->with('success', 'course deleted successfully');
    }

    public function registered($course_id)
    {

        //check all the registered users for a course and their progress
        $users = Usercourseprogress::join("users", "users.id", "=", "usercourseprogresses.user_id")
            ->select("users.id", "users.name", "users.email", "usercourseprogresses.percentage_progress")
            ->where('course_id', $course_id)->get();

        return view('admin.courses.usercourses')->with('users', $users);
    }
}
