// ./assets/vue/index.js
import Vue from 'vue';
import VueRouter from 'vue-router';
  
// app specific
import router from './router/';
import app from './App';
  
Vue.use(VueRouter);
  
// bootstrap the app
let zadanko = new Vue({
    el: '#app',
    router,
    template: '<app/>',
    components: { app }
})