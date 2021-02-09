@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit user: {{ Auth::user()->name }}</div>


                    <div class="card-body">

                        <div class="form-group row">

                            <form method='GET' class="" action="/editmydet/{{ Auth::user()->id }}">

                                <label>Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                                <button type="submit">Edit</button>
                            </form>
                            <div class="form-group row">


                            </div>
                        </div>


                    </div>

            </div>
        </div>
    </div>
@endsection
