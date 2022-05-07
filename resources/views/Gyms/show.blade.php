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
                {{$gym->city->name}}

            </div>
            <div class="form-group">
                <label > Gym Name :</label>
                     {{$gym->name}}
            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">Gym Cover Image: </label> <br>
                <img id="original" src="{{asset('/storage/gymImages/'.$gym->cover_image )}}" height="70px" width="70px">
            </div>
        </div>

    </form>
</div>


@endsection
