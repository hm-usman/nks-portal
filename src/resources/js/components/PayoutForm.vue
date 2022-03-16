<template>
<section>
    <div class="modal fade" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form>
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proceed to Payout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
    <div class="modal-body">
                  <p>Select "Proceed" below if you want to Cash your <b>{{ calculated_revenue }}</b></p>
                  <p class="text-danger">Minimum Payout For Bank is <strong>$10</strong> and Payoneer is <strong>$50</strong></p>
                  <div class="row">
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label>Revenue From</label>
                            <input type="date" :min="this.revenueFrom" :max="this.revenueFrom" class="form-control" name="paymentFrom" v-model="date_from" @change="calculate_revenue()">
                          </div>
                      </div>
                      <div class="col-12 col-lg-6">
                          <div class="form-group">
                            <label>Revenue Till</label>
                            <input type="date" :min="this.revenueFrom" :max="this.revenueTill" class="form-control" name="paymentTill" v-model="date_to" @change="calculate_revenue()">
                          </div>
                      </div>
                  </div>
                    <div class="form-group">
                        <label>Revenue</label>
                        <input type="text" class="form-control" readonly name="totalRevenue" v-model="calculated_revenue">
                    </div>

                    <div class="form-group" v-if="this.paymentMethods != '-'" >
                        <label>Payout Method</label>
                        <select class="form-control" required name="payoutMethod" v-model="payout_method" @change="payout_method_changed()">
                                <option value="">Select Payout Method</option>
                                <option value="paypal" v-if="JSON.parse(this.paymentMethods).paypal && this.revenue >= 10">Paypal</option>
                                <option value="payoneer" v-if="JSON.parse(this.paymentMethods).payoneer && this.revenue >= 50">Payoneer</option>
                                <option value="bank" v-if="JSON.parse(this.paymentMethods).bank && this.revenue >= 10">Bank Deposit [PK only]</option>                                 -->
                        </select>
                        <textarea class="form-control mt-2"  v-model="method_details" name="methodDetails" readonly rows="4" placeholder="Enter Your Account Details"></textarea>
                    </div>
                    <div class="form-group" v-else>
                        <a href="/analytics/payments"><i class="fa fa-link"></i> Please Add Payment Method</a>
                    </div>
                </div>
                
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" id="submit_btn" v-if="this.paymentMethods != '-' && method_details != ''" type="button" @click="request_payout()">Proceed</button>
                    </div>
                </div>
          </form>
        </div>
    </div>
                </section>
</template>

<script>
import axios from 'axios'
export default {
 props: ['revenue', 'revenueFrom', 'revenueTill', 'paymentMethods', 'csrf', 'rotecr' , 'roterp'],
 data() {
     return {
         'date_from': this.revenueFrom,
         'date_to': this.revenueTill,
         'payout_method' : '',
         'method_details': '',
         'calculated_revenue': this.revenue,
     }
 },
 methods: {
     payout_method_changed(){
         if(this.payout_method === 'paypal'){
             this.method_details = JSON.parse(this.paymentMethods).paypal
         }
         if(this.payout_method === 'payoneer'){
             this.method_details = JSON.parse(this.paymentMethods).payoneer
         }
         if(this.payout_method === 'bank'){
             this.method_details = JSON.parse(this.paymentMethods).bank_details
         }
     },
     calculate_revenue(){
         axios
            .post(this.rotecr, {'from': this.date_from, 'to': this.date_to, '_token': this.csrf} )
            .then(res => this.calculated_revenue = res.data)
            .catch(err => alert(err))
     },
     request_payout(){
         
         document.getElementById('submit_btn').classList.add('d-none')
         
         let formData = new FormData()
         
         formData.append('from', this.date_from)
         formData.append('to', this.date_to)
         formData.append('totalRevenue', this.calculated_revenue)
         formData.append('payoutMethod', this.payout_method)
         formData.append('methodDetails', this.method_details)
         formData.append('_token', this.csrf)
         
         axios
            .post(this.roterp, formData )
            .then(res => {
                    alert(res.data)
                    window.location.reload()
                })
            .catch(err => {
                    alert(err)
                    document.getElementById('submit_btn').classList.remove('d-none')
                })
     },
 },
}
</script>
