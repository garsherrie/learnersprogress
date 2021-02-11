@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Student Courses') }}</div>
                    <div style="clear:both;"></div>
                    <div class="card-body">

                    <div style="margin-left: 10px">
        <h4 >Completed Subjects</h4>
        @if(count($completed)>0)
            @foreach($completed as $course)
                <div class="card " style="width:150px; height: 150px; background-color: rgba(0, 0, 0, 0.03); float:left; margin: 5px;">
                    <div class="card-body " style="">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <a class="btn btn-primary btn-sm" href="{{url('topic/'.$course->id)}}">VIEW</a>
                    </div>

                </div>


            @endforeach
        @else
            <p>No subject is completed</p>
        @endif

    </div>
    <div style="clear:both;"></div>

    <div style="margin-left: 10px">
        <h4 >Registered Subjects</h4>
        @if(count($courses)>0)
                @foreach($courses as $course)
                    <div class="card " style="width:150px; height: 150px; background-color: rgba(0, 0, 0, 0.03); float:left; margin: 5px;">
                        <div class="card-body " style="">
                            <h5 class="card-title">{{ $course->name }}</h5>
                           <a class="btn btn-primary" href="{{url('topic/'.$course->id)}}">VIEW</a>
                        </div>

                    </div>

            @endforeach
        @else
            <p>No subject found</p>
        @endif

    </div>
    <div style="clear:both;"></div>

    <div style="margin-left: 10px">
        <h4>Other Subjects</h4>
        @if(count($others)>0)

                @foreach($others as $course)

                        <div class="card" style="width:150px; height: 150px; background-color: rgba(0, 0, 0, 0.03); float: left; margin: 5px">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->name }}</h5>
                                <a class="btn btn-primary"   href="{{url("subject/register/$id/{$course->id}")}}">REGISTER</a>
                            </div>
                        </div>
                @endforeach

        @else
            <p>No subject found</p>
        @endif
    </div>
                    </div></div></div></div></div>
@endsection
