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

                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $course->name }}"/>
                                    <button type="submit">Create</button>
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
