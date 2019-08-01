<template>
    <GmapMap
        ref="mojaMapka"
        :center="{lat:50.174, lng:18.915}"
        :zoom="14"
        map-type-id="terrain"
        style="width: 500px; height: 300px; color: black;"
        @click="dajMnieTenMarker($event)">

        <GmapInfoWindow 
            v-if="weatherInfo.name"
            :opened="info_open"
            ref="mojeInfo"
            :options="{pixelOffset: {width: 0,height: -35}}" 
            :position="markerPosition"
            :zIndex="99999999999"
        >
            <b>{{ this.weatherInfo.name }}, {{ this.weatherInfo.sys.country }}</b><br/>
            Temp: {{ this.weatherInfo.main.temp }} &#x2103;<br/>
            Pogoda: {{ this.weatherInfo.weather[0].description }}
        </GmapInfoWindow>

        <GmapMarker 
            v-if="markerPosition"
            ref="mojMarker"
            :position="markerPosition"
            :clickable="true"
            :draggable="true"
            @click="center=markerPosition"
        />
    </GmapMap>
</template>

<script>
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
    computed: {...mapState(['weatherInfo'])},
    methods: {
        ...mapActions([
            'setIsLoading', 
            'getWeatherInfo' 
        ]), 
        dajMnieTenMarker: function(marker) {
            this.setIsLoading(true);
            this.markerPosition = marker.latLng;
            this.getWeatherInfo({'lat': marker.latLng.lat(), 'lng': marker.latLng.lng(), 'persist': 1}).then(() => {
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

