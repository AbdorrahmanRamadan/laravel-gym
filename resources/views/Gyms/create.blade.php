@extends('layouts.app')
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Create New Gym</h3>
    </div>
    @error('image_extension')
        <div class="error">invalid</div>
    @enderror
    <form id="quickForm" method="POST" action="{{route('Gyms.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Choose City</label>
                <select class="form-control" name="city">
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input name="name" type="text" name="gym-name" class="form-control" id="exampleInputName" placeholder="Gym Name">
            </div>
            <div class="form-group">
                <label for="formFile" class="form-label">Gym Cover Image</label>
                <input name="cover-image" class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>


@endsection
