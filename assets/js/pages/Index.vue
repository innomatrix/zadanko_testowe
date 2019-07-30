<template>
    <div>
        <h1>Hello Mela :)</h1>
        <Gmap></Gmap>
        <Loader></Loader>
    </div>
</template>

<script>
    import Loader from "../components/layout/loader";
    import Gmap from "../components/layout/gmap";
    export default {
        name: "Index",
        components: {Loader, Gmap}
    }
</script>

<style scoped>

</style>