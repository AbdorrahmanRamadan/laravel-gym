

@extends('layouts.gym')
@section('page_content')
@section('title')  City Manager Info @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"> City Manager Info</h3>
    </div>

    <form id="quickForm" >
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputName">National ID:  </label>
                {{ $cityManager->national_id }}
            </div>

            <div class="form-group">
                <label for="exampleInputName">City Manager Name:  </label>
        {{ $cityManager->user->name }}

            </div>

            <div class="form-group">
                <label for="exampleInputName">Email Address: </label>
        {{ $cityManager->user->email }}
            </div>

            <div class="form-group">
                <label for="exampleInputName">Password:  </label>
          {{ $cityManager->user->password }}
            </div>


            <div class="form-group">
                <label> City Name:  </label>
                @foreach ($cities as $city)
                {{ $city->name }}
                @endforeach

            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">City Manager Image</label>
                <img id="original" src="{{asset('/storage/images/'.$cityManager->avatar_image)}}" height="70px" width="70px">

            </div>
        </div>

    </form>
</div>


@endsection


