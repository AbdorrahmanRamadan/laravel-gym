{{--  @extends('layouts.app')


@section('page_content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form  method="POST" action="{{ route('Cities.update',$city->id) }}" >
            @csrf
            @method('PUT')
            <div class="mb-3" style="margin-left: 380px; margin-top:87px;">
                <label for="exampleFormControlInput1" class="form-label">City Name</label>
                <input type="text" class="form-control"  style="width: 45%" id="exampleFormControlInput1" name="city_name" value="{{ $city->name }}">
            </div>
          <button class="btn btn-success" style="margin-left:550px;">Edit</button>
        </form>
@endsection  --}}



@extends('layouts.app')
@section('title')Edit City @endsection

@section('page_content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit City</h3>
    </div>

    <form id="quickForm" method="POST" action="{{ route('Cities.update',$city->id) }}" >
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">City Name</label>
                <input  type="text" name="city_name" class="form-control" id="exampleInputName"  value="{{ $city->name }}">
            </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>


@endsection

