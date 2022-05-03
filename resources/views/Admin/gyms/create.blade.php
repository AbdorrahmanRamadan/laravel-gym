@extends('layouts.admin')
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Create New Gym</h3>
    </div>
    <form id="quickForm">
        <div class="card-body">
            <div class="form-group">
                <label>Choose City</label>
                <select class="form-control">
                    <option value="1">Alex</option>
                    <option value="2">Cairo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" name="gym-name" class="form-control" id="exampleInputName" placeholder="Gym Name">
            </div>
            <div class="form-group">
                <label for="formFile" class="form-label">Gym Cover Image</label>
                <input class="form-control" type="file" id="formFile">    
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>


@endsection