@extends('layouts.gym')
@section('title') Show Gym Manager @endsection
@section('page_content')
@section('title') Gym Manager Info @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"> Gym Manager Info</h3>
    </div>

    <form id="quickForm">
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">Manager Name: </label>
                {{$gymManagerInfo->user->name}}
            </div>

            <div class="form-group">
                <label for="exampleInputName">Manager ID: </label>
                {{$gymManagerInfo->national_id}}

            </div>

            <div class="form-group">
                <label for="exampleInputName">Email Address: </label>
                {{$gymManagerInfo->user->email}}
            </div>



            <div class="form-group">
                <label> Gym Name : </label>
               {{$gymManagerInfo->gym->name}}

            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">City Manager Image:</label><br>
                <img id="original" src="{{asset('/storage/gymManagers/'.$gymManagerInfo->avatar_image)}}" height="270px" width="270px">

            </div>
        </div>

    </form>
</div>


@endsection
