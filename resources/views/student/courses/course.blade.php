@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Student Courses') }}</div>
                    <div style="clear:both;"></div>
                    <div class="card-body">


                        <h4 style="margin-left: 15px">Completed Courses</h4>
                        @if(count($completed)>0)

                            @foreach($completed as $course)
                                <div class="card" style="width: 18rem; float:left; margin: 15px;">
                                    <div class="card-header">
                                        Completed
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Course Name: {{ $course->name }}</li>
                                        <li class="list-group-item"><a class="btn btn-primary btn-sm" href="{{url('subject/'.$course->usercourses_id)}}">VIEW</a></li>

                                    </ul>
                                </div>


                            @endforeach
                    </div>
                    @else

                        <div class="card" style="width: 18rem; float:left; margin: 20px;">
                            <div class="card-header">
                                Completed
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">No completed course</li>


                            </ul>
                        </div>
                    @endif
                    <div style="clear:both;"></div>
                    <br>
                    <h4 style="margin-left: 20px">Registered Courses</h4>
                    @if(count($courses)>0)

                        @foreach($courses as $course)


                            <div class="card" style="width: 18rem; float:left; margin: 20px;">
                                <div class="card-header">
                                    Registered
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Course Name: {{ $course->name }}</li>
                                    <li class="list-group-item"><a class="btn btn-primary btn-sm" href="{{url('subject/'.$course->usercourses_id)}}">VIEW</a></li>

                                </ul>
                            </div>


                        @endforeach

                    @else

                        <div class="card" style="width: 18rem; float:left; margin: 20px;">
                            <div class="card-header">
                                Registered
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Not present</li>

                            </ul>
                        </div>
                    @endif

                    <div style="clear:both;"></div>
                    <br>
                    <h4 style="margin-left: 20px">Other courses</h4>

                    @if(count($others)>0)

                        @foreach($others as $course)
                            <div class="card" style="width: 18rem;float:left; margin: 20px;">
                                <div class="card-header">
                                    Other Courses
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Course Name: {{ $course->name }}</li>
                                    <li class="list-group-item"><a class="btn btn-primary btn-sm" href="{{url('register/'.$course->id)}}" class="btn btn-primary">REGISTER</a></li>
                                </ul>
                            </div>



                        @endforeach

                    @else
                        <div class="card" style="width: 18rem; float:left; margin: 20px;">
                            <div class="card-header">
                                Other Courses
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Not present</li>
                            </ul>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
