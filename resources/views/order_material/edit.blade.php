@extends('layouts.app')

@section('title', 'Edit order material')

@section('content')


<div class="card" style="max-width: 600px;">
 	
 	<div class="card-header py-2 bg-gray-400 border flex">
 		<font size="4">
 			Заказ {{$order->id}}. {{date_format(date_create($order->created_at), 'Y-m-d')}}	
 		</font>
 	</div>

 	<div class="card-body bg-gray-300">

		<div class="row">
		    <div class="col-12">
		        
		        <form action="{{ route('orders.update', ['order' => $order->id])}}"
		        	method="post" class="pb-2">

		            @method('patch')

		            @include('order_material.editform')

		        </form>
		    </div>
		</div>

 	</div>
</div>



@endsection