<template>
    <section class="container jobs">
       <b>Add Employee</b><hr>
       <div class="columns">

           <div class="column is-4">
              
                <b-field label="First Name:">
                    <b-input type="text" v-model="en_first_name" required></b-input>
                </b-field> 
           </div>

            <div class="column is-4">
              
                <b-field label="Middle Name:">
                    <b-input type="text" v-model="en_middle_name" required></b-input>
                </b-field>
            </div>

            <div class="column is-4">
                
                <b-field label="Last Name:">
                    <b-input type="text" v-model="en_last_name" required></b-input>
                </b-field>
            </div>

       </div>

        <div class="columns">

           <div class="column is-4">
              
                <b-field label="Arabic First Name:">
                    <b-input type="text" v-model="ar_first_name" required></b-input>
                </b-field>
           </div>

            <div class="column is-4">
                <!-- <b><label style="display:block">Arabic Middle Name: </label></b>
                <b-input type="text" v-model="ar_middle_name"></b-input> -->
                 <b-field label="Arabic Middle Name:">
                    <b-input type="text" v-model="ar_middle_name" required></b-input>
                </b-field>
            </div>

            <div class="column is-4">
                 <b-field label="Arabic Last Name: ">
                    <b-input type="text" v-model="ar_last_name" required></b-input>
                </b-field>
            </div>

       </div>


        <div class="columns">

           <div class="column is-4">
               <b-field label="National ID: ">
                    <b-input type="text" v-model="national_id" required></b-input>
                </b-field>
              
           </div>

            <div class="column is-4">
                <b><label style="display:block">Profile Photo: </label></b>
                    <b-field class="file">
                        <b-upload required v-model="file">
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
                <!-- <b><label style="display:block">Salary: </label></b>
                <b-input type="number" v-model="salary"></b-input> -->
                <b-field label="Salary: ">
                    <b-input type="number" v-model="salary" required></b-input>
                </b-field>
            </div>

       </div>
       

        <div class="columns">

           <div class="column is-4">
               <b><label style="display:block">Gender: </label></b>
              <b-field>
                    <b-select required placeholder="Choose Options" expanded v-model="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </b-select>
              </b-field>

           </div>

            <div class="column is-4">
                <b><label style="display:block">marital_status: </label></b>
                 <b-field>
                    <b-select required placeholder="Choose Options" expanded v-model="marital_status">
                        <option value="widowed">Widowed</option>
                        <option value="divorced">Divorced</option>
                        <option value="married">Married</option>
                        <option value="engaged">Engaged</option>
                        <option value="single">single</option>
                    </b-select>
                 </b-field>
            </div>

            <div class="column is-4">
                <b><label style="display:block">military status: </label></b>
                <b-field>
                    <b-select required placeholder="Choose Options" expanded v-model="military_status">
                        <option value="fullfilled">Fullfilled</option>
                        <option value="postoned">Postoned</option>
                        <option value="exempted">Exempted</option>
                    </b-select>
                 </b-field>
            </div>

       </div>


         <div class="columns">

           <div class="column is-4">
               
               <b-field label="Phone: ">
                    <b-input type="number" v-model="phone" required></b-input>
                </b-field>
           </div>

            <div class="column is-4">
                
                 <b-field label="Email:">
                    <b-input type="email" v-model="personal_mail" required></b-input>
                </b-field>
            </div>

            <div class="column is-4">
                <!-- <b><label style="display:block">Company Mail: </label></b>
                <b-input type="text" v-model="company_mail"></b-input> -->
                <b-field label="Company Mail:">
                    <b-input type="email" v-model="company_mail" required></b-input>
                </b-field>
            </div>

       </div>

        <div class="columns">

           <div class="column is-6">
               <b><label style="display:block">Department: </label></b>
                <b-field>
                    <b-select required placeholder="Choose Options" expanded v-model="department">
                        <option v-for="department in departments" :value="department.id" >
                            {{ department.en_name }} 
                        </option>
                    </b-select>
                </b-field>

           </div>

            <div class="column is-6">
                <b><label style="display:block">Job: </label></b>
                 <b-field>
                    <b-select required placeholder="Choose Options" expanded v-model="jobTitle">
                        <option v-for="jobTitle in jobTitles" :value="jobTitle.id">
                            {{ jobTitle.en_name }}
                        </option>
                    </b-select>
                </b-field>
            </div>

       </div>

        <div class="columns">

           <div class="column is-3">
              
                <b-field label="Password:">
                    <b-input type="password" v-model="password" required></b-input>
                </b-field>
           </div>

            <div class="column is-3">
                
                <b-field label="Finger ID:">
                    <b-input type="number" v-model="finger_id" required></b-input>
                </b-field>
            </div>

             <div class="column is-3">
                <b><label style="display:block">Role: </label></b>
                 <b-field>
                    <b-select required placeholder="Choose Options" expanded v-model="role">
                        <option v-for="role in roles" :value="role.id">
                            {{ role.name }}
                        </option>
                    </b-select>
                </b-field>
            </div>

            <div class="field column is-3">
                <b><label style="display:block">Type: </label></b>
                <b-switch required v-model="isSwitchedCustom"
                    true-value="Yes"
                    false-value="No">
                    {{ isSwitchedCustom }}
                </b-switch>
             </div>
             
       </div>

         <b-button type="is-success" class="addemployee">Add Contact</b-button><br>

         <b-button type="is-info" @click="addEmployee">Create Employee</b-button>
    
 
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
.addemployee{
    margin-left: 44%;
}
</style>
<script>
import {addEmployee,getJobTitleInputs,getAllJobTitles,getAllRoles} from './../../calls'
export default {
    data() {
            return {
                en_first_name: null,
                en_middle_name:[],
                en_last_name:null,
                ar_first_name:null,
                ar_middle_name:null,
                ar_last_name:null,
                national_id:null,
                salary:null,
                phone:null,
                personal_mail:null,
                company_mail:null,
                department:null,
                role:null,
                finger_id:null,
                password:null,
                jobTitle:null,
                military_status:null,
                marital_status:null,
                gender:null,
                file: null,
                jobTitles:[],
                departments:[],
                roles:[],
                 isSwitched: false,
                isSwitchedCustom: 'Yes',
                token: window.auth_user.csrf
            }},
    mounted() {
        this.getData()
        this.getjobtitles()
        this.getroles()
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
    addEmployee(){
        var data ={
            '_token':this.token,
            'en_first_name':this.en_first_name,
            'en_middle_name':this.en_middle_name,
            'en_last_name':this.en_last_name,
            'ar_first_name':this.ar_first_name,
            'ar_middle_name':this.ar_middle_name,
            'ar_last_name':this.ar_last_name,
            'national_id':this.national_id,
            'salary':this.salary,
            'phone':this.phone,
            'personal_mail':this.personal_mail,
            'gender': this.gender,
            'marital_status': this.marital_status,
            'military_status': this.military_status,
            'job_category_id': this.department,
            'job_title_id' : this.jobTitle,
            'role_id': this.role,
            'image':this.image,
        };
        addEmployee(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/employees')
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
            message: 'Employee '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>
