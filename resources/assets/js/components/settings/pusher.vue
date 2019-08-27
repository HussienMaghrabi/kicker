<template>
<section class="container leads">
    <b>Pusher</b><hr>
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterPusher" v-model="search_query" type="text" class="inputSearch"></b-input>
        </div>

        <b-table
            :data="projectData"
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
              
                <b-table-column class="width" field="Name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column class="width" field="Location" label="Location On Map" sortable>
                    {{ props.row.location }}
                </b-table-column>

                <b-table-column class="width" field="Developer" label="Developer" sortable>
                    {{ props.row.developer }}
                </b-table-column>

                <b-table-column class="width" field="Updated" label="Admin Updated At" sortable>
                    {{ props.row.updated_at }}
                </b-table-column>

                 <b-table-column class="width" field="Operation" label="Admin Operation">
                   
                          <b-button type="is-info" @click="acceptPush(props.row.id)"> Accept
                              <!-- <router-link :to="'/admin/accept/'+props.row.id" style="color:#fff;">
                                    Accept
                              </router-link>  -->
                          </b-button>
                   
                          <b-button type="is-danger" @click="DeleteFromIndex(props.row.id)">Reject</b-button>
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
  .search{
      float: right;
  }
  .inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
  body{
      background-color: #ECF0F3;
  }
  .label
  {
      float: left;
  }
  .table{
    width:100% ;
    margin-bottom:2%;
}
.container{
    background-color: #fff;
    padding: 1%;
}


</style>

<script>
import {getProjects,rejectProject,filterPusher,deleteThisPush,acceptPushThisPusher} from './../../calls'

export default {
    components: {
},
data() {
    return {
            ID:null,
            Name:null,
            loctaion:null,
            developer:null,
            updated_at:null,
            search_query: '',
            projectData:[],
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

            selectedagent_type: [],
            token: window.auth_user.csrf,
            userType: window.auth_user.type,
            paginationPosition: 'bottom',
            currentPage: 1,
            isComponentModalActive: false
        }},
    mounted() {
        this.getData()
    },
    created() {
        this.$router.replace({hash: '#/1'});
        },
    methods: {
      getData(){
                this.isLoading = true
                getProjects(this.page).then(response=>{
                    console.log("pusher data",response)
                this.projectData = response.data.data
                this.perPage = response.data.per_page
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total
                this.total = response.data.total
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
                
                // if(this.allAgent_type.length == 0){
                //     this.isEmpty = true
                // }
                // let currentTotal = response.data.total
                // if (response.data.total / this.perPage > 1000) {
                //     currentTotal = this.perPage * 1000
                // }

                // this.total = currentTotal
                this.isLoading = false
        },
        onPageChange(page) {
                // this.page = page
                // this.$router.replace({ name: "logs", params: {page: page} })
                // this.getData()
            },
        filterPusher(){
            var data ={
                'id':this.ID,
                'name':this.Name,
                'loctaion':this.loctaion,
                'developer':this.developer,
                'updated_at':this.updated_at,
                'searchInput':this.search_query,
                '_token':this.token,
            };
            filterPusher(data).then(response=>{
                this.projectData = response.data
            })
        .catch(error => {
            console.log(error)
          })
        },
        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Project you want to delete first',
                    type: 'is-danger',
                })
        },
        success(action) {
            this.$toast.open({
                message: 'Project'+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        DeleteFromIndex(id) {
            this.$dialog.confirm({
                title: 'Deleting ',
                message: 'Are you sure you want to <b>delete</b> Push?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deletePush(id)
            })
        },
        deletePush(id){
                deleteThisPush(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
        },
        acceptPush(id){
            console.log(id)
          acceptPushThisPusher(id).then(response=>{
            console.log('accept',response)
             this.isLoading = true
             this.getData()
          }).catch(error=>{
              console.log(error)
          })

          
        }
        // rejectPush(id){
        //     rejectThisPush(id).then(response=>{
        //       console.log("Pusher",response)
        //       $(location).attr('href', '/admin/vue/pusher')
        //     }).catch(error=>{
        //         console.log(error)
        //     })
        // }
    }
}
</script>