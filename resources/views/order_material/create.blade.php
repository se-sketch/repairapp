@extends('layouts.app')

@section('title', 'Add order material')

@section('content')


<div class="card" style="max-width: 600px;">
 	
 	<div class="px-5 py-2 bg-gray-400 border">
 		<font size="4">{{__('text.new_order')}}</font>
 	</div>

 	<div class="card-body bg-gray-300">
		
		<div class="row">
		    <div class="col-12">
		        
		        <form action="{{ route('orders.store') }}" method="post" class="pb-2" 
		        onsubmit="return validateFormOrderMaterial()">

		         @include('order_material.editform')

		        </form>
		    </div>
		</div>

 	</div>
</div>



@endsection