@extends('layouts.gym')
@section('title') All Coaches  @endsection
@section('page_content')
<div class="" id="deleteStatus">

</div>
    <div class="text-center">
            <a href="{{ route('Coaches.create') }}" class="mt-4 btn btn-success" >Create New Coach</a>
        </div>
        <table id="coach" class="table mt-4">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">National ID</th>
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
        $('#coach').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('Coaches.getCoaches') }}",
            columns: [
                { data: 'user.id', name: 'user.id' },
                { data: 'user.name', name: 'user.name' ,orderable: true, searchable: true},
                { data: 'user.email', name: 'user.email' ,orderable: true, searchable: true},
                { data: 'national_id', name: 'national_id' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    function deleteCoach(coachId) {
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
                    url: '/coaches/' + coachId,
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
