<template>
    <div>
        <h2>Druga strona => ze statami :)</h2>
        <router-link :to="{ name: 'index'}"  class="router-link">Back to INDEX</router-link>
        <div id="userLocationData">
            <span id="koordynaty">Twoja lokalizacja: Lat= {{location.lat || 'brak danych'}} Lng= {{location.lng || 'brak danych'}}</span><br>
            <span v-if="userWeatherInfo.main" id="temperatura">Twoja pogoda: {{ userWeatherInfo.main.temp  || 'brak danych' }}  &#x2103;</span>
            <span v-if="userWeatherInfo.weather" id="zachmurzenie"> - {{ userWeatherInfo.weather[0].main || '' }}</span>

            <div id="people">
            <v-server-table url="/summary" :columns="columns" :options="options" @loading="onLoading" @loaded="onLoaded"></v-server-table>
            </div>            

        </div>
    </div>
</template>

<script> 
    import VueGeolocation from 'vue-browser-geolocation'
    import {mapState} from 'vuex'
    import {mapActions} from 'vuex'
    import axios from 'axios'
    import {ServerTable, Event} from 'vue-tables-2';
   

    export default {
        name: "staty",
        components: {VueGeolocation, ServerTable},
        data() { 
            return{
                
                columns: ['city', 'country', 'curtemp', 'time'],
                options: {
                    headings: {
                        city: 'Miasto',
                        country: 'Panstwo',
                        curtemp: 'Temp (Celcius)',
                        time: 'Timestamp'
                    },
                    sortable: [],
                    filterable: [],
                    requestFunction: function (data) {
                        return axios.get(this.url + '/' + data.page + '/' + data.limit).catch(function (e) {
                            this.dispatch('error', e);
                        }.bind(this));
                    },
                    // requestKeys: {page:'p'}, 
                    responseAdapter: function (data) {
                        return {"data":data.data.response.last_requests, count: data.data.response.statistic.total_items};
                    },
                }
            }
        },
        mounted: function() {
            this.setIsLoading(true);
            this.$getLocation({
                enableHighAccuracy: true  
            })
            .then(coordinates => {
                this.setLocation(coordinates);
                this.getWeatherInfo({'lat': coordinates.lat, 'lng': coordinates.lng, 'persist': 0}).then((response) => {
                    this.setIsLoading(false);
                })
            }).catch(error => {
                console.log('brak pozycji... :(');
                this.setIsLoading(false);
            }); 
            // this.getSummary({'page':1}).then((response) => {
            //     console.log(response);
            // })
        },
        computed: {...mapState(['userWeatherInfo','location','summary'])},        
        methods: {
            ...mapActions([
                'setIsLoading',
                'setLocation',
                'getWeatherInfo',
                'getSummary'
            ]),
            onLoaded: function() {
                this.setIsLoading(false);
            },
            onLoading: function() {
                this.setIsLoading(true);
            },            
        }
    }
</script>

<style scoped>
</style>