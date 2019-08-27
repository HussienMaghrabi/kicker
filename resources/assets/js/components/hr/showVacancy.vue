<template>
    <section class="container Vacancy">
       <b>Vacancy</b><hr>
       <div class="column is-12">
           <div class="is-4">
               <b><label>English Name: </label></b> {{vacancy.en_name}}
           </div>
           <hr>
             <div class="is-4">
               <b><label>Arabic Name: </label></b>  {{vacancy.ar_name}}
           </div>
           <hr>
       </div>

        <div class="column is-12">
           <div class="is-6">
               <b><label>English Description: </label></b>  {{vacancy.en_description}}
           </div>
           <hr>
           <div class="is-6">
               <b><label>Arabic Description: </label></b>  {{vacancy.ar_description}}
           </div>
           <hr>
       </div>

        <div class="column is-12">
           <div class="is-3">
               <b><label>Job Title: </label></b>  {{jobTitle}}
           </div>
           <hr>
           <div class="is-3">
               <b><label>Status: </label></b>  {{vacancy.status}}
           </div>
           <hr>
            <div class="is-3">
               <b><label>Type: </label></b>  {{vacancy.type}}
           </div>
       </div>
 
    </section>
</template>
<style>
.Vacancy{
    background: #fff;
    padding-left: 2%;
    padding-bottom: 1%;
}
</style>
<script>
import {showVacancy} from './../../calls'

export default {
    data() {
        return {
                vacancy: {},
                id: null,
                isLoading: true,
                jobTitle: ''
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
                showVacancy(this.id).then(response=>{
                    console.log(response)
                this.vacancy = response.data.vacancy
                this.jobTitle = response.data.JobTitle
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>
