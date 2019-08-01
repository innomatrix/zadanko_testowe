import Vue from 'vue'
import Router from 'vue-router'

import Index from '../pages/Index';
import Staty from '../pages/Staty';

Vue.use(Router);

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
        },
        {
            path: '*',
            name: 'all',
            component: Index
        }          
    ]

})
