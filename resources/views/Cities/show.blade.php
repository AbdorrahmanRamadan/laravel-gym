

@extends('layouts.gym')
@section('title')Show City @endsection


@section('page_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Show City</h3>
    </div>

    <form id="quickForm" >
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">City Name: </label>

                {{ $city->name }}

            </div>


    </form>
</div>


@endsection

