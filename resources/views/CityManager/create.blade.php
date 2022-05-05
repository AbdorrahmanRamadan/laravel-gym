@extends('layouts.app')
@section('title') Create A City Manager @endsection


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
        <form method="POST" action="{{ route('citiesManagers.store') }}"  enctype="multipart/form-data" style="width:560px;margin-left:384px;margin-top:87px;">
            @csrf

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">National ID</label>
                <input type="text" class="form-control  " name="national_id" id="exampleFormControlInput1" placeholder="Enter National ID" value="{{ old('national_id') }}">

            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">City Manager </label>
                <select class="form-control" name="city_manager">
                    @foreach ($cityManagers as $cityManager)
                    <option value="{{ $cityManager->id }}">
                        {{ $cityManager->name }}
                    </option>
                @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">City</label>
                <select class="form-control" name="city_name">
                    @foreach ($cities as $city)
                    <option value="{{ $city->id }}">
                       {{ $city->name }}
                    </option>
                @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Upload Image</label>
                <input type="file" class="form-control" name="avatar_image"  />

            </div>


          <button class="btn btn-success">Create</button>
        </form>
@endsection

