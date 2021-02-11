@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Student Courses') }}</div>

                    <div class="card-body">

    <br>
    <div class="container2">
        <div class="skill2" style="width: {{$percentage}}%">{{number_format($percentage, 2)}}%</div>
    </div>

    <br>
    <div class="card" style="width: 100%; height: auto; margin-left: 10px; margin-right: 10px">
        <div class="row">
            <div class="col-12 text-center">
                @if(count($topics)>0)
                    @foreach($topics as $topic)
                        <h4>Topic: {{ $topic->name }}</h4>

                        <p>{{ $topic->definition }}</p>
                        <h4>Video</h4>
                        <div class="d-flex justify-content-center">
                            <video controls src="{{ $topic->video }}" width="300px" height="auto"></video>
                        </div>
                        <h4>Question</h4>
                        <p>{{ $topic->question }}</p>
                        <form action="/choices" method='GET'>
                            @foreach($topic->choices as $choice)
                                <div class="form-check d-inline-block
@if($key && $choice->correct) bg-success p-1 rounded text-light @endif
                                @if($key && !$choice->correct) bg-danger p-1 rounded text-light @endif
                                    ">
                                    <input value="{{$choice->topic_id}}" name="topic_id" type="hidden">
                                    <input class="form-check-input" type="radio"
                                           @if($key && $choice->correct) checked @endif
                                           @if($key) disabled @endif
                                           value="{{$choice->choice}}"
                                           name="choice"
                                           id="choice{{$choice->id}}">
                                    <label class="form-check-label @if($key) text-light @endif"
                                           for="choice{{$choice->id}}">
                                        {{$choice->choice}}
                                        @if($key && $choice->correct)
                                            <i class="fa fa-check-circle"></i>
                                        @endif
                                        @if($key && !$choice->correct)
                                            <i class="fa fa-times-circle"></i>
                                        @endif
                                    </label>
                                </div><br>
                            @endforeach
                            @if(!$key)
                                <button class="btn btn-success my-4" onclick="">Done</button>@endif
                            {{ $topics->links() }}
                            @endforeach
                        </form>
                        @else
                            <p>No Topic found</p>
                        @endif
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
