


@extends('layouts.gym')
@section('page_content')
@section('title') Edit City Manager @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit City Manager</h3>
    </div>
    @error('image_extension')
        <div class="error">invalid</div>
    @enderror
    <form id="quickForm" method="POST" action="{{ route('citiesManagers.update',$cityManager->city_manager_id) }}"  enctype="multipart/form-data" enctype="multipart/form-data">
        @csrf
         @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">National ID</label>
                <input name="national_id" type="text" class="form-control" id="exampleInputName" value="{{ $cityManager->national_id }}">
            </div>

            <div class="form-group">
                <label for="exampleInputName"> Name</label>
                <input name="name" type="text" class="form-control" id="exampleInputName" value="{{ $cityManager->user->name }}">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Email Address</label>
                <input name="email" type="email" class="form-control" id="exampleInputName" value="{{ $cityManager->user->email }}">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputName" required>
            </div>


            <div class="form-group">
                <label>Choose City </label>
                <select class="form-control" name="city_name">
                    @foreach ($cities as $city)
                    @if($cityManager->cities->id==$city->id)
                        <option value="{{$city->id}}" selected>{{$city->name}}</option>
                    @else
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endif
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">City Manager Image</label>
                <img id="original" src="{{asset('/storage/images/'.$cityManager->avatar_image)}}" height="70px" width="70px">
                <input type="file" name="avatar_image" value="{{ $cityManager->avatar_image }}" />
                <input type="hidden" name="image" value="{{ $cityManager->avatar_image }}"/>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>


@endsection


