<template>
    <div>
        <vue-loading></vue-loading>
        <h1>Zadanko testowe...<span id="spinnerContainer"><Loader></Loader></span></h1>
        <router-view/>
    </div>
</template>

<script>
    import Loader from "./components/layout/loader"

    export default {
        name: 'app',
        components: {Loader}
    }
</script>

<style lang="scss">
#spinnerContainer {
    overflow: hidden;
    height: 46px;
    width: 100px;
    position: relative;
    display: inline-block;
}
.spinner {
    position: absolute;
    top: -89px;
    left: 34px;
    background-color: #fff !important;
}
</style>
