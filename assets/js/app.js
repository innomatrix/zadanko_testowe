import Vue from 'vue'
import App from './App.vue'
import store from './vuex/store'
import router from './router/index'
import * as VueGoogleMaps from 'vue2-google-maps'
import axios from 'axios'
import VueLoading from "./components/layout/overlay"
import VueGeolocation from 'vue-browser-geolocation'
import {ServerTable, Event} from 'vue-tables-2';

require('./app.scss');

Vue.use(VueGoogleMaps, {load: {key: 'AIzaSyCmcW96oFTb8y_FEdbigtO8ndFAb86Ps4c'}})
Vue.use(VueGeolocation)
Vue.use(VueLoading, {
    color: '#000',
    opacity: 0.9,
    backgroundColor: '#fff',
    loader: 'dots'
},{
    color: '#000',
    opacity: 0.7,
    backgroundColor: '#fff',
    loader: 'dots'
})
Vue.component('vue-loading', VueLoading)

Vue.use(ServerTable);

Vue.config.productionTip = false;
Vue.prototype.$http = axios;


new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App, VueLoading},
});

