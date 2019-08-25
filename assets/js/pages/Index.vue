<template>
    <div>
        <router-link :to="{ name: 'staty'}" class="router-link float-right mr-4"></router-link>
        <h2>Hello Webmakers :)</h2>
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
@media screen and (min-width: 731px) {
a.router-link:before {
    position: absolute;
    top: 2em;
    right: 2em;
    content: '>>>>>>> Switch to STATS';
}
}
@media screen and (max-width: 730px) {
    a.router-link:before {
        content: '\f080';
        top: 1em;
        right: 0.5em;
        color: white;       
        font-family: FontAwesome;               
    }
}
</style>