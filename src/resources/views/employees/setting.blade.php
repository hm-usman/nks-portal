@extends('layouts.app')
@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

    <div class="card radius-15 col-md-6">
        <div class="card-body">
            <div class="card-title">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <hr/>
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf 
   
                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 
  
                        <div class="form-group">
                            <label for="password" class="control-label">Current Password</label>
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                        </div>
  
                        <div class="form-group">
                            <label for="password" class="control-label">New Password</label>
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                        </div>
  
                        <div class="form-group">
                            <label for="password" class="control-label">Confirm New Password</label>
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                        </div>
   
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                        </div>
                    </form>
        </div><!-- end card body -->
    </div><!-- end card -->

@endsection