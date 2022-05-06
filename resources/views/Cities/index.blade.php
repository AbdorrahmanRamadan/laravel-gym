

@extends('layouts.gym')
@section('title') All Cities @endsection

@section('page_content')

<div class="row header">
    <h2 class="col-10">All Cities</h2>
    <a href="{{ route('Cities.create') }}" class="btn btn-success col-2" style="width:120px;">Create City</a>
</div>
<div class="mt-4 gyms-content">
    <table id="cities" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th class="city-id">ID</th>
                <th class="city-name">Name</th>
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
        $('#cities').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('Cities.getCities') }}",
            columns: [
                { data: 'id', name: 'id' ,orderable: true, searchable: true},
                { data: 'name', name: 'name',orderable: true, searchable: true },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    });


    function deleteCity(city){
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
                    url:'/cities/'+city,
                    dataType:'json',
                    type:'DELETE',

                    success:function(response){
                        location.reload();
                    }

                })
            }
        })

        }


</script>

@endpush






