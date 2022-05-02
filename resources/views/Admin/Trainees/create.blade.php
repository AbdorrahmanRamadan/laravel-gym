@extends('layouts.admin')

@section('page_content')
<!-- ///////////////////////////////////////////////////////////////////////////////////////// -->
<form method="POST" action="{{ route('Admin.Trainees.store')}}" class="m-4">
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
                <label for="exampleFormControlInput4" class="form-label">Gender</label>
                <select name="gender" class="form-control">
                <option value=""> Male </option>
                <option value=""> Female </option>
                </select>
            </div>

          <button class="btn btn-success my-3">Create/Add/Save</button>

        </form>
<!-- ///////////////////////////////////////////////////////////////////////////////////////// -->
@endsection
