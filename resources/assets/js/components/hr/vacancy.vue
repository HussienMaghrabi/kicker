<template>
<section class="container apps">
  
    <sidebarmenu></sidebarmenu>
    <b>Vacancy</b><hr>

    <div class="add">
        <button name="add" class="btnAdd">
            <router-link :to="'/admin/vue/addVacancy'" style="color:#fff;"> 
                    Add
            </router-link>
        </button><br>
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterVacancy" v-model="search_query" type="text" class="inputSearch"></b-input>
        </div>
    </div>

     
        <b-table
            :data="vacancies"
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
                    {{ props.row.en_name }}
                </b-table-column>
              
                <b-table-column class="width" field="title" label="Job Title" sortable>
                    {{ props.row.jobTitle }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Applications" sortable>
                    {{ props.row.applications }} Applications <b-button type="is-light">
                        
                        <router-link :to="'/admin/vue/showApp/'+props.row.id"> 
                            Show
                        </router-link> 
                        
                        </b-button>
                </b-table-column>

                <b-table-column label="Show">
                  <b-button type="is-info">                                     
                        <router-link :to="'/admin/vue/showVacancy/'+props.row.id" style="color:#fff;"> 
                            Show
                        </router-link> 
                   </b-button>
                </b-table-column>


                <b-table-column label="Update">
                    <b-button type="is-warning">
                        
                         <router-link :to="'/admin/vue/editVacancy/'+props.row.id" style="color:#000;">
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
        
        <h5>Showing 1 to 1 of 1 entries</h5>
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

import sidebarmenu from './sidebarmenu'
import {allVacancies,deleteThisVacancy,filterVacancy} from './../../calls'
export default {
    data() {
            return {
                jobTitleName:null,
                vacancyName:null,
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                vacancies: [],
                selectedLogs: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page:1,
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
                allVacancies(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.vacancies = response.data.data
                this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.logsTotalNumber = response.data.total
                this.total = response.data.total
                
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
        DeleteFromIndex(id) {
                this.$dialog.confirm({
                    title: 'Deleting ',
                    message: 'Are you sure you want to <b>delete</b> Vacancy?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteVacancy(id)
                })
            },

        deleteVacancy(id){
                deleteThisVacancy(id).then(response=>{
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
                    message: 'Please select the Vacancy you want to delete first',
                    type: 'is-danger',
                })
            },
        success(action) {
            this.$toast.open({
                message: 'Vacancy'+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },

        filterVacancy(){
        var data ={
            'vacancyName':this.vacancyName,
            'jobTitle':this.jobTitleName,
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterVacancy(data).then(response=>{
            this.vacancies = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },

 },
}
</script>