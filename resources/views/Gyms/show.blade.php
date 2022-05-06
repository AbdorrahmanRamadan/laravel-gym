@extends('layouts.app')
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Gym Info</h3>
    </div>
    <form id="quickForm" >

        <div class="card-body">
            <div class="form-group">
                <label> City Name</label>
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
                <img id="original" src="{{asset('/storage/gymImages/'.$gym->cover_image )}}" height="70px" width="70px">
            </div>
        </div>

    </form>
</div>


@endsection
