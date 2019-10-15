<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Gross Salary Report
                        </p>
                    </div>
                </div>
                <div class="level-right" style="padding:.5vw">
                    <!-- <b-button type="is-info" @click="AddNewRequest">Add New</b-button> -->
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-table>
                            </b-table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
    </div>
</template>

<script>
import {
    GrossEmployeeSalary,
} from './../../calls'
export default {
    mounted(){
        this.getData()
    },
    data() {
        return {
            isFullPage:true,
            isLoading:true,
            EmployeesSalary:[],
        }
    },
    methods:{
        getData(){
            GrossEmployeeSalary().then(response=>{
                this.EmployeesSalary = response.data
                this.isLoading = false
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>
