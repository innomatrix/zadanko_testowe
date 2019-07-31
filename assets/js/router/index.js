import Vue from 'vue'
import Router from 'vue-router'
import * as VueGoogleMaps from 'vue2-google-maps'
import Index from '../pages/Index';
import Staty from '../pages/Staty';
import VueGeolocation from 'vue-browser-geolocation';


Vue.use(Router);
Vue.use(VueGoogleMaps, {load: {key: 'AIzaSyCmcW96oFTb8y_FEdbigtO8ndFAb86Ps4c'}});
Vue.use(VueGeolocation);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index
        },
        {
            path: '/staty',
            name: 'staty',
            component: Staty
        }        
    ]

})
