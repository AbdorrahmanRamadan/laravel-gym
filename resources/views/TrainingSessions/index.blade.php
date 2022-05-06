@extends('layouts.gym')
@section('title') Training Sessions @endsection
@section('page_content')

    <div class="text-center">
            <a href="{{ route('TrainingSessions.create') }}" class="mt-4 btn btn-success">Create A New Session</a>
        </div>
        <table class="table mt-4" id="sessions_table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Starting Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Gym</th>
                <th scope="col">Coach</th>
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
            $('#sessions_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('TrainingSessions.getTrainingSessions')}}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'start_at', name: 'start_at' },
                    { data: 'end_at', name: 'end_at' },
                    { data: 'gym.name', name: 'gym.name' },
                    { data: 'coach', name: 'coach' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
