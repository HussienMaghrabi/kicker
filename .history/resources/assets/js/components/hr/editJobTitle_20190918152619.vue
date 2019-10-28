<template>
    <section class="container jobs">
       <b>EDit Job Title</b><hr>
       <div class="column is-mobile">
           <div class="column is-12">
               <b><label style="display:block">English Name: </label></b>
               <b-input type="text" v-model="JobTitle.en_name"></b-input>
           </div>

        <div class="column is-12">
            <b><label style="display:block">Arabic Name: </label></b>
            <b-input type="text" v-model="JobTitle.ar_name"></b-input>
        </div>

       </div>

        <div class="column is-mobile">
           <div class="column is-12">
                <b-field label="English Description:">
                    <b-input type="textarea" v-model="JobTitle.en_description"></b-input>
                </b-field>  
           </div>

            <div class="column is-12">
                <b-field label="Arabic Description:">
                        <b-input type="textarea" v-model="JobTitle.ar_description"></b-input>
                </b-field>      
            </div>
       </div>


       <b-field label="department">
            <b-select expanded v-model="JobTitle.job_category_id">
                 <option v-for="department in departments" :value="department.id" :key="department.id" >
                        {{ department.en_name }} 
                 </option>
            </b-select>
        </b-field> 

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
import {updateJobTitle,getJobTitles,getJobTitleInputs} from './../../calls'
export default {
    data() {
            return {
                departments:[],
                JobTitle:[],
                token: window.auth_user.csrf
            }},
    mounted() {
        this.getData()
        this.getDataOfDepartments()
      },
    created() {
            this.id = this.$route.params.id
        },
 methods: {
      getDataOfDepartments(){
            this.isLoading = true
            getJobTitleInputs().then(response=>{
                console.log("depatments",response)
                this.departments = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
     getData(){
            this.isLoading = true
                getJobTitles(this.id).then(response=>{
                    console.log(response)
                    this.JobTitle = response.data
                    console.log('job title response',this.JobTitle)
                    this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
      updateForm(id){
                const bodyFormData = new FormData();
                for (let key in this.JobTitle) {
                    const value = this.JobTitle[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('_method','put')
                updateJobTitle(bodyFormData,this.id).then(response=>{
                    console.log(response)
                  $(location).attr('href', '/admin/vue/jobTitle')
                }).catch(error=>{
                    console.log(error)
                })
      }

    },
}
</script>
