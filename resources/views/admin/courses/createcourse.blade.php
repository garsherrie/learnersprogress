@extends('layouts.app')
@section('content')
<p>Create Course</p>


<Form method='GET' class="" action="/storecourse">
	
	<label>Name</label>
	<input type="text" name="name">
	<button type="submit">Create</button>
</Form>
			
@endsection

