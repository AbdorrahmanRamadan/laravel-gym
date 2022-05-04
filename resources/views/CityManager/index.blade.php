@extends('layouts.admin')
@section('page_content')

<div class="row header">
    <h2 class="col-10">City Managers</h2>
    <a href="{{ route('citiesManagers.create') }}" class="btn btn-success col-2" style="width:150px;">Add  Manager</a>
</div>
<div class="mt-4 gyms-content">
    <table id="citiesManagers" class="table table-striped" style="width:100%">
        <thead>
            <tr>


                <th class="gym-id">ID</th>
                <th class="city-name">National ID</th>
                <th class="created-at">City Name</th>
                <th class="cover-image">Avatar</th>
                <th class="actions no-sort">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection

