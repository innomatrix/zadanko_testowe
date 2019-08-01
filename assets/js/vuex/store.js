import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);


export default new Vuex.Store({
    strict: true,
    modules: {},
    state: {
        isLoading: false,
        weatherInfo: {},
        userWeatherInfo: {},
        location: {},
        summary: {},
        errors: []
        },
        mutations: {
            setIsLoading: (state, isLoading) => {
                state.isLoading = isLoading
            },
            setWeatherInfo: (state, weatherInfo) => {
                state.weatherInfo = weatherInfo
            },
            setUserWeatherInfo: (state, userWeatherInfo) => {
                state.userWeatherInfo = userWeatherInfo
            },            
            setSummary: (state, summary) => {
                state.summary = summary
            },
            setLocation: (state, location) => {
                state.location = location
            },            
        },
        actions: {
            setIsLoading: ({commit}, isLoading) => {
                commit('setIsLoading', isLoading)
            },
            setWeatherInfo: ({commit}, weatherInfo) => {
                commit('setWeatherInfo', weatherInfo)
            },
            setUserWeatherInfo: ({commit}, userWeatherInfo) => {
                commit('setUserWeatherInfo', userWeatherInfo)
            },            
            setLocation: ({commit}, location) => {
                commit('setLocation', location)
            },             
            getWeatherInfo: ({dispatch}, payload) => {
                dispatch('setIsLoading',true)
                return axios.get('/getweather/'+ payload.lat + '/' + payload.lng + '/' + payload.persist)
                    .then(response => {
                        payload.persist ? dispatch('setWeatherInfo',response.data.response) : dispatch('setUserWeatherInfo',response.data.response)
                        // dispatch('setIsLoading',false)
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        dispatch('setIsLoading',false)
                    })            
            },
            getSummary: ({dispatch}, payload) => {
                dispatch('setIsLoading',true)
                return axios.get('/summary/' + payload.page)
                    .then(response => {
                        // dispatch('setSummary', response.data.response)
                        // dispatch('setIsLoading',false)
                        return response.data.response
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        dispatch('setIsLoading',false)
                    })            
            }
        }    
})
