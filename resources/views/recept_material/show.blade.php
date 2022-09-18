@extends('layouts.app')

@section('title', 'Receipt')

@section('content')


<div class="card" style="max-width: 600px;">
    <div class="card-header flex">
        <div class="text-base">
            Receipt material №{{$receipt->id}}. 
            {{ date_format( date_create($receipt->created_at), 'Y-m-d')  }}
        </div>
    </div>

    <div class="card-body">

        <p><strong>{{__('text.name')}}: </strong> {{$receipt->subdivision->name}} </p>
        <p><strong>{{__('text.name')}}: </strong> {{$receipt->user->name}} </p>


        <table width="100%" class="table table-striped table-sm mt-2">
            <thead>
            <tr>
                <th>{{__('text.name')}}</th>
                <th>{{trans_choice('text.qty', 1)}}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($receipt->details as $detail)
            <tr>
                <td>{{$detail->nomenclature->name}}</td>
                <td>{{$detail->qty}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>


@endsection