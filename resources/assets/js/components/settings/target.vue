<template>
<section class="container leads">
    <b>All Targets</b><hr>
    <div class="add">
        <button name="add" class="btnAdd">
            
            <router-link :to="'/admin/vue/addTarget'" style="color:#fff;"> 
                    Add
            </router-link>
        </button><br>
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterTarget" v-model="search_query" type="text" class="inputSearch"></b-input>
        </div>
    </div>

        <b-table
            :data="targetsData"
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
              
                <b-table-column class="width" field="title" label="Agent Type" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Month" sortable>
                    {{ props.row.month }}
                </b-table-column>

                <b-table-column label="Show">
                  <b-button type="is-info">                                     
                        <router-link :to="'/admin/vue/targetShow/'+props.row.id" style="color:#fff;"> 
                            Show
                        </router-link>
                   </b-button>
                </b-table-column>


                <b-table-column label="Update">
                    <b-button type="is-warning" @click="openModal(props.row.id)">
                            Update
                    </b-button>

                    
                     <!-- Model Update -->

                      <b-modal :active.sync="isComponentModalActive" has-modal-card>
                            <div class="modal-card" style="width: auto">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Edit Target</p>
                                </header>
                                <section class="modal-card-body">
                                    <b-field label="Agent Type">
                                        <b-select expanded v-model="targets.agent_type_id">
                                            <option v-for="agent_type in agents_type" :value="agent_type.id" >
                                                {{ agent_type.name }} 
                                            </option>
                                        </b-select>
                                    </b-field>

                                    <b-field label="Calls">
                                        <b-input type="number" v-model="targets.calls"></b-input>
                                    </b-field>

                                    <b-field label="Meetings">
                                        <b-input type="number" v-model="targets.meetings"></b-input>
                                    </b-field>
                                    
                                    <b-field label="Money">
                                        <b-input type="number" v-model="targets.money"></b-input>
                                    </b-field>

                                    <b-field label="Month">
                                        <b-input type="number" v-model="targets.month"></b-input>
                                    </b-field>

                                    <b-field label="Notes">
                                        <b-input type="textarea" v-model="targets.notes"></b-input>
                                    </b-field>
                                </section>
                           </div>
            
                            <footer class="modal-card-foot">
                                <button class="button" type="button" @click="isComponentModalActive = false">Close</button>
                                <b-button type="is-success" @click="UpdateTarget(targets.id)">Update</b-button>
                            </footer>
                        
                      </b-modal>

                     <!-- End Model -->

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
  .competitors{
      background-color: #fff;
      padding: 1% !important;
  }
  body{
      background-color: #ECF0F3;
  }
  .modal .animation-content {
    width:40%;
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
import {allTargets,deleteThisTarget,filterTarget,getTargetInputs, UpdateThisTarget,showTarget} from './../../calls'

    export default {
        components: {
    },
    data() {
        return {
                targets:{},
                agentType:null,
                month:null,
                search_query: '',
                targetsData:[],
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
                agents_type:[],
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
    getAgentTypeData(){
            this.isLoading = true
            getTargetInputs().then(response=>{
                console.log(response)
                this.agents_type = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    getRowData(id){
            this.isLoading = true
                showTarget(id).then(response=>{
                    console.log(response)
                this.targets = response.data
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
      getData(){
                this.isLoading = true
                allTargets(this.page).then(response=>{
                    console.log(response)
                this.targetsData = response.data.data
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
        DeleteFromIndex(id) {
                this.$dialog.confirm({
                    title: 'Deleting ',
                    message: 'Are you sure you want to <b>delete</b> Target?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteTarget(id)
                })
            },
        deleteTarget(id){
                deleteThisTarget(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
        },
        filterTarget(){
            var data ={
                'agent type':this.agentType,
                'month':this.month,
                'searchInput':this.search_query,
                '_token':this.token,
            };
            filterTarget(data).then(response=>{
                this.targetsData = response.data
            })
        .catch(error => {
            console.log(error)
          })
        },
        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Target you want to delete first',
                    type: 'is-danger',
                })
            },
        success(action) {
            this.$toast.open({
                message: 'Target '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
    openModal(id){
    this.getRowData(id)
    this.getAgentTypeData()
    this.isComponentModalActive = true;
    },
    UpdateTarget(id){
        const bodyFormData = new FormData();
        for (let key in this.targets) {
            const value = this.targets[key];
            bodyFormData.set(key, value);
    }
        bodyFormData.append('_method','put')
        UpdateThisTarget(bodyFormData,id).then(response=>{
            console.log("Update target",response)
            $(location).attr('href', '/admin/vue/target')
            this.isComponentModalActive = false
        }).catch(error=>{
            console.log(error);
        }); 
    }
    }   
}
</script>