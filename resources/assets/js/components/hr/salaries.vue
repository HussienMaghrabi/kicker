<template>
<section class="container apps">

    <sidebarmenu></sidebarmenu>
    <b>Salary</b><hr>

<div class="columns is-12" style="display:inline-flex;">
     <div class="field column is-6">
         <b>From Date:</b>
         <b-input type="date"></b-input>
    </div>
    <div class="field column is-6">
        <b>To Date:</b>
        <b-input type="date"></b-input>
    </div>
</div>


<div class="columns is-12" style="display:inline-flex;margin-bottom:2%;"> 
     <div class="field column is-3">
            <b-checkbox>Select All</b-checkbox>
    </div>
    <div class="field column is-3">
       <b-button type="is-light"> 
        <i class="fa fa-search"></i> Filter
       </b-button>
    </div>
</div>

    <div class="add">
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterSalaries" v-model="search_query" type="text" class="inputSearch"></b-input>
        </div>
    </div>

     
        <b-table
            :data="salaries"
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
              
                <b-table-column class="width" field="title" label="ID" sortable>
                    {{ props.row.employee_id }}
                </b-table-column>

                 <b-table-column class="width" field="title" label="Paid Dt" sortable>
                    {{ props.row.title }}
                </b-table-column>

                 <b-table-column class="width" field="title" label="Name" sortable>
                    {{ props.row.title }}
                </b-table-column>
                 
                <b-table-column class="width" field="title" label="Basic Salary" sortable>
                    {{ props.row.basic }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Gross Salary" sortable>
                    {{ props.row.gross }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Net Salary" sortable>
                    {{ props.row.net }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Full Salary" sortable>
                    {{ props.row.full_salary }}
                </b-table-column>

                <b-table-column label="Update">
                    <b-button type="is-warning">
                        
                         <router-link :to="'/admin/vue/editSalary/'+props.row.id" style="color:#000;">
                            Update
                        </router-link>
                        
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

          <table class="table table-bordered">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Total</th>
                                    <td></td>
                                    <td></td>
                                    <td>{{basic}}</td>
                                    <td>{{gross}}</td>
                                    <td>{{net}}</td>
                                    <td>{{full}}</td>
                                </tr>
                            </tbody>
                    </table>


        <div class="leads-number">{{logsCurrentNumber + ' / ' + logsTotalNumber}}</div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading><br>
        <b-button type="is-info">Salary Slip</b-button>


      </section>
</template>

<style>
.button.is-info
{
    margin-left: 45%;
}
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
import sidebarmenu from './sidebarmenu'
import {getAllSalaries,filterSalaries} from './../../calls'
export default {
    data() {
            return {
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                salaries: [],
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
               basic:null,
               gross:null,
               net:null,
               full:null,
            }
        },
        mounted() {
            this.getData()
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
                getAllSalaries(this.page).then(response=>{
                console.log("salaaaaaries",response)
                // this.perPage = response.data.per_page
                this.basic = response.data.basic
                this.gross = response.data.gross
                this.net = response.data.net
                this.full = response.data.full
                this.salaries = response.data.salaries
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
    filterSalaries(){
    var data ={
        'searchInput':this.search_query,
        '_token':this.token,
    };
    filterSalaries(data).then(response=>{
        this.salaries = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },
 }
}
</script>