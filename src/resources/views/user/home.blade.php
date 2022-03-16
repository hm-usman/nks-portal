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
      <div class="row">
        <div class="col-12 col-lg-6">
          <div class="card radius-15">
            <div class="card-body">
              <div class="d-sm-flex mb-2">
                <div>
                  <p class="mb-0 font-weight-bold">Revenue</p>
                  <h2 class="mb-0">${{ $revenueTillDate['revenue'] }}</h2>
                </div>
                <div class="ml-auto align-self-end">
                  <p class="mb-0 font-14 text-primary">
                     <span>Revenue From {{ date('M d, Y',strtotime($revenueTillDate['revenueFrom']) ) }}</span>
                  </p>
                </div>
              </div>
              <div id="chart1">

                <button 
                    class="mt-auto btn btn-sm btn-outline-primary" 
                    href="#" 
                    data-toggle="modal" 
                    data-target="#payoutModal">
                    Request Payout
                </button>
                
                <payout-form 
                            csrf="{{csrf_token()}}"
                            revenue="{{$revenueTillDate['revenue']}}"
                            revenue-from="{{$revenueTillDate['revenueFrom']}}"            
                            {{-- revenue-till="{{date('Y-m-d', strtotime($revenueTillDate['revenueTill']. ' -1 day'))}}"             --}}
                            revenue-till="{{$revenueTillDate['revenueTill']}}"            
                            payment-methods="{{$paymentMethod != null ? $paymentMethod : '-'}}"
                            roterp="{{ route('request-payout') }}"            
                            rotecr="{{ route('calculate-revenue') }}"            
                ></payout-form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-3">
          <div class="card radius-15">
            <div class="card-body">
              <div class="d-flex mb-2">
                <div>
                  <p class="mb-0 font-weight-bold">Websites</p>
                  <h2 class="mb-0">{{count($domains)}}</h2>
                </div>
                <div class="ml-auto align-self-end">
                </div>
              </div>
              <div id="chart2"></div>
            </div>
          </div>
        </div>
      </div>
          <div class="card radius-15">
            <div class="card-body">
              <div class="card-title">
								<h5 class="mb-0">Stats </h5>
							</div>
							<hr/>
                  <div class="table-responsive">
                          <table class="table table-borderless table-hover">
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Revenue</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($stats as $stat)
                                <tr>
                                  <td>{{ date('M d, Y',strtotime($stat->date) ) }}</td>
                                  <td>${{ $stat->revenue }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                            {{ $stats->links() }}
                          </table>
              </div>
            </div>
      </div>
@endsection
