@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach($courses as $course)
                    <div class="card-header">Edit course: {{ $course->name }}</div>

                    <div class="card-body">

                            <div class="form-group row">

                                <form method='GET' class="" action="/edit/{{$course->id}}">

                                    <label for="name" class="col-md-2 col-form-label ">Name</label>
                                    <div class="col-md-6">
                                    <input type="text" class="form-control" autofocus name="name" value="{{ $course->name }}"/>
                                    </div>
                                    <br>
                                    <button class="btn btn-primary" type="submit" style="margin-left: 15px">Create</button>
                                </form>
                            <div class="form-group row">

                                    @endforeach
                                </div>
                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
