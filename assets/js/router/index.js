import Vue from 'vue'
import Router from 'vue-router'
import * as VueGoogleMaps from 'vue2-google-maps'
import Index from '../pages/Index';

Vue.use(Router);
Vue.use(VueGoogleMaps, {load: {key: 'AIzaSyCmcW96oFTb8y_FEdbigtO8ndFAb86Ps4c'}});

export default new Router({
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Index
        }
    ]

})
