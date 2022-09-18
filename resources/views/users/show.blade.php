@extends('layouts.app')

@section('title', 'User')

@section('content')


<div class="card">
    <div class="card-header">
        <font size="4" class="mr-5">
            {{trans_choice('text.user', 1)}} 
            № {{$user->id}} . 
            {{ date_format( date_create($user->created_at), 'Y-m-d') }}
        </font>
    </div>

    <div class="card-body ml-1">
        <div class="row">
            <div clas="col-12">
                <p><strong>{{__('text.name')}}: </strong> {{$user->name}}</p>
                <p><strong>{{__('text.email')}}: </strong> {{$user->email}}</p>
                <p><strong>{{__('text.created')}}: </strong> {{$user->created_at}}</p>
                <p><strong>{{__('text.updated')}}: </strong> {{$user->updated_at}}</p>
                <p>
                    <strong>{{__('text.employee')}}: </strong> 
                    {{$user->getNameEmployee()}}
                </p>
            </div>
        </div>

        <p>{{trans_choice('text.role', 2)}}:</p>
        <ul>
        @foreach($user->roles as $role)
            <li>{{$role->name}}</li>
        @endforeach
        </ul>


        @can('update', $user)
        <form action="{{route('users.edit', ['user' => $user->id])}}" method="get" 
            class="pt-3">
            @csrf
            <button type="sumbit" class="btn btn-primary">
                {{__('text.edit')}}
            </button>
        </form>
        @endcan
    </div>
</div>


@endsection