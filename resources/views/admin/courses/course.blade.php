@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Courses') }}</div>

                <div class="card-body">
	@if(count($courses)>0)
		<table class="table table-bordered">
			<tr>
				<th>ID</th>
				<th>Course</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>View Subjects</th>
				<th>View Registered Students</th>
			</tr>
			@foreach($courses as $course)
				<div class="well">

			<tr>
					<td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td><a class="btn btn-sm btn-primary" href="editcourse/{{$course->id}}">EDIT</a></td>
                    <td><a class="btn btn-sm btn-danger" href="deletecourse/{{$course->id}}">DELETE</a></td>
                <td><a class="btn btn-sm btn-outline-dark" href="{{ route('addsubject',$course->id) }}">VIEW SUBJECTS</a></td>
                <td><a class="btn btn-sm btn-outline-dark" href="/seeprogress/{{$course->id }}">SEE REGISTERED STUDENTS</a></td>
			</tr>

				</div>

			@endforeach
		</table>
	@else
		<p>No course found</p>
	@endif
		  <div class="btn btn-sm btn-primary " >
                <a href="/addcourse" class="text-light"  style="text-decoration: none">Add course</a>
          </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
