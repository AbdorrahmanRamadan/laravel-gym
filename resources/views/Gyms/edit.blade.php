@extends('layouts.gym')
@section('title') Edit Gym @endsection

@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Gym</h3>
    </div>
    <form id="quickForm" method="POST" action="{{route('Gyms.update', $gym->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Choose City</label>
                <select class="form-control" name="city">
                    @foreach($cities as $city)
                        @if($city->id == $gym->city_id)
                            <option value="{{$city->id}}" selected>{{$gym->city->name}}</option>
                        @else
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input name="name" value="{{$gym->name}}" type="text" name="gym-name" class="form-control" id="exampleInputName" placeholder="Gym Name">
            </div>
            <div class="form-group">
                <label for="formFile" class="form-label">Gym Cover Image</label>
                <input name="cover-image"  class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>


@endsection
