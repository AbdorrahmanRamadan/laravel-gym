

@extends('layouts.gym')
@section('page_content')
@section('title')Training Sessions Info @endsection

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Training Sessions Info</h3>
    </div>

    <form id="quickForm" >

        <div class="card-body">

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name: </label>
                {{$session['name']}}
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Starting Time: </label>
                {{$session['start_at']}}
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">End Time</label>
                {{$session['end_at']}}
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Gym:</label>
                @foreach ($gyms as $gym)
                {{$gym->name}}
                @endforeach
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Coach:</label>
                @foreach ($coaches as $coach)
                {{$coach->user->name}}
                @endforeach

            </div>
        </div>

    </form>
</div>


@endsection



@push('script')
    <script>
        $(function () {
            $('.select2').select2({
                allowClear: true,
                dropdownCssClass:'ddx',
                selectionCssClass:'ssx',
            });
        })
    </script>
@endpush

