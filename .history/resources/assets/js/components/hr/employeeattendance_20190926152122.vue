<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            EMPLOYEE ATTENDANCE
                        </p>
                    </div>
                </div>
                <div class="level-right" style="padding:.5vw">
                    <!-- <b-button type="is-info" @click="AddNewRequest">Add New</b-button> -->
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-12">
                                <label class="label">Employee</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="employee_id">
                                            <option v-for="employee in Employees" :key="employee.id" :value="employee.id">{{employee.en_first_name+' '+employee.en_middle_name+' '+employee.en_last_name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="column is-12">
                                <div class="text-center">
                                    <b-button type="is-info">ATTENDANCE Now <span class="fa fa-clock"></span></b-button>
                                </div>
                            </div>
                        </div>
                </section>
                <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
            </div>
        </div>
    </div>
</template>
<script>
import {
    getAllEmployees,
} from './../../calls'

export default {
    data() {
        return {
            employee_id:window.auth_user.emploee_id,
            isFullPage:true,
            isLoading:true,
            Employees:[],
        }
    },
    mounted(){
        console.log('Emp Id',this.employee_id)
        this.AllEmployees()
        // this.getUserLocations()
            this.$getLocation(options)
            .then(coordinates => {
                console.log(coordinates);
            });
    },
    methods:{
        AllEmployees(){
            this.isLoading = true
            getAllEmployees().then(response=>{
            this.isLoading = false
                this.Employees = response.data
            }).catch(error=>{
                console.log(error)
            })
        },
        getUserLocations(){
        }
    }
}
</script>
