<template>
    <GmapMap
        ref="mojaMapka"
        :center="{lat:10, lng:10}"
        :zoom="7"
        map-type-id="terrain"
        style="width: 500px; height: 300px"
        @click="dajMnieTenMarker($event)">

        <GmapInfoWindow 
            v-if="weatherInfo !== undefined"
            :opened="info_open"
            ref="mojeInfo"
            :options="{pixelOffset: {width: 0,height: -35}}" 
            :position="markerPosition"
            :zIndex="99999999999">

                {{ this.weatherInfo }}
        </GmapInfoWindow>

        <GmapMarker 
            v-if="markerPosition !== null"
            ref="mojMarker"
            :position="markerPosition"
            :clickable="true"
            :draggable="true"
            @click="center=markerPosition"
        />
    </GmapMap>
</template>

<script>
// import {gmapApi} from 'vue2-google-maps'
// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
// import {GmapInfoWindow} from 'vue2-google-maps/src/components/infoWindow'
import {mapState} from 'vuex'
import {mapActions} from 'vuex'

export default {
    name: 'Gmap',
    data() {
        return  {
            markerPosition: null,
            info_open: false
        }
    },
    computed: {...mapState(['isLoading', 'weatherInfo'])},
    methods: {
        // https://laracasts.com/discuss/channels/vue/vue-google-maps-and-foreach-statment-on-markers
        ...mapActions([
            'setIsLoading', 
            'getWeatherInfo' 
        ]), 
        dajMnieTenMarker: function(marker) {
            this.setIsLoading(true);
            this.markerPosition = marker.latLng;
            this.getWeatherInfo({'lat': marker.latLng.lat(), 'lng': marker.latLng.lng()}).then(() => {
                this.wyswietlMnieToPogodoweInfo();
            })
        },
        wyswietlMnieToPogodoweInfo: function() {
            this.info_open = true;
            this.setIsLoading(false);
        }
    },    
}
</script>

