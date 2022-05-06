@extends('layouts.gym')
@section('title')Create City @endsection
@section('page_content')


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


