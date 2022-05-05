

@extends('layouts.app')
@section('page_content')
@section('title') Create A City Manager @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add City Manager</h3>
    </div>
    @error('image_extension')
        <div class="error">invalid</div>
    @enderror
    <form id="quickForm" method="POST" action="{{ route('citiesManagers.store') }}"  enctype="multipart/form-data" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">National ID</label>
                <input name="national_id" type="text" class="form-control" id="exampleInputName" placeholder="Enter National ID" value="{{ old('national_id') }}">
            </div>

            <div class="form-group">
                <label for="exampleInputName"> Name</label>
                <input name="name" type="text" class="form-control" id="exampleInputName" placeholder="Enter Name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Email Address</label>
                <input name="email" type="email" class="form-control" id="exampleInputName" placeholder="Text@example.com" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputName" placeholder="Enter Password" value="{{ old('password') }}">
            </div>



            <div class="form-group">
                <label>Choose City </label>
                <select class="form-control" name="city_name">
                    @foreach($filtered as $city)
                    <option value="{{ $city->id }} ">
                        {{ $city->name }}
                        </option>
@endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">City Manager Image</label>
                <input name="avatar_image" class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>


@endsection


