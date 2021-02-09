@extends('layouts.app')
@section('content')
<h4>Completed Courses</h4>
	@if(count($completed)>0)
		<table class="table table-bordered table-striped">
			<tr>
				<th>ID</th>
				<th>Course</th>
				<th>Actions</th>
			</tr>
			@foreach($completed as $course)
				<div class="well">

			<tr>
					<td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td><a href="{{url('subject/'.$course->usercourses_id)}}" class="btn btn-primary">VIEW</a></td>

			</tr>

				</div>

			@endforeach
		</table>
	@else
		<p>No completed course</p>
	@endif

<h4>Registered Courses</h4>
@if(count($courses)>0)
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
        @foreach($courses as $course)
            <div class="well">

                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td><a href="{{url('subject/'.$course->usercourses_id)}}" class="btn btn-primary">VIEW</a></td>

                </tr>

            </div>

        @endforeach
    </table>
@else
    <p>No registered course</p>
@endif

<h4>Other Courses</h4>
	@if(count($others)>0)
		<table class="table table-bordered table-striped">
			<tr>
				<th>ID</th>
				<th>Course</th>
				<th>Actions</th>
			</tr>
			@foreach($others as $course)
				<div class="well">

			<tr>
					<td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td><a href="{{url('register/'.$course->id)}}" class="btn btn-primary">REGISTER</a></td>

			</tr>

				</div>

			@endforeach
		</table>
	@else
		<p>No course found</p>
	@endif

@endsection
