
@extends('layouts.gym')

@section('page_content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="" id="deleteStatus">

</div>
<div class="row header">
    <h2 class="col-10">All Gym Managers</h2>
    <a href="{{route('GymManager.create')}}" class="btn btn-success col-2">Add New Manager</a>
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
            ajax: "{{ route('GymManager.index') }}",
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
    function deleteManager(gymManagerId){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:'/gymsManagers/'+gymManagerId,
                    dataType:'json',
                    type:'DELETE',

                    success:function(response){
                        location.reload();
                    }

                })
            }
        })
        }

    </script>
@endpush
