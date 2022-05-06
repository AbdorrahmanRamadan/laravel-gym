@extends('layouts.gym')
@section('title') Edit Training Package @endsection
@section('page_content')
<form method="POST" action="{{ route('TrainingPackages.update',['package'=>$package['id']])}}" class="m-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{$package['name']}}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Price</label>
                <input name="price" type="number" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{$package['price']/100}}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Number of sessions</label>
                <input name="number_of_sessions" type="number" class="form-control" id="exampleFormControlInput3" placeholder="" value="{{$package['number_of_sessions']}}">
            </div>
          <button class="btn btn-primary my-3">Save</button>
        </form>
@endsection
