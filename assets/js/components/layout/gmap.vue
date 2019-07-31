<template>
    <GmapMap
        ref="mojaMapka"
        :center="{lat:10, lng:10}"
        :zoom="7"
        map-type-id="terrain"
        style="width: 500px; height: 300px"

        @click="dajMnieTenMarker($event)">


        <GmapInfoWindow 
            v-if="markerPosition !== null"
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
//        v-on:bounds_changed="setIsLoading(false)"

            // :opened="infoWinOpen"
            // @closeclick="infoWinOpen=false"

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
            window_open: false
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
            // this.getWeatherInfo({'lat': marker.latLng.lat(), 'lng': marker.latLng.lng()})
            // this.wyswietlMnieToPogodoweInfo();
        },
        wyswietlMnieToPogodoweInfo: function() {
            // console.log(this.weatherInfo);
            this.window_open = true;
            this.setIsLoading(false);
        }
        // toggleInfoWindow: function(marker, idx) {

            // this.infoWindowPos = marker.position;
            // this.infoContent = marker.infoText;

            // //check if its the same marker that was selected if yes toggle
            // if (this.currentMidx == idx) {
            //     this.infoWinOpen = !this.infoWinOpen;
            // }
            // //if different marker set infowindow to open and reset current marker index
            // else {
            //     this.infoWinOpen = true;
            //     this.currentMidx = idx;
            // }
        // }
    },    
}
</script>

