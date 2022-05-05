@extends('layouts.app')

@section('page_content')
<h4 class="mb-2 mt-4">Total Revenue</h4>
<div class="col-md-3">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Revenue:</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
        Revenue of GYM equals {{ $revenue }} $
        </div>
    </div>
</div>
@endsection
