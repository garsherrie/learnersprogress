@extends('layouts.app')
@section('content')
<p>Subjects</p>

	<form method='POST' class="" action="/storesubject">
		{{ csrf_field() }}
	<label>Name</label>
	<input type="text" name="name">
        <input type="hidden" name="subnum" value="{{$y}} " >
	<input type="text" name="course_id" value="{{ $course_id }}" style="visibility: hidden;">
	<button type="submit">Create</button>
</form>

	@if(count($subjects)>0)
		<table class="table">
			<tr>

				<th>Subject</th>
                <th>Actions</th>
			</tr>
			@foreach($subjects as $subject)
				<div class="well">

			<tr>

                    <td>{{ $subject->name }}</td>
                    <td><a class="btn btn-primary" href="/editsub/{{$subject->id}}">EDIT</a></td>
                    <td><a class="btn btn-danger" href="/deletesubject/{{$subject->id}}">DELETE</a></td>
                    <td><a href="/addtopic/{{ $subject->id }}">VIEW TOPICS</a></td>
                    <td><a href="/seesubprogress/{{$subject->id }}">SEE REGISTERED STUDENTS</a></td>
			</tr>

				</div>

			@endforeach
		</table>
	@else
		<p>No Subject found</p>
	@endif


@endsection
