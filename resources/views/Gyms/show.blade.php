@extends('layouts.gym')
@section('title') Show Gym @endsection
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Gym Info</h3>
    </div>
    <form id="quickForm" >

        <div class="card-body">
            <div class="form-group">
                <label> City Name : </label>
                <label> {{$gym->city->name}} </label>

            </div>
            <div class="form-group">
                <label > Gym Name : {{$gym->name}}</label>
            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">Gym Cover Image</label> <br>
                <img id="original" src="{{asset('/storage/gymImages/'.$gym->cover_image )}}" height="270px" width="270px">
            </div>
        </div>

    </form>
</div>


@endsection
