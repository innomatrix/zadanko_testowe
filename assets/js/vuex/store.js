import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { reject } from 'q';

Vue.use(Vuex);


export default new Vuex.Store({
    strict: true,
    modules: {},
    state: {
        isLoading: false,
        weatherInfo: {},
        errors: []
      },
      mutations: {
        setIsLoading: (state, isLoading) => {
            state.isLoading = isLoading
        },
        setWeatherInfo: (state, weatherInfo) => {
            state.weatherInfo = weatherInfo
        },     
      },
      actions: {
        setIsLoading: ({commit}, isLoading) => {
            commit('setIsLoading', isLoading)
        },
        setWeatherInfo: ({commit}, weatherInfo) => {
            commit('setWeatherInfo', weatherInfo)
        },        
        getWeatherInfo: ({commit, dispatch}, payload) => {
            dispatch('setIsLoading',true)
            return axios.get('/getweather/'+ payload.lat + '/' + payload.lng)
                .then(response => {
                    dispatch('setWeatherInfo',response.data.response)                 
                })
                .catch(error => {
                    console.log(error.response.data)
                    dispatch('setIsLoading',false)
                })            
        }        
      }    
})
