<template>
    <h1>{{ massege }}</h1>
</template>

<script>
export default {
    data(){
        return {
            massege:null
        }
    },
    created(){
        this.massege = "Hellow word from created"
    },
    mounted(){
        this.massege = "Hellow word from mounted"
    },
    methods:{

    },
    watch:{
        
    }
}
</script>
