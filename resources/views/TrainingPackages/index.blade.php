@extends('layouts.gym')
@section('title') Training Packages @endsection
@section('page_content')
<div class="" id="deleteStatus">

</div>
    <div class="text-center">
            <a href="{{ route('TrainingPackages.create') }}" class="mt-4 btn btn-success">Create A New Package</a>
        </div>
        <table class="table mt-4" id="packages_table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">price</th>
                <th scope="col">Number of sessions</th>
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
            $('#packages_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('TrainingPackages.getTrainingPackages')}}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'number_of_sessions', name: 'number_of_sessions' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
        function deleteTrainingPackage(trainingPackageId) {
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
                    url: '/packages/' + trainingPackageId,
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
