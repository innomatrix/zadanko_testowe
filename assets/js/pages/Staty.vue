<template>
    <div>
        <VueLoading></VueLoading>
        <h1>Druga strona ze statami :)</h1>
        <router-link :to="{ name: 'index'}">Back to INDEX</router-link>
    </div>
</template>

<script>
    import VueLoading from "../components/layout/overlay";
    import VueGeolocation from 'vue-browser-geolocation';
    import {mapState} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        name: "staty",
        components: {VueLoading, VueGeolocation},
        mounted: function() {
            this.$getLocation({
                enableHighAccuracy: true  
            })
            .then(coordinates => {
                console.log(coordinates);
            });
        }
    }
</script>

<style scoped>

</style>