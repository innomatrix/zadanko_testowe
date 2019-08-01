<template>
    <div>
        <h2>Druga strona => ze statami :)</h2>
        <router-link :to="{ name: 'index'}"  class="router-link float-right mr-4">>>>>>>> Back to INDEX</router-link>
        <div id="userLocationData">
            <span id="koordynaty">Twoja lokalizacja: Lat= {{location.lat || 'brak danych'}} log= {{location.lng || 'brak danych'}}</span><br>
            <span v-if="userWeatherInfo.main" id="temperatura">Twoja pogoda: {{ userWeatherInfo.main.temp  || 'brak danych' }}  &#x2103;</span>
            <span v-if="userWeatherInfo.weather" id="zachmurzenie"> - {{ userWeatherInfo.weather[0].main || '' }}</span>

            <div id="tabelka">
                <v-server-table url="/summary" ref="last_requests" :columns="columns" :options="options" @loading="onLoading" @loaded="onLoaded"></v-server-table>
            </div>            
            <span id="avg_temp">Srednia temp: {{ avgTemp }}  &#x2103;</span><br/>
            <span id="min_temp">Min temp: {{ minTemp }}  &#x2103;</span><br/>
            <span id="max_temp">Max temp: {{ maxTemp }}  &#x2103;</span><br/>
            <span id="totalRecords">Liczba rekordow: {{ totalRecords }}</span><br/>
            <span id="mostCommonSearchCity">Najpopularniejsze miasto: {{ mostCommonSearchCity }}</span>

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
                minTemp: '', maxTemp: '', avgTemp: '', totalRecords: '', mostCommonSearchCity: '',
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
                    responseAdapter: function (data) {
                        let last_requests = data.data.response.last_requests;

                        this.$parent.minTemp =  parseFloat(data.data.response.statistic.max_maxtemp);
                        this.$parent.maxTemp =  parseFloat(data.data.response.statistic.max_maxtemp);
                        this.$parent.avgTemp =  (parseFloat(data.data.response.statistic.avg_mintemp) + parseFloat(data.data.response.statistic.avg_maxtemp)) / 2; // srednia z min i max sredniej :D
                        this.$parent.totalRecords = parseInt(data.data.response.statistic.total_items);
                        this.$parent.mostCommonSearchCity =  data.data.response.statistic.city + '(' + data.data.response.statistic.most_used + ')';

                        // w GMaps i naszej funkcji haversine() mamy lon a OW lng :) trzeba zwrocic uwage na ten detal 
                        if(this.$parent.location.lat && this.$parent.location.lng) {
                            let locationFrom = { ['lat'] : this.$parent.location.lat }; // location jest ze STATE(store)
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
            }
        }
    }
</script>

<style scoped>
a.router-link {
    margin-top: -7em;
}
</style>