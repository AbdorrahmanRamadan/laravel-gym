@extends('layouts.gym')
@section('title') All Gyms @endsection
@section('page_content')
<div class="" id="deleteStatus">

</div>
<div class="row header">
    <h2 class="col-10">All Gyms</h2>
    <a href="{{route('Gyms.create')}}" class="btn btn-success col-2">Create New Gym</a>
</div>
<div class="mt-4 gyms-content">
    <table id="admin-gyms" class="table table-striped" style="width:100%">
        <thead>
        @role('city_manager')
            <tr>
                <th class="gym-id">ID</th>
                <th class="gym-name">Name</th>
                <th class="created-at">Created At</th>
                <th class="cover-image">Cover Image</th>
                <th class="city-manager no-sort">Created_by</th>
                <th class="actions no-sort">Action</th>

            </tr>
        @endrole
        @role('admin')
            <tr>
                <th class="gym-id">ID</th>
                <th class="gym-name">Name</th>
                <th class="created-at">Created At</th>
                <th class="cover-image">Cover Image</th>
                <th class="city-manager no-sort">Created_by</th>
                <th class="city-manager no-sort">City Manager Name</th>
                <th class="actions no-sort">Action</th>
            </tr>
        @endrole

        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection
@push('script')
    @role('admin')
    <script>
        $(function() {
            $('#admin-gyms').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('Gyms.getGyms') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'cover_image', name: 'cover_image' , orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            if (!data) {
                                return `<img src="{{asset('storage/images/default_profilepicture.png')}}" class="w-50">`;
                            }
                            return `<img src="{{asset('storage/gymImages/${data}')}}" class="w-50">`;
                        }
                    },
                    { data: 'user.name', name:'user.name',  orderable: true, searchable: true},
                    { data: 'city_manager', name:'city_manager',  orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

        });
        function deleteGym(cityId) {
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
                    url: '/gyms/' + cityId,
                    dataType: 'json',
                    type: 'DELETE',

                    success: function(response) {
                        location.reload();
                    }

                })
            }
        })
    }
    </script>
    @endrole
    @role('city_manager')
    <script>
        $(function() {
            $('#admin-gyms').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('Gyms.getGyms') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'cover_image', name: 'cover_image' , orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            if (!data) {
                                return `<img src="{{asset('storage/images/default_profilepicture.png')}}" class="w-50">`;
                            }
                            return `<img src="{{asset('storage/gymImages/${data}')}}" class="w-50">`;
                        }
                    },
                    { data: 'user.name', name:'user.name',  orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

        });
        function deleteGym(gymId) {
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
                    url: '/gyms/' + gymId,
                    dataType: 'json',
                    type: 'DELETE',

                    success: function(response) {
                        $('#deleteStatus').text(response['success']);
                        $('#deleteStatus').addClass('alert alert-success')
                        location.reload();
                    },
                    error: function(){
                        location.reload();
                        $('#deleteStatus').text(response['danger']);
                        $('#deleteStatus').addClass('alert alert-danger')
                    }

                })
            }
        })
    }
    </script>
    @endrole
@endpush
