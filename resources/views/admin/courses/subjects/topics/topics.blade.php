@extends('layouts.app')
@section('content')
    <p>Topics</p>

    <form method='POST' class="container" action="/storetopic" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <input type="text" name="name" placeholder="Name . . ." class="form-control">
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fa fa-address-card"></i>
                </div>
                <input type="text" name="definition" placeholder="Definition . . ." class="form-control">
            </div>
        </div>
        <div class="form-group mb-3">
            <input type="file" name="video" class="form-control">
        </div>
        <div class="form-group mb-3">
            <textarea name="question" placeholder="Type in a Question . . ." class="form-control" rows="5"></textarea>
        </div>
        <h6 class="mb-3">Choices</h6>
        @foreach([0,1,2] as $index)
            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-text">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choices[{{$index}}][isCorrect]" id="isCorrect" required>
                            <label class="form-check-label" for="isCorrect"></label>
                        </div>
                    </div>
                    <input type="text" name="choices[{{$index}}][choice]" placeholder="Choice {{$index + 1}} . . ." class="form-control">
                </div>
            </div>
        @endforeach
        <input type="text" name="subject_id" value="{{ $subject_id }}" style="visibility: hidden;">
        <input type="hidden" name="next_topic" value="{{$y}} " >
        <input type="hidden" name="course_id" value="{{$course_id}} " >
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </form>

    @if(count($topics)>0)
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th>ID</th>
                <th>Topic</th>
                <th>Definition</th>
                <th>Video</th>
                <th>Question</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach($topics as $topic)
                <div class="well">

                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ $topic->name }}</td>
                        <td>{{ $topic->definition }}</td>
                        <td class="w-25">
                            <div class="d-flex justify-content-center">
                                <video controls src="{{ $topic->video }}" width="100%" height="auto" frameborder="0"></video controls>
                            </div>
                        </td>
                        <td>{{ $topic->question }}</td>
                        <td>
                            <button class="btn btn-primary">EDIT</button>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="/deletetopic/{{$topic->id}}">DELETE</a>
                        </td>

                    </tr>

                </div>

            @endforeach
        </table>
    @else
        <p>No Topic found</p>
    @endif


@endsection
