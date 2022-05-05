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
        <form method="POST" action="{{ route('Cities.store') }}" style="border:2px;"  >
            @csrf
            <div class="mb-3" style="margin-left: 380px; margin-top:87px;">
                <label for="exampleFormControlInput1" class="form-label">City Name</label>
                <input type="text" style="width: 45%" class="form-control" name="city_name" id="exampleFormControlInput1" placeholder="Enter City Name" value="{{ old('name') }}">
            </div>
          <button class="btn btn-success" style="margin-left:380px;">Create</button>
        </form>
@endsection  --}}




@extends('layouts.app')
@section('title')Create City @endsection

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
        <h3 class="card-title">Create City</h3>
    </div>

    <form id="quickForm" method="POST" action="{{ route('Cities.store') }}" >
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">City Name</label>
                <input  type="text" name="city_name" class="form-control" id="exampleInputName" placeholder="Enter City Name">
            </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>


@endsection


