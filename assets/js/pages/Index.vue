<template>
    <div>
        <VueLoading></VueLoading>
        <h1>Hello Mela :)</h1>
        <Gmap></Gmap>
        <!-- <Loader></Loader> -->
    </div>
</template>

<script>
    import Loader from "../components/layout/loader";
    import VueLoading from "../components/layout/overlay";
    import Gmap from "../components/layout/gmap";
    export default {
        name: "Index",
        components: {Loader, Gmap, VueLoading}
    }
</script>

<style scoped>

</style>