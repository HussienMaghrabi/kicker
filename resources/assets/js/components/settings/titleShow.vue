<template>
    <section class="container titles">
       <b>Show Job Title</b><hr>
       <div class="column first">
           <div class="is-4">
               <b><label>ID: </label></b> {{title.id}}
           </div>
           <hr>
             <div class="is-4">
               <b><label>Name: </label></b>  {{title.name}}
           </div>
           <hr>
       </div>

        <div class="column second">
           <div class="is-6">
               <b><label>Description: </label></b> {{title.description}}
           </div>
           <hr>
       </div>
 
    </section>
</template>
<style>
.titles{
    background: #fff;
    padding-left: 2%;
}
</style>
<script>
import {titleShow} from './../../calls'

export default {
    data() {
        return {
                title: {},
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
                titleShow(this.id).then(response=>{
                    console.log(response)
                this.title = response.data
                this.isLoading = false
            

                })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>