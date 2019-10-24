<template>
    <section class="container apps">
       <b>Applications</b><hr>
       <div class="columns is-12">
        
           <div class="column is-6">
                <b-field label="Department">
                    <select class="selectOption" v-model="job_category" expanded v-on:change="getjobtitles($event.target.value)">
                        <option v-for="department in departments" :key="department.id" :value="department.id">
                            {{ department.en_name }}
                        </option>
                   </select>
                </b-field> 
           </div>

           <div class="column is-6">
                <b-field label="Job Title">
                   <select class="selectOption" placeholder="Choose Options" expanded v-model="job_titles" v-on:change="getVacancies($event.target.value)" :active.sync="title">
                        <option v-for="jobTitle in jobTitles" :value="jobTitle.id">
                            {{ jobTitle.en_name }}
                        </option>
                   </select>
                </b-field> 
           </div>

       </div>


       <div class="columns is-12" style="display:inline-flex;">
           <div class="column is-6">
                 <b-field label="Vacancy">
                   <b-select placeholder="Choose Options" expanded v-model="vacancy_id" :active.sync="title">
                        <option v-for="vacancy in vacancies" :value="vacancy.id">
                           {{ vacancy.en_name }}
                        </option>
                   </b-select>
                </b-field> 
           </div> 

            <div class="column is-6">
                    <b-field class="file" label="Cv">
                        <b-upload v-model="cv">
                            <a class="button is-primary">
                                <b-icon icon="upload"></b-icon>
                                <span>Click to upload</span>
                            </a>
                        </b-upload>
                        <span class="file-name" v-if="cv">
                            {{ cv.name }}
                        </span>
                    </b-field>
            </div>

       </div>

        <div class="columns is-12" style="display:inline-flex;">
           <div class="column is-6">
               <b><label style="display:block">Fisrt Name: </label></b>
               <b-input type="text" v-model="first_name"></b-input>
           </div>

        <div class="column is-6">
            <b><label style="display:block">Last Name: </label></b>
            <b-input type="text" v-model="last_name"></b-input>
        </div>

       </div>

        <div class="columns is-12" style="display:inline-flex;">
           <div class="column is-6">
               <b><label style="display:block">Email: </label></b>
               <b-input type="text" v-model="email"></b-input>
           </div>

        <div class="column is-6">
            <b><label style="display:block">Phone: </label></b>
            <b-input type="text" v-model="phone"></b-input>
        </div>

       </div>

         <div class="columns is-12" style="display:inline-flex;">
           <div class="column is-6">
               <b><label style="display:block">LinkedIn: </label></b>
               <b-input type="text" v-model="linkedin"></b-input>
           </div>

        <div class="column is-6">
         <b-field label="Location On Map">
            <b-select v-model="location" expanded>
                <option v-for="locationn in locations" :key="locationn.id" :value="locationn.id">
                    {{ locationn.name }}
                </option>
            </b-select>  
    </b-field> 
        </div>

       </div>

         <div class="columns is-12" style="display:inline-flex;">
           <div class="column is-6">
               <b><label style="display:block">Website: </label></b>
               <b-input type="text" v-model="website"></b-input>
           </div>

        <div class="column is-6">
            <b><label style="display:block">Applied Date: </label></b>
            <b-input type="date"></b-input>
        </div>

       </div>

         <b-button type="is-info" @click="addApplications">Submit</b-button>    
 
    </section>
</template>
<style>
.apps{
    background: #fff;
    padding-left: 2%;
    padding-bottom: 1%;
}
.control
{
    width: 50%;
}
.selectOption{
    width: 50%;
    background-color: #fff;
    height: 34px;
    border: 1px solid forestgreen;
    border-radius: 5px;
}
</style>
<script>
import {addApplication,getJobTitleInputs,getAllJobTitles,getJobTitlesDep,getVacancyJob,getAllLocations} from './../../calls'

export default {
      data() {
            return {
                departments:[],
                jobTitles:[],
                title:false,
                vacancies:[],
                first_name:null,
                last_name:null,
                email:null,
                phone:null,
                location:null,
                cv:null,
                linkedin:null,
                website:null,
                job_category:null,
                job_titles:null,
                vacancy_id:null,
                applications:[],
                locations:[],
                token: window.auth_user.csrf,
            }
        },
       mounted() {
            this.getDepartments()
            this.getLocations()
        },
    methods:{
        getDepartments(){
            getJobTitleInputs().then(response=>{
                // console.log('all respone',response)
                this.departments = response.data
                // console.log('All agents',this.agents)
            }).catch(error=>{
                console.log(error)
            })
        },
        getjobtitles(value){
            this.isLoading = true
            var department_id = value
            // console.log('dep',department_id);
            getJobTitlesDep(department_id).then(response=>{
                // console.log("job titles",response)
                this.jobTitles = response.data
                // console.log('deeep job title',this.jobTitles)
        })
        .catch(error => {
            console.log(error)
        })
        this.title = true
    },
    getVacancies(value){
        this.isLoading = true
        var jobTitle_id = value
        // console.log('dep',department_id);
        getVacancyJob(jobTitle_id).then(response=>{
            // console.log("vacancies",response)
            this.vacancies = response.data
            // console.log('vacancies job title',this.vacancies)
        })
        .catch(error => {
            console.log(error)
        })
        this.title = true

    },
    addApplications(){
            const bodyFormData = new FormData();
            bodyFormData.append('_token',this.token)
            bodyFormData.append('first_name',this.first_name)
            bodyFormData.append('last_name',this.last_name)
            bodyFormData.append('email',this.email)
            bodyFormData.append('phone',this.phone)
            bodyFormData.append('location',this.location)
            bodyFormData.append('cv',this.cv)
            bodyFormData.append('linkedin',this.linkedin)
            bodyFormData.append('website',this.website)
            bodyFormData.append('job_category',this.job_category)
            bodyFormData.append('job_titles',this.job_titles)
            bodyFormData.append('vacancy_id',this.vacancy_id)
            // bodyFormData.append('_method','put')
            
            addApplication(bodyFormData).then(response=>{
                this.success("Added")
                $(location).attr('href', '/admin/vue/application')
            })
        .catch(error => {
                this.errorDialog()
        })
    },
    errorDialog() {
        this.$dialog.alert({
            title: 'Error',
            message: 'Please Fill required inputs',
            type: 'is-danger',
        })
    },
    success(action) {
        this.$toast.open({
            message: 'Application'+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
    getLocations(){
        this.isLoading = true
        getAllLocations().then(response=>{
            this.locations = response.data
            // console.log('locations',response)
        }).catch(error=>{
            console.log(error)
        })
    },
 },
}
</script>
