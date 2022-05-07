@extends('layouts.gym')
@section('title')City Managers @endsection

@section('page_content')
<div class="" id="deleteStatus">

</div>
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
                <th class="created-at">Manager Name</th>
                <th class="created-at">Manager Email</th>
                <th class="cover-image">Avatar</th>
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
        $('#citiesManagers').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('cities-Managers-list') }}",
            columns: [
                { data: 'city_manager_id', name: 'city_manager_id',orderable: true, searchable: true },
                { data: 'national_id', name: 'national_id',orderable: true, searchable: true },
                { data: 'city_id', name: 'city_id' },
                { data: 'user.name', name: 'user.name' },
                { data: 'user.email', name: 'user.email' },
                { data: 'avatar_image', name: 'avatar_image' , orderable: false, searchable: false,
                    render: function( data, type, full, meta ) {
                        if (!data) {
                            return `<img src="{{asset('storage/images/default_profilepicture.png')}}" class="w-50">`;
                        }
                        return `<img src="{{asset('storage/images/${data}')}}" class="w-50">`;
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    });
    function deleteCityManager(cityManagerId) {
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
                    url: '/citiesManager/' + cityManagerId,
                    dataType: 'json',
                    type: 'DELETE',

                    success: function(response) {
                        $('#deleteStatus').text(response['success']);
                        $('#deleteStatus').addClass('alert alert-success')
                        location.reload();
                    }

                })
            }
        })
    }







</script>

@endpush

