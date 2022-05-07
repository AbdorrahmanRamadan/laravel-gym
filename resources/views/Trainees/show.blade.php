@extends('layouts.gym')
@section('title') Trainee Info @endsection

@section('page_content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">  Training Package Info </h3>
    </div>
    <form id="quickForm" >

        <div class="card-body">

            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Name: </label>
              {{ $trainee->user->name }}
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput2" class="form-label">Email: </label>
              {{ $trainee->user->email }}
            </div>




            <div class="mb-3">
              <label for="exampleFormControlInput4" class="form-label">Birth Date: </label>
              {{ $trainee->birth_date }}
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput4" class="form-label">Gender: </label>
              {{ $trainee->gender }}
            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">Trainee Image: </label>
                <img id="original" src="{{asset('/storage/trainees_images/'.$trainee->avatar_image)}}" height="70px" width="70px">

            </div>

</form>
</div>

@endsection
