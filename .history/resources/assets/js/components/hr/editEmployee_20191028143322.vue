<template>
    <section class="container jobs">
       <b>Edit Employee</b><hr>
       <div class="columns">

           <div class="column is-4">
               <b><label style="display:block">First Name: </label></b>
               <b-input type="text" v-model="employee.en_first_name"></b-input>
           </div>

            <div class="column is-4">
                <b><label style="display:block">Middle Name: </label></b>
                <b-input type="text" v-model="employee.en_middle_name"></b-input>
            </div>

            <div class="column is-4">
                <b><label style="display:block">Last Name: </label></b>
                <b-input type="text" v-model="employee.en_last_name"></b-input>
            </div>

       </div>

        <div class="columns">

           <div class="column is-4">
               <b><label style="display:block">Arabic First Name: </label></b>
               <b-input type="text" v-model="employee.ar_first_name"></b-input>
           </div>

            <div class="column is-4">
                <b><label style="display:block">Arabic Middle Name: </label></b>
                <b-input type="text" v-model="employee.ar_middle_name"></b-input>
            </div>

            <div class="column is-4">
                <b><label style="display:block">Arabic Last Name: </label></b>
                <b-input type="text" v-model="employee.ar_last_name"></b-input>
            </div>

       </div>


        <div class="columns">

           <div class="column is-4">
               <b><label style="display:block">National ID: </label></b>
               <b-input type="text" v-model="employee.national_id"></b-input>
           </div>

            <div class="column is-4">
                <b><label style="display:block">Profile Photo: </label></b>
                    <b-field class="file">
                        <b-upload v-model="file">
                            <a class="button is-primary">
                                <b-icon icon="upload"></b-icon>
                                <span>Click to upload</span>
                            </a>
                        </b-upload>
                        <span class="file-name" v-if="file">
                            {{ file.name }}
                        </span>
                     </b-field>
            </div>

            <div class="column is-4">
                <b><label style="display:block">Salary: </label></b>
                <b-input type="number" v-model="employee.salary"></b-input>
            </div>

       </div>
       

        <div class="columns">

           <div class="column is-4">
               <b><label style="display:block">Gender: </label></b>
              <b-field>
                    <b-select placeholder="Choose Options" expanded v-model="employee.gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </b-select>
              </b-field>

           </div>

            <div class="column is-4">
                <b><label style="display:block">marital_status: </label></b>
                 <b-field>
                    <b-select placeholder="Choose Options" expanded v-model="employee.marital_status">
                        <option value="Widowed">Widowed</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Married">Married</option>
                        <option value="Engaged">Engaged</option>
                        <option value="single">single</option>
                    </b-select>
                 </b-field>
            </div>

            <div class="column is-4">
                <b><label style="display:block">military status: </label></b>
                <b-field>
                    <b-select placeholder="Choose Options" expanded v-model="employee.military_status">
                        <option value="fullfilled">Fullfilled</option>
                        <option value="postoned">Postoned</option>
                        <option value="exempted">Exempted</option>
                    </b-select>
                 </b-field>
            </div>

       </div>


         <div class="columns">

           <div class="column is-4">
               <b><label style="display:block">Phone: </label></b>
               <b-input type="text" v-model="employee.phone"></b-input>
           </div>

            <div class="column is-4">
                <b><label style="display:block">Email: </label></b>
                <b-input type="text" v-model="employee.personal_mail"></b-input>
            </div>

            <div class="column is-4">
                <b><label style="display:block">Company Mail: </label></b>
                <b-input type="text" v-model="employee.company_mail"></b-input>
            </div>

       </div>

        <div class="columns">

           <div class="column is-6">
               <b><label style="display:block">Department: </label></b>
                <b-field>
                    <b-select placeholder="Choose Options" expanded v-model="employee.job_category_id">
                        <option v-for="department in departments" :key="department.id" :value="department.id" >
                            {{ department.en_name }} 
                        </option>
                    </b-select>
                </b-field>

           </div>

            <div class="column is-6">
                <b><label style="display:block">Job: </label></b>
                 <b-field>
                    <b-select placeholder="Choose Options" expanded v-model="employee.job_title_id">
                        <option v-for="jobTitle in jobTitles" :key="jobTitle.id" :value="jobTitle.id">
                            {{ jobTitle.en_name }}
                        </option>
                    </b-select>
                </b-field>
            </div>

       </div>

        <div class="columns">

           <div class="column is-3">
               <b><label style="display:block">Password: </label></b>
               <b-input type="password"></b-input>
           </div>

            <div class="column is-3">
                <b><label style="display:block">Finger ID: </label></b>
                <b-input type="number" v-model="employee.finger_id"></b-input>
            </div>

             <div class="column is-3">
                <b><label style="display:block">Role: </label></b>
                 <b-field>
                    <b-select placeholder="Choose Options" expanded v-model="employee.role_id">
                        <option v-for="role in roles" :value="role.id">
                            {{ role.name}}
                        </option>
                    </b-select>
                </b-field>
            </div>

            <div class="field column is-3">
                <b><label style="display:block">Type: </label></b>
                <b-switch v-model="employee.type" 
                    true-value="admin"
                    false-value="employee">
                    {{ type }}
                </b-switch>
             </div>
             
       </div>

         <b-button type="is-info" class="editemployee" @click="UpdateEmployee">Update Employee</b-button><br>
    
 
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
    width: 100%;
    padding-right: 14px;
}
.editemployee{
    margin-left: 44%;
}
</style>
<script>
import {showEmployee,getJobTitleInputs,updateThisEmployee,getAllRoles,getAllJobTitles} from './../../calls'
export default {
    data() {
            return {
                department:null,
                jobTitle:null,
                jobTitles:[],
                departments:[],
                roles:[],
                employee:[],
                file: null,
                isSwitched: false,
                type: 'admin',
                token: window.auth_user.csrf
            }},
    created() {
        this.id = this.$route.params.id
        },
    mounted() {
        this.getData()
        this.getroles()
        this.getjobtitles()
        this.getDepartmentData()
    },
 methods: {
      getroles(){
         this.isLoading = true
            getAllRoles().then(response=>{
                console.log("Roles",response)
                this.roles = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
     },
     getjobtitles(){
         this.isLoading = true
            getAllJobTitles().then(response=>{
                console.log("job titles",response)
                this.jobTitles = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
     },
    getDepartmentData(){
            this.isLoading = true
            getJobTitleInputs().then(response=>{
                console.log("Depatments",response)
                this.departments = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    getData(){
            this.isLoading = true
            showEmployee(this.id).then(response=>{
                console.log("this employee",response)
                this.employee = response.data.employee
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    UpdateEmployee(){
                const bodyFormData = new FormData();
                for (let key in this.employee) {
                    const value = this.employee[key];
                    bodyFormData.set(key, value);
                    console.log(key,value)
                }
                bodyFormData.append('_token',this.token)
                bodyFormData.append('_method','put')
                updateThisEmployee(bodyFormData,this.id).then(response=>{
                    console.log(response)
                //   $(location).attr('href', '/admin/vue/employees')
                }).catch(error=>{
                    console.log(error)
                })
            }
    
 },
}
</script>
