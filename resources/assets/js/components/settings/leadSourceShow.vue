<template>
    <section class="container leads">
       <h3>Show a Lead Source</h3><hr>
       <div class="column first">
             <div class="is-4">
               <b><label>Name: </label></b> {{ leadSource.name}}
             </div>
           <hr>
       </div>

        <div class="column second">
           <div class="is-6">
               <b><label>Description: </label></b>{{ leadSource.description}}
           </div>
           <hr>
       </div>
 
    </section>
</template>
<style>
.leads{
    background: #fff;
    padding-left: 2%;
}
</style>
<script>
import {showLeadSource} from './../../calls'

export default {
    data() {
        return {
                leadSource: {},
                id: null,
                isLoading: true,
            }},
    mounted() {
        this.getData()
    },
    created() {
        this.id = this.$route.params.id
    },
    methods: {
      getData(){
            this.isLoading = true
                showLeadSource(this.id).then(response=>{
                    console.log(response)
                this.leadSource = response.data
                this.isLoading = false
         })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>