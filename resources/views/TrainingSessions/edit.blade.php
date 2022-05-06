@extends('layouts.gym')
@section('title') Edit Training Session @endsection
@section('page_content')
<form method="POST" action="{{ route('TrainingSessions.update',['session'=>$session['id']])}}" class="m-4">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{$session['name']}}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Starting Time</label>
                <input name="start_at" type="datetime-local" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{$session['start_at']}}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">End Time</label>
                <input name="end_at" type="datetime-local" class="form-control" id="exampleFormControlInput3" placeholder="" value="{{$session['end_at']}}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Gym</label>
                <select name="gym_id" type="number" class="form-control" id="exampleFormControlInput3" placeholder="" >
                    @foreach ($gyms as $gym)
                        @if($selectedGym->id==$gym->id)
                            <option value="{{$gym->id}}" selected>{{$gym->name}}</option>
                        @else
                            <option value="{{$gym->id}}">{{$gym->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Coach</label>
                <div class="form-group" data-select2-id="44">
                    <select name="coach[]" class="select2 select2-hidden-accessible" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
                        @foreach ($coaches as $coach)
                                @if($selectedCoaches->contains($coach->id))
                                <option data-select2-id="{{$coach->id}}" value="{{$coach->id}}" selected>{{$coach->user->name}}</option>
                                @else
                                <option data-select2-id="{{$coach->id}}" value="{{$coach->id}}">{{$coach->user->name}}</option>
                                @endif
                        @endforeach
                    </select>

                </div>
            </div>
          <button class="btn btn-primary my-3">Save</button>
        </form>
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

