<template>
    <section class="container">
    
     <sidebarmenu></sidebarmenu>
     <div class="columns" >
         <div class="column is-12" style="padding-left:2%;">
           <p style="border-bottom:2px solid #b07d12;font-size:18px;font-weight:bold;">Settings</p><hr>
         </div>
     </div>

       <div class="columns">
                         <div class="inner-box-body">
                                 <div class="columns is-multiline">
                                     <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Working Days :
                                                <!-- <span v-if="!edit.first_name" id="first_name" class="">
                                                    {{ getleads.lead.first_name }}
                                                </span> -->
                                                <!-- <i v-if="!edit.first_name" @click="fn_edit('first_name')" -->
                                                    <i class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="first_name"
                                                    id="first_name_btn"></i>
                                                <!-- <i v-if="edit.first_name" @click="fn_edit('first_name')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="first_name"
                                                    id="first_name_save"></i>
                                                <span v-if="edit.first_name" id="first_name_input" class="">
                                                    <input type="text" class="update_input" v-model="updatelead.first_name" 
                                                        id="first_name_update">
                                                </span> -->
                                            </div>
                                        </div>
                                        
                                     <div class="column is-1 border_right"> </div>
                                        
                                        <div class="column is-5 head_margin_top">
                                            Working Hours :
                                            <!-- <span v-if="!edit.middle_name" id="middle_name" class="">
                                                Mohamed
                                            </span> -->
                                            <!-- <i v-if="!edit.middle_name" @click="fn_edit('middle_name')" -->
                                            <i class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="middle_name"
                                                id="middle_name_btn"></i>
                                            <!-- <i v-if="edit.middle_name" @click="fn_edit('middle_name')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="middle_name"
                                                id="middle_name_save"></i>

                                            <span v-if="edit.middle_name" id="middle_name_input" class="hidden">
                                                <input type="text" class="update_input" value="mohamed"
                                                    id="middle_name_update">
                                            </span> -->
                                        </div>

                                         <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Start Work :
                                                <!-- <span v-if="!edit.last_name" id="last_name" class="">
                                                    {{ getleads.lead.last_name }}
                                                </span>
                                                <i v-if="!edit.last_name" @click="fn_edit('last_name')" -->
                                                <i  class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="last_name"
                                                    id="last_name_btn"></i>
                                                <!-- <i v-if="edit.last_name" @click="fn_edit('last_name')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="last_name"
                                                    id="last_name_save"></i>
                                                <span v-if="edit.last_name" id="last_name_input" class="hidden">
                                                    <input type="text" v-model="updatelead.last_name" class="update_input" value="hassan"
                                                        id="last_name_update">
                                                </span> -->
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>

                                         <div class="column is-5 head_margin_top">
                                            End Work :
                                            <!-- <span v-if="!edit.ar_first_name" id="ar_first_name" class="">
                                                {{ getleads.lead.first_name_ar }}
                                            </span>
                                            <i v-if="!edit.ar_first_name" @click="fn_edit('ar_first_name')" -->
                                            <i   class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="ar_first_name"
                                                id="ar_first_name"></i>

                                            <!-- <i v-if="edit.ar_first_name" @click="fn_edit('ar_first_name')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="ar_first_name"
                                                id="ar_first_name"></i>
                                            <span v-if="edit.ar_first_name" id="ar_first_name" class="">
                                                <input type="text" v-model="updatelead.ar_first_name" class="update_input" value="arabic first name"
                                                    id="ar_first_name">
                                            </span> -->
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Weekend :
                                                <!-- <span v-if="!edit.ar_middle_name" id="ar_middle_name" class="">
                                                    arabic middle name
                                                </span>
                                                <i v-if="!edit.ar_middle_name" @click="fn_edit('ar_middle_name')" -->
                                                <i class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="ar_middle_name"
                                                    id="ar_middle_name_btn"></i>
                                                <!-- <i v-if="edit.ar_middle_name" @click="fn_edit('ar_middle_name')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="ar_middle_name"
                                                    id="ar_middle_name_save"></i>
                                                <span v-if="edit.ar_middle_name" id="ar_middle_name_input" class="">
                                                    <input type="text" class="update_input" value="arabic middle name"
                                                        id="ar_middle_name_update">
                                                </span> -->
                                            </div>
                                        </div>



                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 head_margin_top">
                                            Annual Vacation :
                                            <!-- <span v-if="!edit.religion" id="religion" class="">
                                                my religion
                                            </span>
                                            <i v-if="!edit.religion" @click="fn_edit('religion')" -->
                                            <i class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="religion"
                                                id="religion_btn"></i>
                                            <!-- <i v-if="edit.religion" @click="fn_edit('religion')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="religion"
                                                id="religion_save"></i>
                                            <span v-if="edit.religion" id="religion_input" class="">
                                                <b-select v-model="updatelead.religion" placeholder="Select religion">
                                                    <option value="muslim">muslim</option>
                                                    <option value="christian">christian</option>
                                                    <option value="jewish">jewish</option>
                                                    <option value="other">other</option>
                                                </b-select>
                                            </span> -->
                                        </div>

                                         <div class="column is-1 border_right"> </div>
 

                                         <div class="column is-1 border_right"> </div>

    
                                 </div>
                            </div>
                    </div>

         <div class="columns is-12" style="">
             <div class="Employee-details column is-6" style="border-top: 3px solid #b07d12;">
                    <b>Gross Salary</b><hr>
                    <b-field label="Choose Employee" class="column is-12">
                        <b-select v-model="setting.employeeGSalary" expanded>
                            <option value=""></option>
                            <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.en_first_name }} {{ employee.en_last_name }}</option>
                        </b-select>
                    </b-field>

                    <div class="columns is-12">
                        <div class="column is-6">
                            <b-field label="Ordered by:">
                              <b-input type="text" v-model="name"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6">
                            <b-field label="Allowances:">
                              <b-input type="number" v-model="name"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                        <div class="column is-6">
                            <b-field label="Date:">
                              <b-input type="date" v-model="name"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6">
                            <b-field label="Details:">
                              <b-input type="text" v-model="name"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                          <b-button type="is-info">Update Salary</b-button>
                    </div>
                
             </div>
            <div class="Employee-details column is-6" style="border-top: 3px solid #b07d12;">
                <b>Deduction</b><hr>
                <b-field label="Choose Employee" class="column is-12">
                    <b-select v-model="setting.employeeDeduction" expanded>
                        <option value=""></option>
                        <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.en_first_name }} {{ employee.en_last_name }}</option>
                    </b-select>
                </b-field>

                <div class="columns is-12">
                    <div class="column is-6">
                        <b-field label="Ordered by:">
                        <b-input type="text" v-model="name"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-6">
                        <b-field label="Deductions:">
                        <b-input type="number" v-model="name"></b-input>
                        </b-field>
                    </div>
                </div>

                <div class="columns is-12">
                    <div class="column is-6">
                        <b-field label="Date:">
                        <b-input type="date" v-model="name"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-6">
                        <b-field label="Details:">
                        <b-input type="text" v-model="name"></b-input>
                        </b-field>
                    </div>
                </div>

                <div class="columns is-12">
                    <b-button type="is-info">Update Salary</b-button>
                </div>
            
            </div>

         </div>

         <!-- vacaaaaaation -->

         <div class="columns is-12">

             <div class="column is-6">
                     <p style="font-size:18px;font-weight:bold;margin-bottom: 5%;">National Vacations</p>
                    <div class="columns is-12">
                        <div class="column is-6" style="padding-left:3%;">
                            <b-field label="English Name:">
                              <b-input type="text" placeholder="English Name" v-model="name"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Arabic Name:">
                              <b-input type="text" placeholder="Arabic Name" v-model="name"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                        <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Number Of Days:">
                              <b-input type="text" placeholder="Number Of Days" v-model="name"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Type:" class="column is-12">
                                <b-select expanded>
                                    <option value="int">int</option>
                                    <option value="int">int</option>
                                </b-select>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                        <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Start Date:">
                              <b-input type="date" v-model="name"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6" style="padding-left:3%;">
                            <b-field label=" End Date:">
                              <b-input type="date" v-model="name"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                          <b-button type="is-info">Submit</b-button>
                    </div>
                
             </div>


                 <div class="column is-12">
                     <p style="font-size:18px;font-weight:bold;margin-bottom: 1%;">National Vacations</p>
                    <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                    <td>@mdo</td>
                                    <td>@mdo</td>
                                </tr>
                                
                            </tbody>
                    </table>
                </div>

              </div>
       
     </section>
  
               
