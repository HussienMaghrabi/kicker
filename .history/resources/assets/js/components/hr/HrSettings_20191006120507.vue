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
                                                Working Days:
                                                <span v-if="!edit.days" id="days" class="">
                                                    {{ HrSettings.days }}
                                                </span>
                                                <i v-if="!edit.days" @click="fn_edit('days')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="days"
                                                    id="days_btn"></i>
                                                <i v-if="edit.days" @click="fn_edit('days')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="days"
                                                    id="days_save"></i>
                                                <span v-if="edit.days" id="days_input" class="">
                                                    <input type="text" class="update_input" v-model="HrSettings.days" 
                                                        id="days_update">
                                                </span>
                                            </div>
                                        </div>
                                        
                                     <div class="column is-1 border_right"> </div>
                                        
                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Working Hours:
                                                <span v-if="!edit.hours" id="hours" class="">
                                                    {{ HrSettings.hours }}
                                                </span>
                                                <i v-if="!edit.hours" @click="fn_edit('hours')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="hours"
                                                    id="hours_btn"></i>
                                                <i v-if="edit.hours" @click="fn_edit('hours')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="hours"
                                                    id="hours_save"></i>
                                                <span v-if="edit.hours" id="hours_input" class="">
                                                    <input type="text" class="update_input" v-model="HrSettings.hours" 
                                                        id="hours_update">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Start Work:
                                                <span v-if="!edit.work_start" id="work_start" class="">
                                                    {{ HrSettings.work_start }} AM
                                                </span>
                                                <i v-if="!edit.work_start" @click="fn_edit('work_start')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="work_start"
                                                    id="work_start_btn"></i>
                                                <i v-if="edit.work_start" @click="fn_edit('work_start')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="work_start"
                                                    id="work_start_save"></i>
                                                <span v-if="edit.work_start" id="work_start_input" class="">
                                                    <input type="text" class="update_input" v-model="HrSettings.work_start" 
                                                        id="work_start_update">
                                                </span>
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                End Work:
                                                <span v-if="!edit.work_end" id="work_end" class="">
                                                    {{ HrSettings.work_end }} PM
                                                </span>
                                                <i v-if="!edit.work_end" @click="fn_edit('work_end')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="work_end"
                                                    id="work_end_btn"></i>
                                                <i v-if="edit.work_end" @click="fn_edit('work_end')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="work_end"
                                                    id="work_end_save"></i>
                                                <span v-if="edit.work_end" id="work_end_input" class="">
                                                    <input type="text" class="update_input" v-model="HrSettings.work_end" 
                                                        id="work_end_update">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Weekends:
                                                <!-- <span v-if="!edit.annual_vacation" id="annual_vacation" class="">
                                                    {{ HrSettings.annual_vacation }}
                                                </span> -->
                                                <i v-if="!edit.weekends" @click="fn_edit('weekends')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="weekends"
                                                    id="weekends_btn"></i>
                                                <i v-if="edit.weekends" @click="fn_edit('weekends')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="weekends"
                                                    id="weekends_save"></i>
                                                <span v-if="edit.weekends" id="weekends_input" class="">
                                                    <multiselect :close-on-select="false" v-model="SelectDay"  tag-placeholder="Add this as new tag" placeholder="Select Days" label="day" track-by="id" value="id" :options="Days" :multiple="true" :taggable="true"></multiselect>
                                                </span>
                                            </div>
                                        </div>

