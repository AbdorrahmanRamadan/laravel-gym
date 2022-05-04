@extends('layouts.admin')
@section('page_content')


<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<div class="row header">
    <h2 class="col-10">All Cities</h2>
    <br>
    <a href="{{ route('cities.create') }}" style="margin-top: 10px;" class="btn btn-success col-1" name="create_record" id="create_record">Add City</a>
</div>
<br>
<div class="container">
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection

@push('script')
<script>
$(function () {

var table = $('.data-table').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('cities-list') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'name', name: 'name'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

});
</script>
@endpush

