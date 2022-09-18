@extends('layouts.app')

@section('title', 'order list')

@section('content')


<font size="4">
    {{trans_choice('text.order', 2)}}
</font>

@can('create', App\OrderMaterial::class)
<a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm mb-1">
    {{__('text.new')}}
</a>
@endcan


<table style="width:100%" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>№</th>
            <th>{{__('text.date')}}</th>
            <th>{{__('text.subdivision')}}</th>
            <th>{{__('text.user')}}</th>
        </tr>
    </thead>

    <tbody>
    @foreach($orders as $order)
    <tr>
        <td>{{$order->id}}</td>
        <td>{{$order->created_at}}</td>

        <td>
            @can('view', $order)
                <a href="{{route('orders.show', ['order' => $order->id])}}"> 

                    <div style="width: 100%;height: 100%">
                        {{$order->subdivision->name}}
                    </div>
                </a> 
            @endcan

            @cannot('view', $order)
                {{$order->subdivision->name}}
            @endcan        
        </td>        

        <td>{{$order->user->name}}</td>
    </tr>
    @endforeach
    </tbody>

</table> 


@endsection