\                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Annual Vacation:
                                                <span v-if="!edit.annual_vacation" id="annual_vacation" class="">
                                                    {{ HrSettings.annual_vacation }}
                                                </span>
                                                <i v-if="!edit.annual_vacation" @click="fn_edit('annual_vacation')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="annual_vacation"
                                                    id="annual_vacation_btn"></i>
                                                <i v-if="edit.annual_vacation" @click="fn_edit('annual_vacation')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="annual_vacation"
                                                    id="annual_vacation_save"></i>
                                                <span v-if="edit.annual_vacation" id="annual_vacation_input" class="">
                                                    <input type="text" class="update_input" v-model="HrSettings.annual_vacation" 
                                                        id="annual_vacation_update">
                                                </span>
                                            </div>
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
                        <b-select v-model="GroosSalary.employee_id" expanded>
                            <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.en_days }} {{ employee.en_last_name }}</option>
                        </b-select>
                    </b-field>

                    <div class="columns is-12">
                        <div class="column is-6">
                            <b-field label="Ordered by:">
                              <b-input type="text" v-model="GroosSalary.order_by"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6">
                            <b-field label="Allowances:">
                              <b-input type="number" v-model="GroosSalary.allowanes"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                        <div class="column is-6">
                            <b-field label="Date:">
                              <b-input type="date" v-model="GroosSalary.date"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6">
                            <b-field label="Details:">
                              <b-input type="text" v-model="GroosSalary.details"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                          <b-button @click="UpdateEmployeeSalary" type="is-info">Update Salary</b-button>
                    </div>
                
             </div>
            <div class="Employee-details column is-6" style="border-top: 3px solid #b07d12;">
                <b>Deduction</b><hr>
                <b-field label="Choose Employee" class="column is-12">
                    <b-select v-model="Deduction.employee_id" expanded>
                        <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.en_days }} {{ employee.en_last_name }}</option>
                    </b-select>
                </b-field>

                <div class="columns is-12">
                    <div class="column is-6">
                        <b-field label="Ordered by:">
                        <b-input type="text" v-model="Deduction.order_by"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-6">
                        <b-field label="Deductions:">
                        <b-input type="number" v-model="Deduction.Deduction"></b-input>
                        </b-field>
                    </div>
                </div>

                <div class="columns is-12">
                    <div class="column is-6">
                        <b-field label="Date:">
                        <b-input type="date" v-model="Deduction.date"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-6">
                        <b-field label="Details:">
                        <b-input type="text" v-model="Deduction.details"></b-input>
                        </b-field>
                    </div>
                </div>

                <div class="columns is-12">
                    <b-button @click="updateEmployeeDeduction" type="is-info">Update Salary</b-button>
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
                              <b-input type="text" v-model="national.en_name" placeholder="English Name"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Arabic Name:">
                              <b-input type="text" placeholder="Arabic Name" v-model="national.ar_name"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                        <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Number Of Days:">
                              <b-input type="text" placeholder="Number Of Days" v-model="national.days"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Type:" class="column is-12">
                                <b-select v-model="national.natoial_vacation_type_id" expanded>
                                    <option v-for="type in vacationTypes" :value="type.id" :key="type.id">{{ type.name }}</option>
                                </b-select>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                        <div class="column is-6" style="padding-left:3%;">
                            <b-field label="Start Date:">
                              <b-input type="date" v-model="national.from"></b-input>
                            </b-field>
                        </div>

                         <div class="column is-6" style="padding-left:3%;">
                            <b-field label=" End Date:">
                              <b-input type="date" v-model="national.to"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns is-12">
                          <b-button @click="AddNationalVacation" type="is-info">Submit</b-button>
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
            <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
     </section>

</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import Multiselect from 'vue-multiselect'
import sidebarmenu from './sidebarmenu'
import {allEmployees,deleteThisEmployee,filterEmployees,action_logs,callstatus,getMeetingStatus,getAllEmployees,getHrSettingData,updateHrSettings,UpdateGroosSalary,employeeDeductionUpdate,GetAllVacatonType,addNewNational} from './../../calls'
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
                GroosSalary: [],
                Deduction: [],
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
                },
                edit: {
                    days: false,
                    hours: false,
                    last_name: false,
                    work_start: false,
                    work_end: false,
                    annual_vacation: false,
                    weekends:false,
                },
                HrSettings:[],
                Days:[],
                SelectDay:[],
                national:[],
                vacationTypes:[],
            }
        },
        mounted() {
            this.getData()
            this.getVacationsType()
        },
        components: {
            'sidebarmenu': sidebarmenu,
            Multiselect
        },
        created() {
            // this.$router.replace({hash: '#/1'});
            this.getEmployees()
         },
         methods:{
            getData(){
                getHrSettingData().then(response=>{
                    this.isLoading = false
                    this.HrSettings = response.data.HrData[0]
                    this.Days = response.data.Days
                    this.SelectDay = response.data.SelectionDay
                    console.log(response)
                }).catch(error=>{
                    console.log(error)
                    this.isLoading = false
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
        AddNationalVacation(){
            const bodyFormData = new FormData();
            for (const key in this.national) {
                const value = this.national[key];
                bodyFormData.set(key, value);
            }
            addNewNational(bodyFormData).then(response=>{
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        getVacationsType(){
            GetAllVacatonType().then(response=>{
                this.vacationTypes = response.data
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        onPageChange(page) {
                // this.page = page
                // this.$router.replace({ name: "logs", params: {page: page} })
                // this.getData()
            },
        fn_edit(value) {
            console.log(value);
            console.log(this.edit[value]);
            if (this.edit[value] == true) {
                const bodyFormData = new FormData();
                for (const key in this.HrSettings) {
                    const value = this.HrSettings[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('weeks[]',JSON.stringify(this.SelectDay))
                updateHrSettings(bodyFormData).then(response=>{
                    console.log('lead update success')
                    this.$toast.open({
                        message: 'Vote is deleted now!',
                        position: 'is-bottom',
                        type: 'is-success'
                    })
                    this.isLoading = false
                    // window.location.reload()
                    getData()
                }).catch(error => {
                    console.log(error)
                })
            }
            this.edit[value] = !this.edit[value];
        },
        UpdateEmployeeSalary(){
            const bodyFormData = new FormData();
            for (const key in this.GroosSalary) {
                const value = this.GroosSalary[key];
                bodyFormData.set(key, value);
            }
            UpdateGroosSalary(bodyFormData).then(response=>{
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        updateEmployeeDeduction(){
            const bodyFormData = new FormData();
            for (const key in this.Deduction) {
                const value = this.Deduction[key];
                bodyFormData.set(key, value);
            }
            employeeDeductionUpdate(bodyFormData).then(response=>{
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        }
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
