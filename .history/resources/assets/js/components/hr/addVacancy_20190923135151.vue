<template>
    <section class="container jobs">
       <b>Vacancy</b><hr>
       <div class="column is-mobile">
           <div class="column is-12">
               <b><label style="display:block">English Name: </label></b>
               <b-input type="text" v-model="en_name"></b-input>
           </div>

        <div class="column is-12">
            <b><label style="display:block">Arabic Name: </label></b>
            <b-input type="text" v-model="ar_name"></b-input>
        </div>

       </div>

        <div class="column is-mobile">
           <div class="column is-12">
                <b-field label="English Description:">
                    <b-input type="textarea" v-model="en_description"></b-input>
                </b-field>  
           </div>

            <div class="column is-12">
                <b-field label="Arabic Description:">
                        <b-input type="textarea" v-model="ar_description"></b-input>
                </b-field>      
            </div>
       </div>
        

        <div class="column is-mobile is-12" style="display:inline-flex;margin-bottom:2%;">
            <div class="column is-4">
                <b-field label="Job Title">
                      <b-select expanded v-model="selectedJobTitle">
                            <option v-for="jobTitle in jobTitles" :value="jobTitle.id" >
                                    {{ jobTitle.en_name }} 
                            </option>
                       </b-select>
                </b-field> 
            </div>

            <div class="column is-4">
                <b-field label="Status">
                        <b-select expanded v-model="status">
                            <option value="0">Open</option>
                            <option value="1">Closed</option>
                        </b-select>
                </b-field> 
            </div>

            <div class="column is-4">
                <b-field label="Type">
                        <b-select expanded v-model="type">
                            
                        </b-select>
                </b-field> 
            </div>
        </div> 

         <b-button type="is-info"  @click="addVacancy">Submit</b-button>
    
 
    </section>
</template>
<style>
.jobs{
    background: #fff;
    padding-left: 2%;
    padding-bottom: 1%;
}
.control
{
    width: 50%;
}
</style>
<script>
import {addVacancy,getVacancyInputs} from './../../calls'

export default {
    data() {
            return {
                selectedJobTitle: null,
                jobTitles:[],
                en_name:null,
                ar_name:null,
                en_description:null,
                ar_description:null,
                status:null,
                type:null,
                open:'0',
                close:'1',
                types: [], 
                token: window.auth_user.csrf
            }},
    mounted() {
        this.getData()
    },
 methods: {
    getData(){
            this.isLoading = true
            getVacancyInputs().then(response=>{
                this.getVacType()
                console.log(response)
                this.jobTitles = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    getVacType(){
        getVacanceType().then(response=>{
            this.types = response.data
        }).catch(error=>{
            console.log(error)
        })
    },
    addVacancy(){
        var data ={
            '_token':this.token,
            'job_title_id':this.selectedJobTitle,
            'en_name':this.en_name,
            'ar_name':this.ar_name,
            'en_description':this.en_description,
            'ar_description':this.ar_description,
            'status':this.status,
            'type':this.type
        };
        addVacancy(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/vacancy')
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
            message: 'Vacancy'+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>
