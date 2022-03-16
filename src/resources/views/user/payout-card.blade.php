@if($revenueTillDate != 0)
<div class="card shadow mb-3 col-md-3">
    <div class="card-body d-flex flex-column">
      <p class="mt-0">Revenue from <small>{{ $revenueTillDate['revenueFrom'] }}</small></p>
      <h2 class="font-weight-bold mt-0">${{ $revenueTillDate['revenue'] }}</h2>
      <button 
              class="mt-auto btn btn-sm theme-btn" 
              href="#" 
              data-toggle="modal" 
              data-target="#payoutModal">
              Request Payout
      </button>
    
    

      <div class="modal fade" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="POST" action="{{ route('request-payout') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proceed to Payout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                
                <div class="modal-body">
                  @if ($revenueTillDate['revenue'] > '10')
                  <p>Select "Proceed" below if you want to Cash your <b>{{ $revenueTillDate['revenue'] }}</b></p>
                  @endif
                  <p class="text-danger">Minimum Payout For Bank is <strong>$10</strong> and Payoneer is <strong>$50</strong></p>
                    <input type="hidden" name="paymentFrom" value="{{ $revenueTillDate['revenueFrom'] }}">
                    <input type="hidden" name="paymentTill" value="{{ $revenueTillDate['revenueTill'] }}">
                    <input type="hidden" name="totalRevenue" value="{{ $revenueTillDate['revenue'] }}">
                    @if ($revenueTillDate['revenue'] > '10')
                    <div class="form-group">
                      <select class="form-control" required name="payoutMethod">
                          @if ($revenueTillDate['revenue'] >= '50')
                              <option value="">Select Payout Method</option>
                              <option value="Bank">Bank Deposit</option>
                              <option value="Payoneer">Payoneer</option>                                    
                          @endif

                          @if ($revenueTillDate['revenue'] >= '10' &&  $revenueTillDate['revenue'] < '50')
                              <option value="">Select Payout Method</option>
                              <option value="Bank">Bank Deposit</option>                                    
                          @endif

                       </select>
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" name="methodDetails" required cols="4" placeholder="Enter Your Account Details"></textarea>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                @if ($revenueTillDate['revenue'] > '10')
                    <button class="btn btn-info text-white" type="submit">Proceed</button>
                @endif
                </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>
@endif