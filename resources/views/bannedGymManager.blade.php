<div class="card-body">

@if (session('message'))
     <div class="alert alert-danger">{{ session('message') }}</div>
@endif

</div>