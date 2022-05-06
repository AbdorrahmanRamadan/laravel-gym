





@extends('layouts.gym')
@section('page_content')
@section('title')  Training Package Info @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">  Training Package Info </h3>
    </div>

    <form id="quickForm" >

        <div class="card-body">

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



        </div>

    </form>
</div>


@endsection



