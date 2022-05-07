


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
                <label for="exampleFormControlInput1" class="form-label">Name: </label>
               {{ $coach->user->name }}
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Email: </label>
               {{ $coach->user->email }}
              </div>


              <div class="mb-3">
                <label for="exampleFormControlInput5" class="form-label">National ID</label>
            {{ $coach->national_id }}
              </div>

        </div>

    </form>
</div>


@endsection



