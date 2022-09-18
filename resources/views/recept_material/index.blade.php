@extends('layouts.app')

@section('title', 'receipt list')

@section('content')


<font size="4">
    {{trans_choice('text.orders', 2)}}
</font>


<table style="width:100%" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>№</th>
            <th>{{trans_choice('text.date', 1)}}</th>
            <th>{{trans_choice('text.subdivision', 1)}}</th>
            <th>{{trans_choice('text.user', 1)}}</th>
        </tr>
    </thead>

    <tbody>
    @foreach($receipts as $receipt)
    <tr>
        <td>{{$receipt->id}}</td>
        <td>{{$receipt->created_at}}</td>

        <td>
            @can('view', $receipt)
                <a href="{{route('receipts.show', ['receipt' => $receipt->id])}}"> 

                    <div style="width: 100%;height: 100%">
                        {{$receipt->subdivision->name}}
                    </div>
                </a> 
            @endcan

            @cannot('view', $receipt)
                {{$receipt->subdivision->name}}
            @endcan        
        </td>        

        <td>{{$receipt->user->name}}</td>
    </tr>
    @endforeach
    </tbody>

</table> 


@endsection