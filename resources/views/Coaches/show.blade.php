


@extends('layouts.gym')
@section('page_content')
@section('title')  Coach Info @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"> Coach Info</h3>
    </div>

    <form id="quickForm" >

        <div class="card-body">

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input name="name" value="{{ $coach->user->name }}" type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Email</label>
                <input name="email" value="{{ $coach->user->email }}" type="email" class="form-control" id="exampleFormControlInput2" placeholder="">
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Password</label>
                <input name="password" value="{{ $coach->user->password }}" type="password" class="form-control" id="exampleFormControlInput3" placeholder="">
              </div>



              <div class="mb-3">
                <label for="exampleFormControlInput5" class="form-label">National ID</label>
                <input name="national_id" value="{{ $coach->national_id }}" type="text" class="form-control" id="exampleFormControlInput5" placeholder="">
              </div>

        </div>

    </form>
</div>


@endsection



