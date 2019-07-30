<template>
    <GmapMap
        ref="mojaMapka"
        :center="{lat:10, lng:10}"
        :zoom="7"
        map-type-id="terrain"
        style="width: 500px; height: 300px"
        @click="dajMnieTenMarker($event.latLng)"
    >
        <GmapMarker 
            v-if="markerPosition !== null"
            ref="mojaMarker"
            :position="markerPosition"
            :clickable="true"
            :draggable="true"
            @click="center=markerPosition"
        />
    </GmapMap>
</template>

<script>
import {gmapApi} from 'vue2-google-maps'
import {GmapMarker} from 'vue2-google-maps/src/components/marker'
export default {
    name: 'Gmap',
    data() {
        return  {
            markerPosition: null
        }
    },
    computed: {
        google: gmapApi
    },
    methods: {

        // https://laracasts.com/discuss/channels/vue/vue-google-maps-and-foreach-statment-on-markers

        dajMnieTenMarker: function(position) {
            this.markerPosition = position;
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

