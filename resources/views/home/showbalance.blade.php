@extends('layouts.app')

@section('title', 'Balance')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('text.Balance') }}</div>

                <div class="card-body">

                    <div class="container">


<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">{{ __('text.subdivision') }}</th>
      <th scope="col">{{ __('text.nomenclature') }}</th>
      <th scope="col">{{ __('text.qty') }}</th>
    </tr>
  </thead>
  <tbody>

    @foreach($table as $row)
    <tr>
      <td>{{$row->subname}}</td>
      <td>{{$row->nomname}}</td>
      <td>
          @if($row->qty < 0)
            <span class="badge badge-danger">{{$row->qty}}</span>
          @else
            {{$row->qty}}
          @endif
      </td>
    </tr>
    @endforeach

  </tbody>
</table>


                    </div>                    

                </div>
            </div>
        </div>
    </div>
</div>



@endsection
