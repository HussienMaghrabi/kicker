<template>
    <section class="container jobs">
       <b>Job Title</b><hr>
       <div class="column is-mobile">
           <div class="column is-12">
               <!-- <b><label style="display:block">English Name: </label></b>
               <b-input type="text" v-model="en_name"></b-input> -->
               <b-field label="English Name:">
                    <b-input type="text"  v-model="en_name" required></b-input>
                </b-field>
           </div>

        <div class="column is-12">
            <!-- <b><label style="display:block">Arabic Name: </label></b>
            <b-input type="text" v-model="ar_name"></b-input> -->
            <b-field label="Arabic Name: ">
                    <b-input type="text"  v-model="ar_name" required></b-input>
                </b-field>
        </div>

       </div>

        <div class="column is-mobile">
           <div class="column is-12">
                <b-field label="English Description:">
                    <b-input type="textarea" v-model="en_description" required></b-input>
                </b-field>  
           </div>

            <div class="column is-12">
                <b-field label="Arabic Description:">
                        <b-input type="textarea" v-model="ar_description" required></b-input>
                </b-field>      
            </div>
       </div>


       <b-field label="department">
            <b-select required expanded v-model="selectedDepartment">
                 <option v-for="department in departments" :value="department.id" >
                        {{ department.en_name }} 
                 </option>
            </b-select>
        </b-field> 

         <b-button type="is-info" @click="addJobTitle">Submit</b-button>
    
 
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
import {addJobTitle,getJobTitleInputs} from './../../calls'
export default {
    data() {
            return {
                selectedDepartment: null,
                departments:[],
                en_name:null,
                ar_name:null,
                en_description:null,
                ar_description:null,
                token: window.auth_user.csrf
            }},
    mounted() {
        this.getData()
    },
 methods: {
    getData(){
            this.isLoading = true
            getJobTitleInputs().then(response=>{
                console.log(response)
                this.departments = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    addJobTitle(){
        var data ={
            // '_token':this.token,
            'job_category_id':this.selectedDepartment,
            'en_name':this.en_name,
            'ar_name':this.ar_name,
            'en_description':this.en_description,
            'ar_description':this.ar_description,
        };
        addJobTitle(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/jobTitle')
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
            message: 'Job Title '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>
