<template>
    <div>
        <VueLoading></VueLoading>
        <h1>Hello Webmasters :)</h1>
        <router-link :to="{ name: 'staty'}">Switch to STATS</router-link>
        <Gmap></Gmap>
    </div>
</template>

<script>
    import Loader from "../components/layout/loader";
    import VueLoading from "../components/layout/overlay";
    import Gmap from "../components/layout/gmap";
    export default {
        name: "index",
        components: {Loader, Gmap, VueLoading}
    }
</script>

<style scoped>

</style>