<template>
    <div>
        <h2>Hello Webmasters :)</h2>
        <router-link :to="{ name: 'staty'}" class="router-link">Switch to STATS</router-link>
        <Gmap></Gmap>
    </div>
</template>

<script>
    import Gmap from "../components/layout/gmap";
    export default {
        name: "index",
        components: {Gmap}
    }
</script>

<style scoped>

</style>