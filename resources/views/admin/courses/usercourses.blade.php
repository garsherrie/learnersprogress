@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Courses Registered') }}</div>

                    <div class="card-body">


    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Progress</th>
        </tr>
        @foreach($users as $user)
            <div class="well">

                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->percentage_progress }}%</td>

                </tr>

            </div>

        @endforeach
    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
