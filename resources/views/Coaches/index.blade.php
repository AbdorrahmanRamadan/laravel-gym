@extends('layouts.gym')
@section('title') All Coaches  @endsection
@section('page_content')
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
    </script>

@endpush
