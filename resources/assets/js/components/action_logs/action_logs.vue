<template>

<div class="parent">

     <section class="table">
         
       <h1 style="display:inline" class="title"> Action Logs</h1>
        <b-field class="search" label="Search">
            <b-input ></b-input>
        </b-field> 
        <div style="clear:both"> </div>

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
              
                <b-table-column  label="ID" sortable>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column label="Route" sortable>
                    {{ props.row.route }}
                </b-table-column>
              
                <b-table-column label="Title" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column label="Type" sortable>
                    {{ props.row.type }}
                </b-table-column>

                <b-table-column label="Agent" sortable>
                    {{ props.row.agent }}
                </b-table-column>
                
                <b-table-column label="Date" sortable>
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column label="Show">
                    <b-button type="is-info" >
                            <router-link style="color:white" :to="'/admin/vue/ShowActionLogs/'+props.row.id"> Show</router-link>           
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
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </section>
</div>     
    
</template>
<script>

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
                 page: 1,
                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               
            }
        },
        mounted() {
            this.getData()
        },
        components: {
            
              
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
         methods: {
         getData(){
            this.isLoading = true
                action_logs(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.actionLogs = response.data.data
                this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.logsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.actionLogs.length == 0){
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
                this.page = page
                this.$router.replace({ name: "logs", params: {page: page} })
                this.getData()
            },
        }
}
</script>
<style>
.title
{
    font-size: 24px;
    font-weight: bold;
    margin: 20px;
    margin-left: 30px;
}
.table
{
    margin-left: 30px;
    margin-right: 50px;
}
.search
{
    width: 10%;
    float: right;
    margin-right: 50px;
    margin-bottom: 0px;

}
.parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
}
</style>