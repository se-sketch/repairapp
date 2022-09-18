@extends('layouts.app')

@section('title', 'Edit details for '.$user->name)

@section('content')


<div class="card" style="max-width: 450px;">
 	<div class="card-header">
    	<font size="4">
        	{{trans_choice('text.user', 1)}}
        	 № {{$user->id}}. {{ date_format( date_create($user->created_at), 'Y-m-d') }}
    	</font>
 	</div>

 	<div class="card-body">

		<p><strong>{{__('text.name')}}: </strong> {{$user->name}}</p>
		<p><strong>{{__('text.email')}}: </strong> {{$user->email}}</p>
		<p><strong>{{__('text.created')}}: </strong> {{$user->created_at}}</p>
		<p><strong>{{__('text.updated')}}: </strong> {{$user->updated_at}}</p>

		
		<form action="{{route('users.update', ['user' => $user->id])}}" method="post">
		    @method('patch')

		    <select id="employee_id" name="employee_id" class="form-control">
		    	<option value="">{{trans_choice('text.employee', 1)}}</option>
		    	@foreach($employees as $employee)
		       	<option value="{{$employee->id}}" 
		            {{old('employee_id', $user->employee_id) == $employee->id ? 'selected' : ''}}>
		            {{$employee->name}}
		        </option>
		    	@endforeach
		    </select>

			
			<div class="bg-blue-400 rounded-t">
				<p class="ml-2">{{trans_choice('text.role', 2)}}:</p>
			</div>

			
			<div class="border-2 border-blue-400 rounded-b"> 
			<ul class="mt-2 ml-2">
			@foreach($roles as $role)
			    <li>
			    	<input type="checkbox" name="roles[]" value="{{$role->id}}" id="roles_{{$role->id}}" 
			    	{{$user->hasRole($role->name) ? 'checked' : ''}}>
			    	<label for="roles_{{$role->id}}">{{$role->name}}</label>
			    </li>
			@endforeach
			</ul>
			</div>
		    

			@csrf

			<button type="submit" class="btn btn-primary mt-2">
				{{__('text.save')}}
			</button>
		</form>

 	</div>
</div>

@endsection