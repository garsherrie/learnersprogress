@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Subject</div>


                <div class="card-body">
<div class="form-group row">
	<form method='POST' class="" action="/storesubject">
		{{ csrf_field() }}
	<label class="col-md-2 col-form-label text-md-right">Name</label>
	<input  class="form-control col-md-6" type="text" name="name" autofocus>
        <input type="hidden" name="subnum" value="{{$y}} " >
	<input class="form-control" type="text" name="course_id" value="{{ $course_id }}" style="visibility: hidden;">
	<button class="btn btn-primary btn-sm" type="submit">Create</button>
</form>
</div>


	@if(count($subjects)>0)
		<table class="table table-bordered">
			<tr>

				<th>Subject</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>View Topics</th>
                <th>See Registered Students</th>
			</tr>
			@foreach($subjects as $subject)
				<div class="well">

			<tr>

                    <td>{{ $subject->name }}</td>
                    <td><a class="btn btn-primary btn-sm" href="/editsub/{{$subject->id}}">EDIT</a></td>
                    <td><a class="btn btn-danger btn-sm" href="/deletesubject/{{$subject->id}}">DELETE</a></td>
                    <td><a class="btn btn-sm btn-outline-dark" href="/addtopic/{{ $subject->id }}">VIEW TOPICS</a></td>
                    <td><a class="btn btn-sm btn-outline-dark" href="/seesubprogress/{{$subject->id }}">SEE REGISTERED STUDENTS</a></td>
			</tr>

				</div>

			@endforeach
		</table>
	@else
		<p>No Subject found</p>
	@endif
                </div></div></div></div></div>

@endsection
