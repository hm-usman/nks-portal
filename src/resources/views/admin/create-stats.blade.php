@extends('admin.app')
@section('content')
@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="card radius-15">
    <div class="card-body">
      <div class="card-title">
        <h5 class="mb-0">
          <form action="/admin/create-stats" method="GET">
            <label for="Stats Date">Insert Stats for :</label>
            <input type="date" id="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
        </form>
        </h5>
      </div>
      <hr/>
        <form method="POST" action="/admin/create-stats">
        @csrf
        <input type="hidden" value="{{$date}}" name="date">
        <div class="row mb-2">
            @foreach ($data as $user)
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" value="{{$user['revenue']}}" placeholder="Enter Revenue" name="revenue[]">
                        <div class="input-group-append">
                          <span class="input-group-text">{{$user['name']}}</span>
                        </div>
                        <input type="hidden" value="{{$user['id']}}" name="user[]">
                      </div>
                </div>
                @endforeach
            </div>
        <button type="submit" class="btn btn-primary my-3">Insert</button>
        </form>
    </div><!-- end card body -->
</div><!-- end card -->

@endsection
