@extends('layouts.gym')
@section('title') Revenue
@endsection
@section('page_content')
<h4 class="mb-2 mt-4">Revenue</h4>
<div class="col-md-3 " >
    <div class="card card-success" style="width: 450px;">
        <div class="card-header">
            <h3 class="card-title">Revenue:</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
        Revenue of GYM equals {{ $revenue }} $
        <br>
        </div>
    </div>
</div>
@endsection
