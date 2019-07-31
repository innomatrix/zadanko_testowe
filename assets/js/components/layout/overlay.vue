<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :on-cancel="onCancel"
        :is-full-page="fullPage"></loading>
    </div>
</template>
 
<script>
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import {mapState} from 'vuex'
    
    export default {
        data() {
            return {
                // isLoading: this.$store.state.isLoading,
                fullPage: true
            }
        }, 
    computed: {
        isLoading: function() { // computed property will be updated when async call resolves
            return this.$store.state.isLoading;
        }
    },
    //   watch: { // watch changes here
    //     isLoading: function(newValue, oldValue) {
    //       // apply your logic here, e.g. invoke your listener function
    //       console.log('was: ', oldValue, ' now: ', newValue)
    //     }
    //   },            
        components: {
            Loading
        },
        methods: {
            onCancel() {
              console.log('User cancelled the loader.')
            }
        }
    }
</script> 