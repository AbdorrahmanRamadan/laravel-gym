@extends('layouts.gym')
@section('title') Create A Training Package @endsection
@section('page_content')
<form method="POST" action="{{ route('TrainingPackages.store')}}" class="m-4">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Price</label>
                <input name="price" type="number" class="form-control" id="exampleFormControlInput2" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Number of sessions</label>
                <input name="number_of_sessions" type="number" class="form-control" id="exampleFormControlInput3" placeholder="">
              </div>
          <button class="btn btn-success my-3">Create</button>
        </form>
@endsection
