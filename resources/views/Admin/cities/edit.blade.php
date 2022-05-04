@extends('layouts.app')

@section('title')Edit @endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form  method="POST" action="{{ route('cities.update',$city->id) }}" >
            @csrf
            @method('PUT')
            <div class="mb-3" style="margin-left: 380px; margin-top:87px;">
                <label for="exampleFormControlInput1" class="form-label">City Name</label>
                <input type="text" class="form-control"  style="width: 45%" id="exampleFormControlInput1" name="city_name" value="{{ $city->name }}">
            </div>
          <button class="btn btn-success" style="margin-left:550px;">Edit</button>
        </form>
@endsection

