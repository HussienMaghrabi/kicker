<template>
    <div>
    <section>
        <b-field>
            <b-input  v-model="TESTINPUT" placeholder="No label"></b-input>
        </b-field>
        <b-button @click="clickMe">Click Me</b-button>
    </section>
    </div>
</template>

<script>
import {
    Testagajx
} from './../calls.js'
export default {
    data(){
        return {
            massege:null,
            first:null,
            last:null,
            TESTINPUT:null
        }
    },
    created(){
        // this.massege = "Hellow word from created"
    },
    mounted(){

    },
    methods:{
        clickMe(){
            const data = {
                'input_val':this.TESTINPUT
            }
            Testagajx(data).then(response=>{
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
            // alert(this.massege)
        }
    },
    watch:{
        
    }
}
</script>
