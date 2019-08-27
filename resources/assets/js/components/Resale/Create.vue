<template>
    <div>
        <createUnitSection/>
    </div>
</template>

<script>
    // import 'bootstrap/dist/css/bootstrap.css'
    // import 'bootstrap-vue/dist/bootstrap-vue.css'
    import createUnitSection from "./createUnitSection";
    import {
        getUnitTypes,
        getPublicData,
        storeUnitResale,
        getAllLeads,
        getAgents,
        getLeadSources,
        leadShortAdding,
        getDistruct,
        getAllLeadsAutocompleteList,
    } from './../../calls'
    import MugenScroll from 'vue-mugen-scroll'
    export default {
        name: 'demo',
        data() {
            return {
                
            }
        },
        components: {
            createUnitSection
        },
        created() {
        },
        mounted() {
        },
        computed: {
        },
    };
</script>
