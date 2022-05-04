@extends('layouts.admin')
@section('page_content')

<div class="row header">
    <h2 class="col-10">All Gyms</h2>
    <a href="{{route('Admin.gyms.create')}}" class="btn btn-success col-2">Create New Gym</a>
</div>
<div class="mt-4 gyms-content">
    <table id="admin-gyms" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th class="gym-id">ID</th>
                <th class="gym-name">Name</th>
                <th class="created-at">Created At</th>
                <th class="cover-image">Cover Image</th>
                <th class="city-manager no-sort">City Manager Name</th>
                <th class="actions no-sort">Action</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table> 
</div>
@endsection