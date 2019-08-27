<template>
    <section class="container">
        <b style="margin-left:1%;">Admin Application</b><hr>
        <b-tabs v-model="activeTab">
            <b-tab-item label="Under Review">

                <div class="add">
                    <button name="add" class="btnAdd">Add</button><br>
                    <div class="search">
                        <label>Search: </label>
                        <input type="text" class="inputSearch">
                    </div>
                </div>

            <b-table
                :data="underReview"
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

                    <b-table-column class="width" field="title" label="LinkedIn" sortable>
                        {{ props.row.linkedin }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="Cv" sortable>
                        {{ props.row.cv }}
                    </b-table-column>


                    <b-table-column label="Show">
                    <b-button type="is-info">                                     
                            <!-- <router-link :to="'/admin/vue/competitors_Show/'+props.row.id" style="color:#fff;"> -->
                                Show
                            <!-- </router-link> -->
                    </b-button>
                    </b-table-column>


                    <b-table-column label="Update">
                        <b-button type="is-warning">
                            
                            <!-- <router-link :to="'/admin/vue/addApplication/'+props.row.id" style="color:#000;"> -->
                                Update
                            <!-- </router-link> -->
                            
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

            </b-tab-item>

            <!-- ####################################################### -->

            <b-tab-item label="Shortlisted" @click="getDataShort" >
                 <div class="add">
                    <button name="add" class="btnAdd">Add</button><br>
                    <div class="search">
                        <label>Search: </label>
                        <input type="text" class="inputSearch">
                    </div>
                </div>

            <b-table
                :data="shortListed"
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

                    <b-table-column class="width" field="title" label="LinkedIn" sortable>
                        {{ props.row.linkedin }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="Cv" sortable>
                        {{ props.row.cv }}
                    </b-table-column>


                    <b-table-column label="Show">
                    <b-button type="is-info">                                     
                            <!-- <router-link :to="'/admin/vue/competitors_Show/'+props.row.id" style="color:#fff;"> !-->
                                Show
                            <!-- </router-link> !-->
                    </b-button>
                    </b-table-column>


                    <b-table-column label="Update">
                        <b-button type="is-warning">
                             
                            <!-- <router-link :to="'/admin/vue/addApplication/'+props.row.id" style="color:#000;"> -->
                                Update
                            <!-- </router-link> -->
                            
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

            </b-tab-item>

                 <!-- #######################################################

<!-- 
             <b-tab-item label="Accepted">
                <div class="add">
                    <button name="add" class="btnAdd">Add</button><br>
                    <div class="search">
                        <label>Search: </label>
                        <input type="text" class="inputSearch">
                    </div>
                </div>

            <b-table
                :data="actionLogs"
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
                        {{ props.row.id }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="LinkedIn" sortable>
                        {{ props.row.title }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="Cv" sortable>
                        {{ props.row.title }}
                    </b-table-column>


                    <b-table-column label="Show">
                    <b-button type="is-info">                                     
                            <!-- <router-link :to="'/admin/vue/competitors_Show/'+props.row.id" style="color:#fff;"> -->
                                <!-- Show
                            <!-- </router-link> -->
                    <!-- </b-button>
                    </b-table-column>  -->


                    <!-- <b-table-column label="Update">
                        <b-button type="is-warning"> -->
                            
                            <!-- <router-link :to="'/admin/vue/addApplication/'+props.row.id" style="color:#000;"> -->
                                <!-- Update -->
                            <!-- </router-link> -->
                            
                        <!-- </b-button>
                    </b-table-column>

                    <b-table-column label="Delete" >
                    <b-button type="is-danger" @click="DeleteFromIndex(props.row.id)">Delete</b-button>
                    </b-table-column> -->

                <!-- </template>


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
            </b-tab-item> -->

                 <!-- ####################################################### -->
<!-- 
             <b-tab-item label="Proposed">
                 <div class="add">
                    <button name="add" class="btnAdd">Add</button><br>
                    <div class="search">
                        <label>Search: </label>
                        <input type="text" class="inputSearch">
                    </div>
                </div>

            <b-table
                :data="actionLogs"
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
                        {{ props.row.id }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="LinkedIn" sortable>
                        {{ props.row.title }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="Cv" sortable>
                        {{ props.row.title }}
                    </b-table-column>


                    <b-table-column label="Show">
                    <b-button type="is-info">                                      -->
                            <!-- <router-link :to="'/admin/vue/competitors_Show/'+props.row.id" style="color:#fff;"> -->
                                <!-- Show -->
                            <!-- </router-link> -->
                    <!-- </b-button>
                    </b-table-column>


                    <b-table-column label="Update">
                        <b-button type="is-warning">
                            
                            <!-- <router-link :to="'/admin/vue/addApplication/'+props.row.id" style="color:#000;"> -->
                                <!-- Update -->
                            <!-- </router-link> -->
<!--                             
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
            </b-tab-item> --> 

                 <!-- ####################################################### -->

             <!-- <b-tab-item label="Rejected">
                 <div class="add">
                    <button name="add" class="btnAdd">Add</button><br>
                    <div class="search">
                        <label>Search: </label>
                        <input type="text" class="inputSearch">
                    </div>
                </div>

            <b-table
                :data="actionLogs"
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
                        {{ props.row.id }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="LinkedIn" sortable>
                        {{ props.row.title }}
                    </b-table-column>

                    <b-table-column class="width" field="title" label="Cv" sortable>
                        {{ props.row.title }}
                    </b-table-column>


                    <b-table-column label="Show">
                    <b-button type="is-info">                                      -->
                            <!-- <router-link :to="'/admin/vue/competitors_Show/'+props.row.id" style="color:#fff;"> -->
                                <!-- Show -->
                            <!-- </router-link> -->
                    <!-- </b-button>
                    </b-table-column>


                    <b-table-column label="Update">
                        <b-button type="is-warning">
                            
                            <!-- <router-link :to="'/admin/vue/addApplication/'+props.row.id" style="color:#000;"> -->
                                <!-- Update -->
                            <!-- </router-link> -->
                            
                        <!-- </b-button>
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
            </b-tab-item> -->
                            <!-- ####################################################### -->

        </b-tabs>
    </section>
</template>

<style>
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
  .container{
      background-color: #fff;
  }
</style>

<script>

// import vacancy from './vacancy.vue'
import {getUnderReview,getShortListed,showVacancy} from './../../calls'
export default {
    data() {
            return {
                activeTab: 0,
                showBooks: false,
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
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
                underReview: [],
                shortListed:[],
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               isComponentModalActive: false,
               vacancy:{},
               jobTitle: ''
            }
        },
        mounted() {
            this.getDataShort()
            this.getVacancyData()
        },
        components: {
        //   'vacancy' : vacancy 
        },
        created() {
        this.id = this.$route.params.id,
          this.$router.replace({hash: '#/1'});
        },
        methods:{
            getVacancyData(){
            this.isLoading = true
                showVacancy(this.id).then(response=>{
                    console.log(response)
                    this.vacancy = response.data.vacancy
                    this.jobTitle = response.data.JobTitle
                    this.getData(this.jobTitle)
                    this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
        getData(jobtitle){
            this.isLoading = true
            getUnderReview(this.jobTitle).then(response=>{
            console.log("under reviewww",this.jobTitle)
            this.perPage = response.data.per_page
            this.underReview = response.data.data
            this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            this.logsTotalNumber = response.data.total
            this.total = response.data.total
            
            if(this.underReview.length == 0){
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
                // onConfirm: () => this.deleteThisResale(id)
            })
        },
    getDataShort(){
        this.isLoading = true
        getShortListed(this.page).then(response=>{
        console.log("TEST",response)
        // this.perPage = response.data.per_page
        this.shortListed = response.data
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
        }).catch(error => {
        console.log(error)
    })
    },
  }
}
</script>