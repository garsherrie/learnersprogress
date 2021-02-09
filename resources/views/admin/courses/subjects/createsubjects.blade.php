@extends('layouts.app')
@section('content')
<p>Create Subject</p>


<Form method='GET' class="" action="/storesubject">
	
	<label>Name</label>
	<input type="text" name="name">
	<button type="submit">Create</button>
</Form>
			
@endsection

