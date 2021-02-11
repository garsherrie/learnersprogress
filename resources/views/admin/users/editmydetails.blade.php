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
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}"  autofocus>
                                    </div>
{{--                                    <label>Name</label>--}}
{{--                                    <input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}">--}}
                                </div>
                                <button class="btn btn-primary" type="submit" style="margin-left: 50px">Edit</button>

                            </form>

                        </div>


                    </div>

            </div>
        </div>
    </div>
@endsection
