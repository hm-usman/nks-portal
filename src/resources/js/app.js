require('./bootstrap');

import Vue from 'vue';

Vue.component('messenger', require('./components/Messanger.vue').default);
Vue.component('navbar-messenger', require('./components/NavBarMessenger.vue').default);

const app = new Vue({
    el: '#app',
      
});

