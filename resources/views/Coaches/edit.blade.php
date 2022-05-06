@extends('layouts.gym')
@section('title') Coach Update @endsection

@section('page_content')
<form method="POST" action="{{ route('Coaches.update',['coach' => $coach['id']]) }}" class="m-4" enctype="multipart/form-data">
            @method('PUT')
            @csrf
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
              <input name="password" type="password" class="form-control" id="exampleFormControlInput3" placeholder="">
            </div>



            <div class="mb-3">
              <label for="exampleFormControlInput5" class="form-label">National ID</label>
              <input name="national_id" value="{{ $coach->national_id }}" type="text" class="form-control" id="exampleFormControlInput5" placeholder="">
            </div>

          <button class="btn btn-success my-3">Edit Coach</button>

        </form>
@endsection