</template>

<script>

import sidebarmenu from './sidebarmenu'
import {allEmployees,deleteThisEmployee,filterEmployees,action_logs,callstatus,getMeetingStatus,getAllEmployees} from './../../calls'
export default {
    data() {
            return {

                el: '#chart',
                series: [44, 55, 13, 43, 22],
                chartOptions: {
                labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]},
                file: null,
                name: null,
                setting:[],
                has_next_action: null,
                isSwitched: false,
                isSwitchedCustom: 'Yes',
                activeTab: 0,
                showBooks: false,
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                actionLogs: [],
                selectedLogs: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                isLoading: true,
                isFullPage: true,
                employees:[],
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               isComponentModalActive: false,
                 formProps: {
                     name:'',
                    description:'',
                } 
            }
        },
        mounted() {
            this.getData()
        },
        components: {
            'sidebarmenu': sidebarmenu
        },
        created() {
            // this.$router.replace({hash: '#/1'});
            this.getEmployees()
         },
         methods:{
            getData(){
            this.isLoading = true
                action_logs(this.page).then(response=>{
                console.log("TEST",response)
                // this.perPage = response.data.per_page
                this.actionLogs = response.data.data
                this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.logsTotalNumber = response.data.total
                this.total = response.data.total
                
                // if(this.allAgent_type.length == 0){
                //     this.isEmpty = true
                // }
                // let currentTotal = response.data.total
                // if (response.data.total / this.perPage > 1000) {
                //     currentTotal = this.perPage * 1000
                // }

                // this.total = currentTotal
                this.isLoading = false
            

                })
            .catch(error => {
                console.log(error)
            })
        },
        getEmployees(){
            getAllEmployees().then(response=>{
                this.employees = response.data
                console.log('All Employee',this.employees)
            }).clatch(error=>{
                console.log(error)
            })
        },
        onPageChange(page) {
                // this.page = page
                // this.$router.replace({ name: "logs", params: {page: page} })
                // this.getData()
            },
      
    },
}
</script>
            
<style>
.Employee-details{
    /* padding: .5rem; */
    margin-left:1rem;
    background-color: whitesmoke 
}
.headerr{
    margin-bottom: 3%;
}
.container{
    background-color: #fff;
}
.columns:last-child{
    margin-bottom: 0%;
    margin-left: 0%;
}
.column.is-5, .column.is-5-tablet{
    margin-bottom: 3%;
    padding-left: 3%;
}
.search{
      float: right;
  }
.inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
.columns .column{
    padding: -1px;
}
</style>
