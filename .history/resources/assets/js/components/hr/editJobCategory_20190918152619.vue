<template>
    <section class="container jobs">
       <b>Edit Job Category</b><hr>
       <div class="column is-mobile">
           <div class="column is-6">
               <b><label style="display:block">English Name: </label></b>
               <b-input type="text" v-model="JobCategory.en_name"></b-input>
           </div>

        <div class="column is-6">
            <b><label style="display:block">Arabic Name: </label></b>
            <b-input type="text" v-model="JobCategory.ar_name"></b-input>
        </div>

       </div>

        <div class="column is-mobile">
           <div class="column is-6">
                <b-field label="English Description:">
                    <b-input type="textarea" v-model="JobCategory.en_description"></b-input>
                </b-field>  
           </div>

            <div class="column is-6">
                <b-field label="Arabic Description:">
                        <b-input type="textarea" v-model="JobCategory.ar_description"></b-input>
                </b-field>      
            </div>
       </div>

         <b-button @click="updateForm" type="is-success" icon-right="pen"> Edit </b-button>
    
 
    </section>
</template>
<style>
.jobs{
    background: #fff;
    padding-left: 2%;
    padding-bottom: 1%;
}
</style>
<script>
import {updateJobCategory,getJobCategories} from './../../calls'
export default {
    data() {
            return {
                JobCategory:[],
                token: window.auth_user.csrf
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
                getJobCategories(this.id).then(response=>{
                    console.log(response)
                    this.JobCategory = response.data
                    console.log('job category response',this.JobCategory)
                    this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
      updateForm(id){
                const bodyFormData = new FormData();
                for (let key in this.JobCategory) {
                    const value = this.JobCategory[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('_method','put')
                updateJobCategory(bodyFormData,this.id).then(response=>{
                    console.log(response)
                  $(location).attr('href', '/admin/vue/jobCategories')
                }).catch(error=>{
                    console.log(error)
                })
      }

    },
}
</script>
