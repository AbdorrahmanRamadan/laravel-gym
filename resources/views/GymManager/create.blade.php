@extends('layouts.gym')
@section('page_content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Gym Manager</h3>
    </div>
    @role('admin')
    <form id="quickForm" method="POST" action="{{route('GymManager.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body p-4">
            <div class="form-group">
                <label for="exampleInputName">Manager Name</label>
                <input name="name" type="text" class="form-control" id="exampleInputName" placeholder="Gym Manager Name">
            </div>
            <div class="form-group">
                <label for="exampleInputNationalId">Manager Name ID</label>
                <input name="national-id" type="text" class="form-control" id="exampleInputNationalId" placeholder="Gym Manager National ID">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Manager Email</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail" placeholder="Gym Manager Email">
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
                <label for="formFile" class="form-label">Profile Image</label>
                <input name="profile-image" class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="form-group">
                <label>Choose City</label>
                <select id="cities" class="form-control" name="city">
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
                <label>Choose Gyms</label>
                <select id="gyms" class="form-control" name="gym">
                    @foreach($defaultCityGyms as $gym)
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Store</button>
        </div>
    </form>
    @endrole
    @role('city_manager')
    <form id="quickForm" method="POST" action="{{route('GymManager.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body p-4">
            <div class="form-group">
                <label for="exampleInputName">Manager Name</label>
                <input name="name" type="text" class="form-control" id="exampleInputName" placeholder="Gym Manager Name">
            </div>
            <div class="form-group">
                <label for="exampleInputNationalId">Manager Name ID</label>
                <input name="national-id" type="text" class="form-control" id="exampleInputNationalId" placeholder="Gym Manager National ID">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Manager Email</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail" placeholder="Gym Manager Email">
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
                <label for="formFile" class="form-label">Profile Image</label>
                <input name="profile-image" class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="form-group">
                <label>Choose Gym of {{$cities->name}} city</label>
                <select id="gyms" class="form-control" name="gym">
                    @foreach($gyms as $gym)
                        <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Store</button>
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
