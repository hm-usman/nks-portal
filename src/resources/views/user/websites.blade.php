@extends('user.app')
@section('content')
@if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    @endif
@error('domain')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
@enderror
<div class="row">
  <div class="col-12 col-lg-6">
    <div class="card radius-15">
      <div class="card-body">
        <div class="d-flex flex-column mb-2">
          <div>
            <p class="mb-0 font-weight-bold">Add New Website</p>
          </div>
          <div class="align-self-start mt-2 w-100">
            <form class="" method="POST" action="{{ route('create-domain') }}">
              @csrf
                <div class="input-group">
                  <input type="url" type="url" name="domain" id="domain" placeholder="Enter Website URL Here." class="form-control col-12" required>
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-telegram"></i></button>
                  </div>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card radius-15">
  <div class="card-body">
    <div class="card-title">
      <h5 class="mb-0">Enlisted 
        Websites </h5>
    </div>
    <hr/>
        <div class="table-responsive">
                <table class="table table-borderless table-hover">
                  <thead>
                    <tr>
                      <th>Website</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($websites as $website)
                        <tr>
                            <td>{{ $website->domain}}</td>
                            <td>
                                @if ($website->status == '0')
                                <i class="fa fa-spinner text-secondary pr-1"></i>Pending
                                @else
                                <i class="fa fa-check text-success pr-1"></i>Approved
                                @endif
                              </td>                        
                        </tr>
                    @endforeach
                  </tbody>
                  {{ $websites->links() }}
                </table>
    </div>
  </div>  
</div>

  @endsection