<template>
<section class="container apps">

    <sidebarmenu></sidebarmenu>
      
    <b>Applications</b><hr>

<div class="column is-mobile is-12" style="display:inline-flex;margin-bottom:2%;">
    <div class="column is-4">
        <b-field label="Job Category">
                <b-select v-model="department_id" expanded>
                    <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.en_name }}</option>
                </b-select>
        </b-field> 
    </div>

     <div class="column is-4">
        <b-field label="Job Title">
            <b-select placeholder="Choose Options" expanded v-model="jobTitle">
                <option v-for="jobTitle in jobTitles" :value="jobTitle.id">
                    {{ jobTitle.en_name }}
                </option>
            </b-select>
        </b-field> 
    </div>

    <div class="column is-2">
        <div class="control" style="margin-top: 12%;">
            <b-button class="button is-success"  @click="filterApplications">Filter</b-button> 
         
        </div>
    </div>

</div>


    <div class="add">
        <button name="add" class="btnAdd">
            <router-link :to="'/admin/vue/addApplication'" style="color:#fff;"> 
                    Add
            </router-link>
        </button><br>
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterApps" v-model="search_query" type="text" class="inputSearch"></b-input>  
        </div>
    </div>

     
        <b-table
            :data="applications"
             bordered
            checkable
            narrowed
            hoverable

            paginated
            backend-pagination

            :current-page="page"
            :total="total"
            :per-page="perPage"
            @page-change="onPageChange"

            :checked-rows.sync="selectedLogs"
            :default-sort-direction="defaultSortDirection"
            default-sort="created_at"
            >


            <template slot-scope="props">
              
                <b-table-column class="width" field="id" label="Name" sortable>
                    {{ props.row.first_name }}
                </b-table-column>
              
                <b-table-column class="width" field="title" label="Department" sortable>
                    {{ props.row.department }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Status" sortable>
                    {{ props.row.acceptness }}
                </b-table-column>

                <b-table-column class="width" field="title" label="LinkedIn" sortable>
                    {{ props.row.linkedin }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Cv" sortable>
                    {{ props.row.cv }}
                </b-table-column>


                <b-table-column label="Show">
                  <b-button type="is-info">                                     
                       <router-link :to="'/admin/vue/showApplicaton/'+props.row.id" style="color:#fff;"> 
                            Show
                        </router-link> 
                   </b-button>
                </b-table-column>


                <b-table-column label="Update">
                    <b-button type="is-warning">
                        
                         <router-link :to="'/admin/vue/showApplicaton/'+props.row.id" style="color:#000;">
                            Update
                        </router-link>
                        
                    </b-button>
                </b-table-column>

                <b-table-column label="Delete" >
                   <b-button type="is-danger" @click="DeleteFromIndex(props.row.id)">Delete</b-button>
                </b-table-column>

            </template>


            <template slot="empty" v-if="!isLoading && isEmpty">
                        <section class="section">
                            <div class="content has-text-grey has-text-centered">
                                <p>
                                    <b-icon
                                    icon="emoticon-sad"
                                    size="is-large">
                                </b-icon>
                            </p>
                            <p>Nothing here.</p>
                        </div>
                    </section>
                    <hr>
            </template>

        </b-table>

        <div class="leads-number">{{logsCurrentNumber + ' / ' + logsTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>

      </section>
</template>

<style>
.navMenu a[data-v-7f183654]{
    background-color: #fff !important;
    color: #888;
}
.navMenu[data-v-7f183654]{
    background-color: #fff;
    margin-top: 3rem;
}
.table{
    width:100% ;
    margin-bottom:2%;
}
  .btnAdd{
    background-color: #00a65a;
    color: #fff;
    border: none;
    width: 50px;
    height: 30px;
    float: right;
    margin-bottom: 5PX;
  }
  .search{
      float: right;
  }
  .add{
   float: right;
  }
  .inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
  .apps{
      background-color: #fff;
      padding: 1% !important;
  }
  </style>

<script src="https://unpkg.com/@jeremyhamm/vue-slider"></script>
<script>

import Vue from 'vue'
import sidebarmenu from './sidebarmenu'

// filterSpecificDepartment
import {getAllApplications,getJobTitleInputs,getAllJobTitles,deleteThisApplication,filterApps,filterApplications} from './../../calls'
export default {
    data() {
            return {
                department_id:null,
                departments:[],
                jobTitle:null,
                jobTitles:[],
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                applications: [],
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
                search_query:'',
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               page:1,
               isComponentModalActive: false,
                filter: {},
        
            }
        },
        mounted() {
            this.getData()
            this.getDepartments()
            this.getjobtitles()
        },
        components: {
            'sidebarmenu': sidebarmenu
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
         methods:{
            getData(){
            this.isLoading = true
                getAllApplications(this.page).then(response=>{
                console.log("Applications",response)
                // this.perPage = response.data.per_page
                this.applications = response.data.data
                this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.logsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.applications.length == 0){
                    this.isEmpty = true
                }
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
        getDepartments(){
            getJobTitleInputs().then(response=>{
                // console.log('all respone',response)
                this.departments = response.data
                // console.log('All agents',this.agents)
            }).catch(error=>{
                console.log(error)
            })
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
        onPageChange(page) {
                // this.page = page
                // this.$router.replace({ name: "logs", params: {page: page} })
                // this.getData()
            },
        DeleteFromIndex(id) {
                this.$dialog.confirm({
                    title: 'Deleting ',
                    message: 'Are you sure you want to <b>delete</b> Application?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteApp(id)
                })
            },
        deleteApp(id){
                deleteThisApplication(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
        },
        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Application you want to delete first',
                    type: 'is-danger',
                })
        },
        success(action) {
            this.$toast.open({
                message: 'Application '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        filterApps(){
            var data ={
                'searchInput':this.search_query,
                '_token':this.token,
            };
            filterApps(data).then(response=>{
                this.applications = response.data
            })
        .catch(error => {
            console.log(error)
            })
        },
        filterApplications(){
                this.isLoading = true
                var data ={
                    '_token':this.token,
                    'department': this.department_id,    
                    'title': this.jobTitle,    
                };
                filterApplications(data).then(response=>{
                        console.log('filteer',response)
                        this.perPage = response.data.per_page
                        this.applications = response.data
                        // this.cilsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                        // this.cilsTotalNumber = response.data.total
                        this.total = response.data.total
                        // if(this.cils.length == 0){
                        //     this.isEmpty = true
                        // }
                        let currentTotal = response.data.total
                        if (response.data.total / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000
                        }
                        this.total = currentTotal                    
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
        
    },
}
</script>