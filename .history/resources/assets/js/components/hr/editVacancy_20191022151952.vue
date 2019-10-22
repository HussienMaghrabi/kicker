<template>
    <section class="container jobs">
       <b>Edit Vacancy</b><hr>
       <div class="column is-mobile">
           <div class="column is-12">
               <b><label style="display:block">English Name: </label></b>
               <b-input type="text" v-model="vacancy.en_name"></b-input>
           </div>

        <div class="column is-12">
            <b><label style="display:block">Arabic Name: </label></b>
            <b-input type="text" v-model="vacancy.ar_name"></b-input>
        </div>

       </div>

        <div class="column is-mobile">
           <div class="column is-12">
                <b-field label="English Description:">
                    <b-input type="textarea" v-model="vacancy.en_description"></b-input>
                </b-field>  
           </div>

            <div class="column is-12">
                <b-field label="Arabic Description:">
                        <b-input type="textarea" v-model="vacancy.ar_description"></b-input>
                </b-field>
            </div>
       </div>
        

        <div class="column is-mobile is-12" style="display:inline-flex;margin-bottom:2%;">
            <div class="column is-4">
                <b-field label="Job Title">
                         <b-select expanded v-model="vacancy.job_title_id">
                            <option v-for="jobTitle in jobTitles" :key="jobTitle.id" :value="jobTitle.id" >
                                    {{ jobTitle.en_name }} 
                            </option>
                       </b-select>
                </b-field> 
            </div>

            <div class="column is-4">
                <b-field label="Status">
                        <b-select expanded v-model="vacancy.status">
                            <option v-if="vacancy.status == 'open'" selected value="0">Open</option>
                            <option v-else value="0">Open</option>
                            <option v-if="vacancy.status == 'closed'" selected value="1">Closed</option>
                            <option v-else selected value="1">Closed</option>
                        </b-select>
                </b-field> 
            </div>

            <div class="column is-4">
                <b-field label="Type">
                        <b-select expanded v-model="vacancy.vacancies_type_id">
                            <option v-for="(type,index) in types" :key="type.id" :value="type.id"> {{ index + 1 }}-{{ type.name }} </option>
                        </b-select>
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
.control
{
    width: 50%;
}
</style>
<script>
import {editVacancy,getVacancyInputs,showVacancy,getVacanceType} from './../../calls'

export default {
    data() {
            return {
                job_title_id: null,
                jobTitles:[],
                types: [], 
                vacancy:{},
                status:null,
                type:null,
                open:'0',
                close:'1',
                token: window.auth_user.csrf
            }},
    created() {
        this.id = this.$route.params.id
    },
    mounted() {
        this.getData()
        this.getRowData()
    },
 methods: {
    getRowData(){
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
    getData(){
            this.isLoading = true
            getVacancyInputs().then(response=>{
                // console.log(response)
                this.jobTitles = response.data
                this.getVacType()
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
    updateForm(){
            const bodyFormData = new FormData();
            for (let key in this.vacancy) {
                const value = this.vacancy[key];
                bodyFormData.set(key, value);
            }
            bodyFormData.append('_method','put')
            editVacancy(bodyFormData,this.id).then(response=>{
                console.log(response)
                // $(location).attr('href', '/admin/vue/vacancy')
            }).catch(error=>{
                console.log(error)
            })
    }},
}
</script>
