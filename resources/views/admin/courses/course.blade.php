@extends('layouts.app')
@section('content')
<p>Courses</p>
	@if(count($courses)>0)
		<table class="table">
			<tr>
				<th>ID</th>
				<th>Course</th>
			</tr>
			@foreach($courses as $course)
				<div class="well">

			<tr>
					<td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td><a class="btn btn-primary" href="editcourse/{{$course->id}}">EDIT</a></td>
                    <td><a class="btn btn-warning" href="deletecourse/{{$course->id}}">DELETE</a></td>
                <td><a href="{{ route('addsubject',$course->id) }}">VIEW SUBJECTS</a></td>
                <td><a href="/seeprogress/{{$course->id }}">SEE REGISTERED STUDENTS</a></td>
			</tr>

				</div>

			@endforeach
		</table>
	@else
		<p>No course found</p>
	@endif
		  <div class="btn btn-primary " >
                <a href="/addcourse" class="text-light"  >Add course</a>
          </div>
@endsection
