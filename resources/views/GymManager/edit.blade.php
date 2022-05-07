@extends('layouts.gym')
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Gym Manager</h3>
    </div>
    @role('admin')
    <form id="quickForm" method="POST" action="{{route('GymManager.update', $gymManagerInfo->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="form-group">
                <label for="exampleInputName">Manager Name</label>
                <input value="{{$gymManagerInfo->user->name}}" name="name" type="text" class="form-control" id="exampleInputName" placeholder="Gym Manager Name">
            </div>
            <div class="form-group">
                <label for="exampleInputNationalId">Manager  ID</label>
                <input value="{{$gymManagerInfo->national_id}}" name="national-id" type="text" class="form-control" id="exampleInputNationalId" placeholder="Gym Manager National ID">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Manager Email</label>
                <input value="{{$gymManagerInfo->user->email}}" name="email" type="text" class="form-control" id="exampleInputEmail" placeholder="Gym Manager Email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword" placeholder="Gym Manager Password">
            </div>
            <div class="form-group">
                <label for="exampleInputConfirmPass">Confirm Password</label>
                <input name="confirm-password" type="password" class="form-control" id="exampleInputConfirmPass" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <img  id="original" src="{{asset('/storage/gymManagers/'.$gymManagerInfo->avatar_image)}}" height="60" width="60">
                <input class="form-control" type="file" name="avatar_image" value="{{ $gymManagerInfo->avatar_image }}" />
                <input type="hidden" name="profile-image" value="{{ $gymManagerInfo->avatar_image }}"/>
             </div>
        </div>
        <div class="form-group">
                <label>Choose City</label>
                <select id="cities" class="form-control" name="city">
                    @foreach($cities as $city)
                        @if($city->id == $gymManagerInfo->gym->city->id)
                        <option value="{{$city->id}}" selected>{{$city->name}}</option>
                        @endif
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
                <label>Choose Gyms</label>
                <select id="gyms" class="form-control" name="gym">
                    @foreach($cityGyms as $gym)
                        @if($gym->id == $gymManagerInfo->gym->id)
                        <option value="{{$gym->id}}" selected>{{$gym->name}}</option>
                        @endif
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    @endrole
    @role('city-manager')
    <form id="quickForm" method="POST" action="{{route('GymManager.update', $gymManagerInfo->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body p-4">
            <div class="form-group">
                <label for="exampleInputName">Manager Name</label>
                <input value="{{$gymManagerInfo->user->name}}" name="name" type="text" class="form-control" id="exampleInputName" placeholder="Gym Manager Name">
            </div>
            <div class="form-group">
                <label for="exampleInputNationalId">Manager Name ID</label>
                <input value="{{$gymManagerInfo->national_id}}" name="national-id" type="text" class="form-control" id="exampleInputNationalId" placeholder="Gym Manager National ID">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Manager Email</label>
                <input value="{{$gymManagerInfo->user->email}}" name="email" type="text" class="form-control" id="exampleInputEmail" placeholder="Gym Manager Email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword" placeholder="Gym Manager Password">
            </div>
            <div class="form-group">
                <label for="exampleInputConfirmPass">Confirm Password</label>
                <input name="confirm-password" type="password" class="form-control" id="exampleInputConfirmPass" placeholder="Gym Manager Email">
            </div>
            <div class="form-group">
                <img  id="original" src="{{asset('/storage/gymManagers/'.$gymManagerInfo->avatar_image)}}" height="60" width="60">
                <input class="form-control" type="file" name="avatar_image" value="{{ $gymManagerInfo->avatar_image }}" />
                <input type="hidden" name="profile-image" value="{{ $gymManagerInfo->avatar_image }}"/>
             </div>
        </div>
        <div class="form-group">
                <label>Choose Gym of {{$cities->name}} city</label>
                <select id="gyms" class="form-control" name="gym">
                    @foreach($cities->gym as $gym)
                        @if($gym->id == $gymManagerInfo->gym->id)
                        <option value="{{$gym->id}}" selected>{{$gym->name}}</option>
                        @endif
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    @endrole
</div>
@endsection
@push('script')

<script>
    $(function() {
        $('#cities').on('change', function() {
            var cityId = $(this).val();
            if(cityId) {
                $.ajax({
                    url: '/gymsManagers/create/'+cityId,
                    type: "GET",
                    dataType: "json",
                    success:function(data)
                    {
                        if(data){
                        $('#gyms').empty();
                        $('#gyms').append('<option hidden>Choose Gym</option>');
                        $.each(data, function(key, gym){
                            $('select[name="gym"]').append('<option value="'+ gym.id +'">' + gym.name+ '</option>');
                        });
                    }else{
                        $('#gyms').empty();
                    }
                    }
                });
            }else{
                $('#gyms').empty();
            }
        });
    });
</script>

@endpush
