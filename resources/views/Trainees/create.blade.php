@extends('layouts.gym')
@section('title') Create Trainee @endsection

@section('page_content')

<form method="POST" action="{{ route('Trainees.store')}}" class="m-4" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Name</label>
              <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput2" class="form-label">Email</label>
              <input name="email" type="email" class="form-control" id="exampleFormControlInput2" placeholder="">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput3" class="form-label">Password</label>
              <input name="password" type="password" class="form-control" id="exampleFormControlInput3" placeholder="">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput3" class="form-label">Confirm Password</label>
              <input name="password_confirmation" type="password" class="form-control" id="exampleFormControlInput3" placeholder="">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput4" class="form-label">Birth Date</label>
              <input name="birth_date" type="date" class="form-control" id="exampleFormControlInput4" placeholder="">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput4" class="form-label">Gender</label>
              <select name="gender" class="form-control">
              <option value="Male"> Male </option>
              <option value="Female"> Female </option>
              </select>
            </div>

            <div>
              <label class="form-label" for="customFile">Upload an Image</label>
              <input type="file" class="form-control" id="customFile" name="avatar_image"/>
            </div>

          <button class="btn btn-success my-3">Add Trainee</button>
</form>
@endsection
