<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Usercourse;
use App\Models\Usersubject;
use App\Models\Usercourseprogress;
use App\Models\Usersubjectprogress;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Auth;


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
        $courses = (new Course)
            ->join('usercourses', 'usercourses.course_id', '=', 'courses.id')
            ->where(['usercourses.user_id'=>request()->user()->id,'usercourses.completed'=>'no'])
            ->select("courses.*", "usercourses.id as usercourses_id")
            ->get();

        $completed = (new Course)
            ->join('usercourses', 'usercourses.course_id', '=', 'courses.id')
            ->where(['usercourses.user_id'=>request()->user()->id,'usercourses.completed'=>'yes'])
            ->select("courses.*", "usercourses.id as usercourses_id")
            ->get();

        $others = (new Course)
            ->leftJoin('usercourses', function ($join) {
                $join->on('usercourses.course_id', 'courses.id')
                    ->on('usercourses.user_id', DB::raw(request()->user()->id));
            })
            ->where('usercourses.id', NULL)
            ->select("courses.*")
            ->get();
        return view('student.courses.course')->with(['courses' => $courses, 'others' => $others,'completed'=>$completed]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function register(Request $request, Course $course)
    {
        $available = (new Usercourse)->where(['user_id' => $request->user()->id, 'course_id' => $course->id])->first();
        if (!$available) {
            $userCourse = new Usercourse();
            $userCourse->user_id = $request->user()->id;
            $userCourse->course_id = $course->id;
            $userCourse->completed = "no";
            $userCourse->save();

            $usercourseprogr=new Usercourseprogress();
            $usercourseprogr->user_id = $request->user()->id;
            $usercourseprogr->course_id = $course->id;
            $usercourseprogr->percentage_progress = "0";
            //$usercourseprogr->subject_number="0";
            $usercourseprogr->completed = "no";
            $usercourseprogr->save();
        }
        return redirect(url('studentcourses'));
    }

    public function subject(Usercourse $course)
    {
        //
        $courses = (new Subject)
            ->join('usersubjects', 'usersubjects.subject_id', 'subjects.id')
            ->where(['usersubjects.usercourses_id'=>$course->id,'usersubjects.user_id'=>Auth::user()->id,'usersubjects.completed'=>'no'])
            ->select("subjects.*")
            ->get();

//        dd($courses);
        $completed = (new Subject)
            ->join('usersubjects', 'usersubjects.subject_id', 'subjects.id')
            ->where(['usersubjects.usercourses_id'=>$course->id,'usersubjects.user_id'=>Auth::user()->id,'usersubjects.completed'=>'yes'])
            ->select("subjects.*")
            ->get();


        $others = (new Subject)
            ->leftJoin('usersubjects', function ($join) use ($course) {
                $join->on('usersubjects.subject_id', 'subjects.id')
                    ->on('usersubjects.usercourses_id', DB::raw($course->id));
            })
            ->where(['usersubjects.id'=> NULL,'course_id'=>$course->course_id])
            ->select("subjects.*")
            ->get();
        return view('student.courses.subject')->with(['courses' => $courses, 'others' => $others, 'id' => $course->id,'completed'=>$completed]);
    }

    public function register_subject(Usercourse $course, Subject $subject)
    {
        $user_id=Auth::user()->id;

        $available = (new Usersubject)->where(['usercourses_id' => $course->id, 'subject_id' => $subject->id])->first();
        if (!$available) {


            //dd($course->course_id);


            $userSubject = new Usersubject;
            $userSubject->user_id= $user_id;
            $userSubject->usercourses_id = $course->id;
            $userSubject->subject_id = $subject->id;
            $userSubject->completed = "no";
            $userSubject->save();

            $usersubjprogr=new Usersubjectprogress();
            $usersubjprogr->user_id = $user_id;
            $usersubjprogr->course_id =$course->course_id;

            $usersubjprogr->subject_id= $subject->id;
            $usersubjprogr->topic_number="1";
            $usersubjprogr->percentage_progress = "0";
            $usersubjprogr->completed = "no";
            $usersubjprogr->save();

        }
        return redirect(url('subject/'.$course->id));
    }

}
