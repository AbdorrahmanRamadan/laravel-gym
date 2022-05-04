@extends('layouts.admin')
@section('title') Training Packages @endsection
@section('page_content')

    <div class="text-center">
            <a href="{{ route('Admin.TrainingPackages.create') }}" class="mt-4 btn btn-success">Create A New Package</a>
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
                ajax: "{{ route('Admin.TrainingPackages.getTrainingPackages')}}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'number_of_sessions', name: 'number_of_sessions' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
