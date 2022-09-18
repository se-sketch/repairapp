@extends('layouts.app')

@section('title', 'User list')

@section('content')

<h4>
	{{trans_choice('text.users', 2)}}
</h4>

<table class="table table-striped table-sm">
	<thead>
	<tr>
		<th>№</th>
		<th>{{__('text.name')}}</th>
		<th>{{trans_choice('text.roles', 1)}}</th>
	</tr>
	</thead>
	
	<tbody>
	@foreach($users as $user)
		<tr>
			<td>
				@if($user->status)
					<span class="badge badge-pill badge-dark">
						{{$user->id}}
					</span>
				@else
					{{$user->id}}
				@endif
			</td>

			<td>
				<a href="{{route('users.show', ['user' => $user->id])}}">
					<div style="width: 100%;height: 100%">
						{{$user->name}} <br>
						{{$user->email}}
					</div>
				</a>
			</td>
			
			<td>{{$user->getStringRoles()}}</td>
		</tr>
	@endforeach
	</tbody>

</table>


@endsection