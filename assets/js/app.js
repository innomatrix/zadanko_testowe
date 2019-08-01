import Vue from 'vue'
import App from './App.vue'
import store from './vuex/store'
import router from './router/index'
import * as VueGoogleMaps from 'vue2-google-maps'
import axios from 'axios'
import VueLoading from "./components/layout/overlay"
import VueGeolocation from 'vue-browser-geolocation'
import {ServerTable, Event} from 'vue-tables-2';
// import Turf from 'Turf';

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

Vue.mixin({
  methods: {
    toRad: function (value) {
        return value * Math.PI / 180;
    },
    haversine: function(point1, point2) {
        var R = 6371; // earth radius in km
        var dLat = this.toRad(point2.lat-point1.lat);
        var dLon = this.toRad(point2.lon-point1.lon);
        var lat1 = this.toRad(point1.lat);
        var lat2 = this.toRad(point2.lat);

        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + 
                Math.sin(dLon/2) * Math.sin(dLon/2) *
                Math.cos(lat1) * Math.cos(lat2);
        
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        return R * c;
    }
  }
})

Vue.config.productionTip = false;
Vue.prototype.$http = axios;


new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App, VueLoading},
});

