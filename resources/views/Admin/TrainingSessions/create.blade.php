@extends('layouts.admin')
@section('title') Create A Training Session @endsection
@section('page_content')
<form method="POST" action="{{ route('Admin.TrainingSessions.store')}}" class="m-4">
            @csrf
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
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
            </div>
          <button class="btn btn-success my-3">Create</button>
        </form>
@endsection
