@extends('admin.app')
@section('content')
@if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
    @endif
<h2 class="mb-2 p-2 font-weight-bold">Stats</h2>
      <div class="row p-1 ml-1">
        <div class="card shadow mb-4 col-md-7">
          <div class="card-body">
            <div id="insertFormDiv">
              <form class="form-inline d-flex justify-content-between" method="POST" action="{{ URL::to('analytics/update-stats/'.$stats->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                <input type="date" id="date" name="date" value="{{ $stats->date }}" >
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" value="{{ $stats->user->name }}">
                  <input type="hidden" name="user_id" value="{{ $stats->user_id }}">
                </div>
                <div class="form-group">
                  <input type="text" name="revenue" id="revenue" placeholder="revenue" class="form-control" value="{{ $stats->revenue }}">
                </div>
                  <input type="submit" class="btn btn-sm btn-success">
                </form>
                <br>
            </div>
        </div><!-- end card body -->
      </div><!-- end card -->
      </div>



@endsection