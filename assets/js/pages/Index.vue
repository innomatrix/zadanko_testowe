<template>
    <div>
        <h2>Hello Webmakers :)</h2>
        <router-link :to="{ name: 'staty'}" class="router-link float-right mr-4">>>>>>>> Switch to STATS</router-link>
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
a.router-link {
    margin-top: -7em;
}
</style>