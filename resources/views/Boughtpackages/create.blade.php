@extends('layouts.app')
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Buy Package</h3>
    </div>
  
    <form id="quickForm" method="POST" action="{{route('Boughtpackages.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Choose Trainee</label>
                <select class="form-control" name="trainee">
                    @foreach($trainees as $trainee)
                        <option  value="{{$trainee->user->id}}">{{$trainee->user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Choose Gym</label>
                <select class="form-control" name="gym">
                    @foreach($gyms as $gym)
                        <option  value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Choose Package</label>
                <select class="form-control" name="package">
                    @foreach($training_packages as $training_package)
                        <option  value="{{$training_package->id}}">{{$training_package->name}}</option>
                    @endforeach
                </select>
            </div>
           
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Buy</button>
        </div>
    </form>
</div>


@endsection
