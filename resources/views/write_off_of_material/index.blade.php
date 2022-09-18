@extends('layouts.app')

@section('title', 'write off list')

@section('content')


<font size="4">
    {{trans_choice('text.write_off', 2)}}
</font>

@can('create', App\WriteOffOfMaterial::class)
<a href="{{ route('writeoffs.create') }}" class="btn btn-primary btn-sm mb-1">
    {{__('text.new')}}
</a>
@endcan


<table style="width:100%" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>№ {{__('text.date')}}</th>
            <th>{{__('text.active')}}</th>
            <th>{{__('text.object_repair')}}</th>
            <th>{{__('text.subdivision')}}</th>
            <th>{{__('text.user')}}</th>
        </tr>
    </thead>

    <tbody>
    @foreach($writeoffs as $writeoff)
    <tr>
        <td>
            @if($writeoff->active)
                    {{$writeoff->id}}. 
                    ({{date_format(date_create($writeoff->created_at), 'd-m-Y')}})        
            @else
                <span class="badge badge-pill badge-warning">
                    {{$writeoff->id}}. 
                    ({{date_format(date_create($writeoff->created_at), 'd-m-Y')}})        
                </span>
            @endif
        </td>
        
        <td>{{$writeoff->active}}</td>

        <td>
            @can('view', $writeoff)
                <a href="{{route('writeoffs.show', ['writeoff' => $writeoff->id])}}"> 

                    <div style="width: 100%;height: 100%">
                        {{$writeoff->object_repair->name}}
                    </div>
                </a> 
            @endcan

            @cannot('view', $writeoff)
            {{$writeoff->object_repair->name}}
            @endcan        
        </td>

        <td>{{$writeoff->subdivision->name}}</td>

        <td>{{$writeoff->user->name}}</td>

    </tr>
    @endforeach
    </tbody>

</table> 


@endsection