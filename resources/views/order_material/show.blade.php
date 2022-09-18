@extends('layouts.app')

@section('title', 'Order')

@section('content')


<div class="card" style="max-width: 600px;">
    <div class="card-header flex">

        <div class="row">
            <div class="col-sm-5">
                Order material №{{$order->id}}. 
                {{ date_format( date_create($order->created_at), 'Y-m-d')  }}
            </div>
            <div class="col-sm-4">
                @can('delete', $order)
                <form action="{{route('orders.destroy', ['order' => $order->id])}}" 
                    method="post" class="ml-1">
                    @method('delete')
                    @csrf
                    <button type="sumbit" class="btn btn-outline-danger btn-sm">
                        {{__('text.deny')}}
                    </button>
                </form>
                @endcan
            </div>
            
        </div>

    </div>

    <div class="card-body">
        @can('restore', $order)
        <form action="{{route('orders.restore', ['order' => $order->id])}}" method="post" class="pb-2">
            @method('patch')
            @csrf
            <button type="sumbit" class="btn btn-outline-dark btn-sm">
                Восстановить!
            </button>
        </form>
        @endcan




        <p><strong>{{__('text.subdivision')}}: </strong> 
            {{$order->subdivision->name}} 
        </p>
        <p><strong>{{__('text.user')}}: </strong> {{$order->user->name}} </p>


        <table width="100%" class="table table-striped table-sm mt-2">
            <thead>
            <tr>
                <th>{{__('text.name')}}</th>
                <th>{{trans_choice('text.qty', 1)}}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($order->details as $detail)
            <tr>
                <td>{{$detail->nomenclature->name}}</td>
                <td>{{$detail->qty}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>


        
        @can('update', $order)
        <form action="{{route('orders.edit', ['order' => $order->id])}}" 
            method="get" class="ml-1">
            @csrf
            <button type="sumbit" class="btn btn-outline-primary btn-sm">
                {{__('text.edit')}}
            </button>
        </form>
        @endcan        


    </div>
</div>


@endsection