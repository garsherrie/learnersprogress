@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach($subjects as $subject)
                        <div class="card-header">Edit course: {{ $subject->name }}</div>

                        <div class="card-body">

                            <div class="form-group row">

                                <form method='GET' class="" action="/editsubject/{{$subject->id}}">

                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $subject->name }}">
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
