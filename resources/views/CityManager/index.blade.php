@extends('layouts.app')
@section('title')City Managers @endsection

@section('page_content')

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
                    { data: 'cities.name', name: 'cities.name' },
                    { data: 'avatar_image', name: 'avatar_image' , orderable: false, searchable: false,
                        render: function( data, type, full, meta ) {
                            return `<img src="{{asset('storage/images/${data}')}}" class="w-50">`;
                        }
                    },
                ]
            });

        });


    </script>
@endpush

