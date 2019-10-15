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
                            <b-table
                                :data="EmployeesSalary"
                                :paginated="isPaginated"
                                :per-page="perPage"
                                :current-page.sync="currentPage"
                                :pagination-simple="isPaginationSimple"
                                :pagination-position="paginationPosition"
                                :default-sort-direction="defaultSortDirection"
                                default-sort="user.first_name"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page">

                                <template slot-scope="props">
                                    <b-table-column field="EmployeesSalary.id" label="ID" width="40" sortable numeric>
                                        {{ props.row.id }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.en_first_name" label="First name" width="40" sortable>
                                        {{ props.row.en_first_name }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.en_last_name" label="Last name" width="40" sortable>
                                        {{ props.row.en_last_name }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.salary" label="Salary" width="40" sortable>
                                        {{ props.row.salary }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.allowanes" label="Allowanes" width="40" sortable>
                                        {{ props.row.allowanes }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.details" label="Details" width="40" sortable>
                                        {{ props.row.details }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.order_by" label="Order By" width="40" sortable>
                                        {{ props.row.order_by }}
                                    </b-table-column>
                                    <b-table-column field="EmployeesSalary.date" label="Date" width="40" sortable>
                                        {{ props.row.date }}
                                    </b-table-column>
                                </template>
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
            isPaginated: true,
            isPaginationSimple: false,
            showDetailIcon: true,
            defaultSortDirection: 'desc',
            IconsCurrentNumber: null,
            perPage:20,
            ActiveModal:false,
            isLoading:true,
        }
    },
    methods:{
        getData(){
            GrossEmployeeSalary().then(response=>{
                this.EmployeesSalary = response.data
                console.log(this.EmployeesSalary)
                this.isLoading = false
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>
