<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Subject;
use App\Models\Usersubjectprogress;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;
use Gate;
use DB;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subject_id)
    {
        //
        // $topics=Topic::all();
        //return view('admin.courses.subjects.topics.topics')->with('topics',$topics);


        //$subject_id = $subject_id;
        $c = Subject::where('id',$subject_id)->pluck('course_id')->toArray();
        $course_id = $c[0];
        //dd($course_id);
        $topics = Topic::with(array('subject' => function ($query) use ($subject_id) {
            $query->where('id', $subject_id);
        }))->get();
        $filtered_subjects = collect($topics)->map(function ($sub) {
            if (isset($sub->subject)) return $sub;
        })->reject(function ($sub) {
            return empty($sub);
        });
        $y=count($filtered_subjects)+1;
        //dd($y);
        return view('admin.courses.subjects.topics.topics')->with(['topics' => $filtered_subjects, 'subject_id' => $subject_id])->with('y',$y)->with('course_id',$course_id);
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
        $this->validate($request, [
            'name' => 'required',
            'subject_id' => 'required',
            'definition' => 'required',
            'question' => 'required',
            'video' => 'required|file',
            'choices' => 'required|array',
            'choices.*.choice' => 'required'
        ]);
        //create subject
        $topic_name = $request->input('name');
        $subject_id = $request->input('subject_id');
        $topic_desc = $request->input('definition');
        $question = $request->input('question');
        $topic_no=$request->input('next_topic');
        $course_id=$request->input('course_id');
        $topic = new Topic;
        $topic->name = $topic_name;
        $topic->topic_number=$topic_no;
        $topic->subject_id = $subject_id;
        $topic->definition = $topic_desc;
        $topic->question = $question;
        //$topic->completed = "";
        $topic->video = Storage::url($request->file('video')->store('public/videos'));
        $topic->save();
        foreach ($request->input('choices') as $choice) {
            $new_choice = new Choice();
            $new_choice->topic_id = $topic->id;
            $new_choice->choice = $choice['choice'];
            $new_choice->correct = boolval($choice['isCorrect'] ?? false);
            $new_choice->save();

            DB::update('update usersubjectprogresses set completed = ? where subject_id = ?', ["no", $subject_id]);
            DB::update('update usersubjects set completed = ? where subject_id = ?', ["no", $subject_id]);

            DB::update('update usercourseprogresses set completed = ? where course_id = ?', ["no", $course_id]);
            DB::update('update usercourses set completed = ? where course_id = ?', ["no", $course_id]);
        }

        return redirect('/addtopic/' . $subject_id)->with('success', 'topic created successfully');
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
        if(Gate::denies('delete-topics')){
            //return redirect('/courses');
        }



        $c=Topic::where('id',$id)->pluck('subject_id')->toArray();
        $subject_id=$c[0];
        DB::delete('delete from topics where id = ?',[$id]);
        return redirect('/addtopic/'.$subject_id)->with('success','topic deleted successfully');
    }
}
