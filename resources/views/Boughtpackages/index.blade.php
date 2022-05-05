@extends('layouts.app')

@section('page_content')
<div class="text-center">
    <a href="{{ route('Boughtpackages.create') }}" class="mt-4 btn btn-success">Buy new Package</a>
</div>
<table class="table mt-4" id="bought_package">
    <thead>
        <tr>
            <th scope="col">Trainee Name</th>
            <th scope="col">Gym Name</th>
            <th scope="col">Package Name</th>
            <th scope="col"> Price</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

    <tbody>
    </tbody>
    <tbody>
        @foreach($packages as $pack)
        <tr>
            <td> {{$pack->user->name}} </td>
            <td> {{$pack->gym->name}} </td>
            <td> {{$pack->training_package->name}} </td>
            <td> {{$pack->purchase_price}} </td>
            <td>
                <form method="POST" action="{{route('Boughtpackages.destroy',['boughtpackages'=>$pack->id])}}">
                    @csrf
                    @method('delete')
 <button class="btn btn-danger"  
 title="Delete" type="submit" onclick="return confirm('Are You Sure You wanttttttt')">
Delete
</button>
</form>
                </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection
