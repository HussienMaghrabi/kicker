<template>
<section class="container apps">

    <sidebarmenu></sidebarmenu>
    <b>Salaries Details</b><hr>

    <div class="add">
        <div class="search">
            <label style="padding: 10px;">Search: </label>
            <input type="text" class="inputSearch">
        </div>
    </div>

     
        <!-- <b-table
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
              
                <b-table-column class="width" field="id" label="Image" sortable>
                    {{ props.row.id }}
                </b-table-column>
              
                <b-table-column class="width" field="title" label="ID" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Name" sortable>
                    {{ props.row.title }}
                </b-table-column>
                
                <b-table-column class="width" field="title" label="Allowances" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Deduction" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Status" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Order By" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Details" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Ordered Time" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Full Salary" sortable>
                    {{ props.row.title }}
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

        </b-table> -->


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
import {action_logs} from './../../calls'
export default {
    data() {
            return {
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
            this.$router.replace({hash: '#/1'});
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
                    // onConfirm: () => this.deleteThisResale(id)
                })
            },
        },
}
</script>