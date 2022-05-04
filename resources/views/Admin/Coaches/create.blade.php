@extends('layouts.admin')

@section('page_content')
<form method="POST" action="{{ route('Admin.Coaches.store')}}" class="m-4" enctype="multipart/form-data">
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
              <label for="exampleFormControlInput4" class="form-label">Confirm Password</label>
              <input name="password_confirmation" type="password" class="form-control" id="exampleFormControlInput4" placeholder="">
            </div>

            <div class="mb-3">
              <label for="exampleFormControlInput5" class="form-label">National ID</label>
              <input name="national_id" type="text" class="form-control" id="exampleFormControlInput5" placeholder="">
            </div>
           
          <button class="btn btn-success my-3">Add Coach</button>

        </form>
@endsection