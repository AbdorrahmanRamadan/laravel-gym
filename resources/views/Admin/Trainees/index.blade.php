@extends('layouts.admin')

@section('page_content')
    <div class="text-center">
            <a href="{{ route('Admin.Trainees.create') }}" class="mt-4 btn btn-success">Create New Trainee</a>
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
            ajax: "{{ route('Admin.Trainees.getTrainees') }}",
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
    </script>
@endpush
