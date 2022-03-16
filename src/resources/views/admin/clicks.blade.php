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
            <h5 class="mb-0">Filters </h5>
          </div>
          <hr/>
          <form method="GET">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>From:</label>
                        <input type="date" class="form-control" name="from" value="{{$from ? $from : date('Y-m-d')}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>To:</label>
                        <input type="date" class="form-control" name="to" value="{{$to ? $to : date('Y-m-d')}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>User:</label>
                        <select class="form-control my-select" data-live-search="true"  name="user">
                            <option value="">-Select User-</option>
                            @forelse ($users as $item)
                                <optgroup label="{{$item->name}}">
                                  @forelse ($item->websites as $site)
                                    <option data-tokens="{{$item->name}}" value="{{$item->tc.'-dt'.$site->id}}" {{$item->tc.'-dt'.$site->id === $user ? 'selected' : ''}}>{{$site->domain}}</option>  
                                  @empty
                                      
                                  @endforelse
                                  <option data-tokens="{{$item->name}}" value="{{$item->tc}}" {{$item->tc === $user ? 'selected' : ''}}>--Total {{$item->name}}'s Clicks--</option>
                                </optgroup>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Unique:</label>
                        <select class="form-control" name="unique">
                            <option value="">All</option>
                            <option value="1" {{$unique == 1 ? 'selected' : ''}}>Unique</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1 mt-md-2">
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary mt-md-4">Filter</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
<div class="card radius-15">
  <div class="card-body">
    <div class="card-title">
      <h5 class="mb-0">Clicks {{count($clicks)}}</h5>
    </div>
    <hr/>
        <div class="table-responsive">
                <table class="table table-borderless table-hover">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>IP</th>
                      <th>URL</th>
                      <th>TimeStamp</th>
                    </tr>
                  </thead>
                  <tbody>
                      @forelse ($clicks as $click)
                        <tr>
                          <td>{{ $click->client != null ? $click->client->name : '' }}</td>
                          <td>{{ $click->remote_address }}</td>
                          <td>{{ $click->ref }}</td>
                          <td>{{ date('M d, Y, H:s:i',strtotime($click->created_at) ) }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4" align="center">No Clicks</td>
                        </tr>
                      @endforelse                            
                  </tbody>
                </table>
    </div>
  </div>
</div>


@endsection
