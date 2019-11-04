<template>
<section class="apps container">           
      
    <sidebarmenu></sidebarmenu>

    <b>Upload Attendance File</b><hr>

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

    <b-field>
        <b-upload v-model="dropFiles"
            multiple
            drag-drop>
            <section class="section">
                <div class="content has-text-centered">
                    <p>
                        <b-icon
                            icon="upload"
                            size="is-large">
                        </b-icon>
                    </p>
                    <p>Upload File To Server</p>
                </div>
            </section>
        </b-upload>
    </b-field>

    <div id="app" class="column is-5" style="margin-top:10%;">
         <progress-bar size="large" bar-color="#dc720f" val="0" text="0%"></progress-bar>
    </div>
    
        <!-- <b-table
            :data="employees"
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
              

                <b-table-column class="width" field="id" label="ID" sortable>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column class="width" field="id" label="Name" sortable>
                    {{ props.row.en_first_name }}
                </b-table-column>

                <b-table-column class="width" field="id" label="Email" sortable>
                    {{ props.row.personal_mail }}
                </b-table-column>

                <b-table-column class="width" field="id" label="Phone" sortable>
                    {{ props.row.phone }}
                </b-table-column>

                <b-table-column class="width" field="id" label="Gender" sortable>
                    {{ props.row.gender }}
                </b-table-column>

                <b-table-column label="Show">
                  <b-button type="is-info">   
                       <i class="fas fa-users"></i>                                  
                        <router-link :to="'/admin/vue/profileEmployee/'+props.row.id" style="color:#fff;"> 
                            Profile
                        </router-link> 
                   </b-button>
                </b-table-column>


                <b-table-column label="Edit">
                    <b-button type="is-warning">
                         <i class="fas fa-edit"></i>
                         <router-link :to="'/admin/vue/editEmployee/'+props.row.id" style="color:#000;">
                            Edit
                        </router-link>
                        
                    </b-button>
                </b-table-column>

                <b-table-column label="Delete" >
                    
                   <b-button type="is-danger" @click="DeleteFromIndex(props.row.id)">
                      <i class="fas fa-minus-circle"></i> 
                          Delete
                   </b-button>
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
        
        <h5>Showing 1 to 1 of 1 entries</h5> -->
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
import ProgressBar from 'vue-simple-progress'

import {allEmployees,deleteThisEmployee,filterEmployees} from './../../calls'
export default {
    data() {
            return {
                file:null,
                dropFiles: [],
                id:null,
                name:null,
                mail:null,
                phone:null,
                gender:null,
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                employees: [],
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
            'sidebarmenu': sidebarmenu,
             file: null
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
         methods:{
            getData(){
            this.isLoading = true
                allEmployees(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.employees = response.data
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
        onPageChange(page) {
                // this.page = page
                // this.$router.replace({ name: "logs", params: {page: page} })
                // this.getData()
            },
    //     DeleteFromIndex(id) {
    //             this.$dialog.confirm({
    //                 title: 'Deleting ',
    //                 message: 'Are you sure you want to <b>delete</b> Employee?',
    //                 confirmText: 'Delete',
    //                 type: 'is-danger',
    //                 hasIcon: true,
    //                 onConfirm: () => this.deleteEmployee(id)
    //             })
    //         },

    //     deleteEmployee(id){
    //             deleteThisEmployee(id).then(response=>{
    //                 this.success('Deleted')
    //                 this.isLoading = true
    //                 this.getData()
    //             })
    //             .catch(error => {
    //                 this.errorDialog()
    //                 console.log(error)
    //             })
    //     },

    //     errorDialog() {
    //             this.$dialog.alert({
    //                 title: 'Error',
    //                 message: 'Please select the employee you want to delete first',
    //                 type: 'is-danger',
    //             })
    //         },
    //     success(action) {
    //         this.$toast.open({
    //             message: 'Employee'+action+' Successfully',
    //             type: 'is-success',
    //             position: 'is-bottom',
    //             duration: 5000,
    //         })
    //     },

    //     filterEmployees(){
    //     var data ={
    //         'id':this.id,
    //         'name':this.name,
    //         'mail':this.mail,
    //         'phone':this.phone,
    //         'gender':this.gender,
    //         'searchInput':this.search_query,
    //         '_token':this.token,
    //     };
    //     filterEmployees(data).then(response=>{
    //         this.employees = response.data
    //     })
    // .catch(error => {
    //     console.log(error)
    //     })
    // },

    deleteDropFile(index) {
       this.dropFiles.splice(index, 1)
    }
 },
}
</script>
