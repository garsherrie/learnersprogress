<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Choice;
use App\Models\Usersubject;
use App\Models\Usersubjectprogress;
use Illuminate\Http\Request;
use Auth;
use DB;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function topic(Request $request, Subject $subject)
    {

        $user_id = Auth::user()->id;
        $c = Usersubjectprogress::where(['subject_id' => $subject->id, 'user_id' => $user_id])->pluck('topic_number')->toArray();
        $progress = $c[0];
        $finalpage = $progress - 1;
        //dd($progress);

        $d = Usersubjectprogress::where(['subject_id' => $subject->id, 'user_id' => $user_id])->pluck('completed')->toArray();
        $status = $d[0];

        $c_id = Usersubjectprogress::where(['subject_id' => $subject->id, 'user_id' => $user_id])->pluck('course_id')->toArray();
        $courseid = $c_id[0];


        if ($status === 'no') {
            if (!$request->has('page')) return redirect(url("/topic/{$subject->id}?page={$progress}"));
        } else {
            if (!$request->has('page')) return redirect(url("/topic/{$subject->id}?page={$finalpage}"));
        }


//        $subnumber=Subject::where(['course_id'=>$courseid,'id'=>$subject->id])->pluck('subject_number')->toArray();
//        $subject_number=$subnumber[0];
        //dd($subject_number);
        $topics = Topic::where(['subject_id' => $subject->id])->where('topic_number', '<=', $progress)->orderBy('id', 'asc')->paginate(1);
        $counttopics = count((new Topic)->where('subject_id', $subject->id)->get('id'));

        //$donetopics = count((new Topic)->where(['subject_id' => $subject->id, 'status' => 'done'])->get('id'));
        $donetopics = $finalpage;
        if ($counttopics !== 0) {

            $percentage = ($donetopics / $counttopics) * 100;
            //dd($counttopics);
        } else {
            $percentage = 0 * 100;
        }


        if ($percentage == 100) {

            DB::table('usersubjectprogresses')->where(['subject_id' => $subject->id, 'user_id' => $user_id])->update(array('completed' => 'yes'));
            DB::table('usersubjects')->where(['subject_id' => $subject->id, 'user_id' => $user_id])->update(array('completed' => 'yes'));

        }
        DB::table('usersubjectprogresses')->where(['subject_id' => $subject->id, 'user_id' => $user_id])->update(array('percentage_progress' => $percentage));


        //$allsubjects = count((new Usersubject)->where(['usercourses_id' => $courseid, 'user_id' => $user_id])->get('id'));
        $allsubjects = count((new Subject)->where(['course_id' => $courseid])->get('id'));
        //dd($allsubjects);
        $donesubjects = count((new Usersubject)->where(['usercourses_id' => $courseid, 'user_id' => $user_id, 'completed' => 'yes'])->get('id'));

        $percentagecourse = $allsubjects === 0 ? 0 : ($donesubjects / $allsubjects) * 100;
        //dd($percentagecourse);


        if ($percentagecourse == 100) {

            DB::table('usercourses')->where(['course_id' => $courseid, 'user_id' => $user_id])->update(array('completed' => 'yes'));
            DB::table('usercourseprogresses')->where(['course_id' => $courseid, 'user_id' => $user_id])->update(array('completed' => 'yes'));
        }

        DB::table('usercourseprogresses')->where(['course_id' => $courseid, 'user_id' => $user_id])->update(array('percentage_progress' => $percentagecourse));

        return view('student.courses.topic')->with('topics', $topics)->with('percentage', $percentage)->with('progress', $progress)->with('key', $progress != $request->get('page') || intval($percentage) === 100);

    }
}
