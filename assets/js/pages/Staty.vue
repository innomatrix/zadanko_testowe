<template>
    <div>
        <h2>Druga strona => ze statami :)</h2>
        <router-link :to="{ name: 'index'}"  class="router-link">Back to INDEX</router-link>
        <div id="userLocationData">
            <span id="koordynaty">Twoja lokalizacja: Lat= {{location.lat || 'brak danych'}} log= {{location.lng || 'brak danych'}}</span><br>
            <span v-if="userWeatherInfo.main" id="temperatura">Twoja pogoda: {{ userWeatherInfo.main.temp  || 'brak danych' }}  &#x2103;</span>
            <span v-if="userWeatherInfo.weather" id="zachmurzenie"> - {{ userWeatherInfo.weather[0].main || '' }}</span>

            <div id="people">
            <v-server-table url="/summary" ref="last_requests" :columns="columns" :options="options" @loading="onLoading" @loaded="onLoaded"></v-server-table>
            </div>            

        </div>
    </div>
</template>

<script> 
    import VueGeolocation from 'vue-browser-geolocation'
    import {mapState} from 'vuex'
    import {mapActions} from 'vuex'
    import axios from 'axios'
    import {ServerTable, Event} from 'vue-tables-2'

    export default {
        name: "staty",
        components: {VueGeolocation, ServerTable},
        data() { 
            return{
                
                columns: ['city', 'country', 'curtemp', 'description','time', 'distance'],
                options: {
                    headings: {
                        city: 'Miasto',
                        country: 'Panstwo',
                        curtemp: 'Temp (Celcius)',
                        description: 'Pogoda ogolnie',
                        time: 'Timestamp',
                        distance: 'dystans od/do Ciebie (km)'
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
                        let last_requests = data.data.response.last_requests;
                        if(this.$parent.location.lat && this.$parent.location.lng) {                    // w Gmaps i naszej funkcji haversine() mamy lon a OW lng :) trzeba zwrocic uwage na ten detal 
                            let locationFrom = { ['lat'] : this.$parent.location.lat };
                            locationFrom['lon'] = this.$parent.location.lng;
                            
                            for (let entry of last_requests) {
                                let locationTo = { ['lat'] : entry.lat };
                                locationTo['lon'] = entry.log;

                                entry['distance'] = parseFloat(this.$parent.haversine(locationFrom, locationTo)).toFixed(2);
                            }
                            // last_requests.forEach((v, i) => last_requests[i]['distance'] = this.$parent.haversine({v.lat,v.log}, {lat, log}));

                        } else
                            console.log('Gdzie ta lokacja:')
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
                    this.$refs.last_requests.refresh()
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
            // calcDistances: function() {
            //             if(this.$parent.location.lat && this.$parent.location.lng) {                    // w Gmaps i naszej funkcji haversine() mamy lon a OW lng :) trzeba zwrocic uwage na ten detal 
            //                 let locationFrom = { ['lat'] : this.$parent.location.lat };
            //                 locationFrom['lon'] = this.$parent.location.lng;
                            
            //                 for (let entry of last_requests) {
            //                     let locationTo = { ['lat'] : entry.lat };
            //                     locationTo['lon'] = entry.log;

            //                     entry['distance'] = this.$parent.haversine(locationFrom, locationTo);
            //                 }
            //                 // last_requests.forEach((v, i) => last_requests[i]['distance'] = this.$parent.haversine({v.lat,v.log}, {lat, log}));

            //             } else
            //                 console.log('Gdzie ta lokacja:')                
            // }
        }
    }
</script>

<style scoped>
</style>