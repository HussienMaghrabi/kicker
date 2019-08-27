<template>
    <section class="container targets">
       <h3>Show Target</h3><hr>
       <div class="column first">
          <div class="is-4">
               <b><label>Agent Type: </label></b>  {{targets.agentName}}
           </div>
           <hr>
           <div class="is-4">
               <b><label>Month: </label></b> {{targets.month}}
           </div>
           <hr>
       </div>

        <div class="column second">
           <div class="is-6">
               <b><label>Calls: </label></b> {{targets.calls}}
           </div>
           <hr>
             <div class="is-6">
               <b><label>Meetings: </label></b> {{targets.meetings}}
           </div>
           <hr>
       </div>

        <div class="column second">
           <div class="is-6">
               <b><label>Money: </label></b> {{targets.money}}
           </div>
           <hr>
             <div class="is-6">
               <b><label>Notes: </label></b> {{targets.notes}}
           </div>
           <hr>
       </div>
 
    </section>
</template>
<style>
.targets{
    background: #fff;
    padding-left: 2%;
}
</style>
<script>
import {showTarget} from './../../calls'

export default {
    data() {
        return {
                targets: {},
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
                showTarget(this.id).then(response=>{
                    console.log(response)
                this.targets = response.data
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>