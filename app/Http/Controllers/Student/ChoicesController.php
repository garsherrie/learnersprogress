<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use DB;

class ChoicesController extends Controller
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

    public function choice(Topic $topic)
    {
        $choices = (new Choice)->where('topic_id', $topic->id)->get();
        return view('student.courses.topic')->with('choices', $choices);
    }

    public function check(Request $request)
    {


//        $this->validate($request,[
//            'choices' => 'required'
//        ]);

        $topic_id = $request->input('topic_id');
        $choice_val = $request->input('choice');
        //dd($choice_val);

        $correct = Topic::where('id', $topic_id)->pluck('topic_number')->toArray();
        $topic_number = $correct[0];
        //dd($topic_number);


        $correct = Choice::where(['topic_id' => $topic_id, 'correct' => '1'])->pluck('choice')->toArray();
        $correct_val = $correct[0];
        //dd($correct_val);

        $subject_id = Topic::where('id', $topic_id)->pluck('subject_id')->toArray();
        $sub = $subject_id[0];
        $course_id = Subject::where('id', $sub)->pluck('course_id')->toArray();
        $cou = $course_id[0];

        //dd($sub);

        if ($choice_val == $correct_val) {

            //$status = 'done';
            //$statusnext='next';

            //DB::table('topics')->where(['id'=>$topic_id,'subject_id'=>$subject_id])->update(array('status'=>$status));
            //DB::table('topics')->where(['topic_number'=>$topic_number+1,'subject_id'=>$subject_id])->update(array('status'=>$statusnext));
            //DB::update('update topics set status = ? where id = ? where subject_id',[$status,$topic_id,$subject_id]);
            //DB::update('update topics set status = ? where topic_number = ? where  subject_id',[$statusnext,$topic_number+1,$subject_id]);

            DB::update('update usersubjectprogresses set topic_number = ? where subject_id = ?', [$topic_number + 1, $sub]);

            return redirect('/topic/' . $sub);
        } else {
            return redirect('/topic/' . $sub);
            //dd('no');
        }
        //dd($correct_val);

    }

}
