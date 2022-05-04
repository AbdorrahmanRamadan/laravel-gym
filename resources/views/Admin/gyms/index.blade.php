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
@push('script')
<script>
    $(function() {
        $('#admin-gyms').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('Admin.gyms.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'cover_image', name: 'cover_image' , orderable: false, searchable: false,
                    render: function( data, type, full, meta ) {
                        return `<img src="{{asset('storage/gymImages/${data}')}}" class="w-50">`;
                    }
                },
                { data: 'user.name', name:'user.name',  orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        
    });
    </script>
@endpush