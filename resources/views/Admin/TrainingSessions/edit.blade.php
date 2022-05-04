@extends('layouts.admin')
@section('title') Edit Training Session @endsection
@section('page_content')
<form method="POST" action="{{ route('Admin.TrainingSessions.update',['session'=>$session['id']])}}" class="m-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Starting Time</label>
                <input name="start_at" type="datetime-local" class="form-control" id="exampleFormControlInput2" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">End Time</label>
                <input name="end_at" type="datetime-local" class="form-control" id="exampleFormControlInput3" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Gym</label>
                <select name="gym_id" type="number" class="form-control" id="exampleFormControlInput3" placeholder="">
                    @foreach ($gyms as $gym)
                        @if($selectedGym->id==$gym->id)
                            <option value="{{$gym->id}}" selected>{{$gym->name}}</option>
                        @else
                            <option value="{{$gym->id}}">{{$gym->name}}</option>
                        @endif
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
            </div>
          <button class="btn btn-primary my-3">Save</button>
        </form>
@endsection
