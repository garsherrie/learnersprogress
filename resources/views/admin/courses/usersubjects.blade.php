@extends('layouts.app')
@section('content')
    <p>Courses</p>

    <table class="table">
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

@endsection
