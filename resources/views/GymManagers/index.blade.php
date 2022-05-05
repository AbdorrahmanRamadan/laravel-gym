@extends('layouts.admin')
@section('page_content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="row header">
    <h2 class="col-10">All Gyms</h2>
    <a href="" class="btn btn-success col-2">Create New Gym</a>
</div>
<div class="mt-4 gyms-content">
    <table id="admin-gym-managers" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th class="gym-manager-id">ID</th>
                <th class="gym-manager-name">Name</th>
                <th class="cover-image">Cover Image</th>
                <th class="user-email">Email</th>
                <th class="national-id">National ID</th>
                <th class="gym-name">Gym Name</th>
                <th class="created-at">Created At</th>
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
        $('#admin-gym-managers').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('Admin.GymManagers.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.name', name: 'user.name' },
                { data: 'avatar_image', name: 'avatar_image' , orderable: false, searchable: false,
                    render: function( data, type, full, meta ) {
                        return `<img src="{{asset('storage/gymManagers/${data}')}}" class="w-50">`;
                    }
                },
                { data: 'user.email', name: 'user.email' },
                { data: 'national_id', name: 'national_id' },
                { data: 'gym.name', name:'gym.name',  orderable: true, searchable: true},
                { data: 'created_at', name: 'created_at' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        
    });
    </script>
@endpush