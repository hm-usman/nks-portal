import Vue from 'vue';

Vue.component('payout-form', require('./components/PayoutForm.vue').default);
Vue.component('ad-code', require('./components/Adcode.vue').default);

let app = new Vue({
    el: '#app',

});