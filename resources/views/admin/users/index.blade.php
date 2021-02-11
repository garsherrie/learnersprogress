@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                  <table class="table table-bordered">
                    <tr>
                       <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                     @foreach($users as $user)
                     <tr>
                       <td>{{ $user->name }}</td>
                       <td>{{ $user->email }}</td>
                       <td>{{ $user->role_name }}</td>
                       <td>
                          <a class='btn btn-sm btn-primary float-left' href="{{  route('admin.users.edit',$user->id)  }}">EDIT</a>
                           <br><br>
                          <form action="{{  route('admin.users.destroy',$user) }}"
                            method='POST' class="float-left">

                            @csrf
                            {{ method_field('DELETE') }}
                             <button class="btn btn-sm btn-danger">DELETE</button>
                          </form>
                       </td>
                     </tr>
                     @endforeach
                   </tr>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
