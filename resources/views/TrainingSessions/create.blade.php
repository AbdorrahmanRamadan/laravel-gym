@extends('layouts.app')
@section('title') Create A Training Session @endsection
@section('page_content')
<form method="POST" action="{{ route('TrainingSessions.store')}}" class="m-4">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Starting Time</label>
                <input name="start_at" type="datetime-local" class="form-control" id="exampleFormControlInput2" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">End Time</label>
                <input name="end_at" type="datetime-local" class="form-control" id="exampleFormControlInput3" placeholder="">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Gym</label>
                <select name="gym_id" type="number" class="form-control" id="exampleFormControlInput3" placeholder="">
                    @foreach ($gyms as $gym)
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Coach</label>
                <div class="form-group" data-select2-id="44">
                    <select name="coach[]" class="select2 select2-hidden-accessible" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
                        @foreach ($coaches as $coach)
                                <option data-select2-id="{{$coach->id}}" value="{{$coach->id}}">{{$coach->user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          <button class="btn btn-success my-3">Create</button>
        </form>
@endsection
@push('script')
    <script>
        $(function () {
            $('.select2').select2({
                placeholder: "Select a state",
                allowClear: true,
                tags: true,
                tokenSeparators: [' ']
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        })
    </script>
@endpush
