@extends('layouts.app')

@section('title', 'Edit writeoff')

@section('content')


<div class="card" style="max-width: 600px;">
 	
 	<div class="card-header py-2 bg-gray-400 border flex">
 		<font size="4">
 			Заказ {{$writeoff->id}}. {{date_format(date_create($writeoff->created_at), 'Y-m-d')}}	
 		</font>

		@can('create', App\Svodnaya::class)
		    <form action="{{ route('writeoffs.destroy', ['writeoff' => $writeoff->id]) }}" method="post" class="ml-1">
				@method('delete')
				@csrf

				<button type="submit" class="btn btn-outline-danger btn-sm">
					Отменить!
				</button>
		    </form>
		@endcan
 	</div>

 	<div class="card-body bg-gray-300">

		<div class="row">
		    <div class="col-12">
		        
		        <form action="{{ route('writeoffs.update', ['writeoff' => $writeoff->id])}}"
		        	method="post" class="pb-2">

		            @method('patch')

		            @include('write_off_of_material.editform')

		        </form>
		    </div>
		</div>

 	</div>
</div>



@endsection