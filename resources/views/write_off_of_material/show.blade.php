@extends('layouts.app')

@section('title', 'Write off')

@section('content')


<div class="card" style="max-width: 600px;">
    <div class="card-header">

        <div class="row">
            <div class="col-sm-6">
                repair №{{$writeoff->id}}. 
                {{ date_format( date_create($writeoff->created_at), 'Y-m-d')  }}
                <b>{{$writeoff->object_repair->name}}</b>
            </div>
            <div class="col-sm-4">
                @can('delete', $writeoff)
                <form action="{{route('writeoffs.destroy', ['writeoff' => $writeoff->id])}}" 
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
        @can('restore', $writeoff)
        <form action="{{route('writeoffs.restore', ['writeoff' => $writeoff->id])}}" method="post" class="pb-2">
            @method('patch')
            @csrf
            <button type="sumbit" class="btn btn-outline-dark btn-sm">Восстановить!</button>
        </form>
        @endcan


        <p>
            <strong>
                {{__('text.subdivision')}}:
            </strong> 
            {{$writeoff->subdivision->name}} 
        </p>
        <p><strong>{{__('text.user')}}: </strong> {{$writeoff->user->name}} </p>


        <table width="100%" class="table table-striped table-sm mt-2">
            <thead>
            <tr>
                <th>{{__('text.name')}}</th>
                <th>{{trans_choice('text.qty', 1)}}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($writeoff->details as $detail)
            <tr>
                <td>{{$detail->nomenclature->name}}</td>
                <td>{{$detail->qty}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

        @can('update', $writeoff)
        <form action="{{route('writeoffs.edit', ['writeoff' => $writeoff->id])}}" 
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