<template>
    <section class="container tasks">
       <b>Tasks</b><hr>
       <div class="column first">
           <div class="is-4">
               <b><label>Agent: </label></b> {{task.agent_id}}
           </div>
           <hr>
             <div class="is-4">
               <b><label>Date: </label></b> {{task.due_date}}
           </div>
           <hr>
       </div>

        <div class="column second">
           <div class="is-6">
               <b><label>Task Type: </label></b> {{task.task_type}}
           </div>
           <hr>
           <div class="is-6">
               <b><label>Status: </label></b>  {{task.status}}
           </div>
           <hr>
       </div>
 
    </section>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
}
</style>
<script>
import {showtask} from './../../calls'

export default {
    data() {
        return {
                task: {},
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
                showtask(this.id).then(response=>{
                    console.log(response)
                this.task = response.data
                this.isLoading = false
            

                })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>