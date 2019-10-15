<template>
    <div>
    <section>
        <b-button @click="clickMe">Click Me</b-button>
    </section>
    </div>
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

    },
    methods:{
        clickMe(){
            alert('123')
        }
    },
    watch:{
        
    }
}
</script>
