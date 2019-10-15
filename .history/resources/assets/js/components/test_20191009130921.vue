<template>
    <h1>{{ massege }}</h1>
    <h1>{{ first }}</h1>
    <h1>{{ last }}</h1>
</template>

<script>
export default {
    data(){
        return {
            massege:null,
            first:null,
            last:null,
        }
    },
    created(){
        // this.massege = "Hellow word from created"
    },
    mounted(){
        this.massege = "Hellow word from mounted"
        this.first = "first"
        this.last = "last"
    },
    methods:{

    },
    watch:{
        
    }
}
</script>
