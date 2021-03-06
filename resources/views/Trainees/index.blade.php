@extends('layouts.gym')
@section('title') All Trainees @endsection

@section('page_content')
<div class="" id="deleteStatus">

</div>
    <div class="text-center">
            <a href="{{ route('Trainees.create') }}" class="mt-4 btn btn-success">Create New Trainee</a>
        </div>
        <table class="table mt-4" id="admin-trainee">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Gender</th>
                <th scope="col">Remaining Sessions</th>
                <th scope="col">Profile Image</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
          </table>
@endsection
@push('script')
<script>
    $(function() {
        $('#admin-trainee').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('Trainees.getTrainees') }}",
            columns: [
                { data: 'user.id', name: 'user.id' },
                { data: 'user.name', name: 'user.name' ,orderable: true, searchable: true},
                { data: 'user.email', name: 'user.email' ,orderable: true, searchable: true},
                { data: 'birth_date', name: 'birth_date' },
                { data: 'gender', name: 'gender'},
                { data: 'remaining_sessions', name: 'remaining_sessions' },
                { data: 'avatar_image', name: 'avatar_image' , orderable: false, searchable: false,
                    render: function( data, type, full, meta ) {
                        return `<img src="{{asset('storage/trainees_images/${data}')}}" class="w-50">`;
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}

            ]
        });
    });
    function deleteTrainee(traineeId) {
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
                    url: '/trainees/' + traineeId,
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
