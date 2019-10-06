<template>
<section class="container competitors">
    <b>Tasks</b><hr>
    <div class="add">
      <button name="add" class="btnAdd">
            
            <router-link :to="'/admin/vue/addTask'" style="color:#fff;"> 
                    Add
            </router-link>
      </button><br>
        <div class="search">
            <label>Search: </label>
            <b-input @input="filterTasks" v-model="search_query" type="text" class="inputSearch"></b-input>  
        </div>
    </div>

        <b-table
            :data="taskData"
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
              
                <b-table-column class="width" field="title" label="Agent" sortable>
                    {{ props.row.agent_id }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Date" sortable>
                    {{ props.row.due_date }}
                </b-table-column>

                <b-table-column class="width" field="title" label="Task Type" sortable>
                    {{ props.row.task_type}}
                </b-table-column>

                <b-table-column class="width" field="title" label="Status" sortable>
                    {{ props.row.status }}
                </b-table-column>

                
                <b-table-column label="Confirm" >
                   <b-button type="is-success" @click="confirmTask(props.row.id)">Confirm</b-button>
                </b-table-column>

                <b-table-column label="Show">
                  <b-button type="is-info">                                     
                         <router-link :to="'/admin/vue/tasks_Show/'+props.row.id" style="color:#fff;">
                            Show
                        </router-link>
                   </b-button>
                </b-table-column>


                <b-table-column label="Update">
                    <b-button type="is-warning" @click="openModal(props.row.id)">
                        
                         <!-- <router-link :to="'/admin/vue/addApplication/'+props.row.id" style="color:#000;"> -->
                            Update
                        <!-- </router-link> -->
                        
                    </b-button>

                     <b-modal :active.sync="isComponentModalActive" has-modal-card>
                        <div class="modal-card" style="width: auto">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Task</p>
                            </header>
                            <section class="modal-card-body">
                            <b-field label="Agent">
                                <b-select v-model="single_task.agent_id" expanded>
                                    <option v-for="agent in agents" :key="agent.id" :value="agent.id">{{ agent.name }}</option>
                                </b-select>
                            </b-field>

                            <b-field label="Leads">
                                 <b-select v-model="single_task.leads" expanded>
                                    <option v-for="lead in leads" :key="lead.id" :value="lead.id">{{ lead.first_name +' '+lead.last_name}}</option>
                                </b-select>
                            </b-field>

                            <b-field label="Select a date">
                                <b-datepicker
                                    :date-formatter="dateFormatterFrom"
                                    v-model="single_task.due_date"
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>

                            <b-field label="Task Type">
                                <b-select v-model="single_task.task_type" expanded>
                                    <option value="call">Call</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="others">Others</option>
                                </b-select>
                            </b-field>
                        
                            
                            <b-field label="Description">
                                <b-input v-model="single_task.description" type="textarea"></b-input>
                            </b-field>
                            
                            </section>
                            <footer class="modal-card-foot">
                                <button class="button" type="button" @click="isComponentModalActive = false">Close</button>
                                <b-button type="is-success" @click="UpdateTask(single_task.id)">Edit</b-button>
                            </footer>
                        </div>
                     </b-modal>

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
</style>

<script>
import {getTaskData,deleteThisTask,filterTasks,UpdateThisTask, confirmProp,getAllAgents,getAllLeads,getspecdata,confirmThisTask} from './../../calls'
const ModalForm = {
        template:`
    `
    }

    export default {
        components: {
        ModalForm,
    },
    data() {
        return {
                ID:null,
                agent_id:null,
                task:[],
                due_date:null,
                task_type:null,
                status:null,
                search_query: '',
                taskData:[],
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                actionLogs: [],
                selectedLogs: [],
                agents:[],
                leads:[],
                single_task:[],
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
                getTaskData(this.page).then(response=>{
                    // console.log(response)
                this.taskData = response.data.data
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
        getagents(){
            getAllAgents().then(response=>{
                // console.log('all respone',response)
                this.agents = response.data
                // console.log('All agents',this.agents)
            }).catch(error=>{
                console.log(error)
            })
        },
        getLeads(){
            getAllLeads().then(response=>{
                // console.log('all leads',response)
                this.leads = response.data
                // console.log('All leads',this.leads)
            }).catch(error=>{
                console.log(error)
            })
        }, 
        getrowdata(id){
            this.isLoading = true
            getspecdata(id).then(response=>{
                this.single_task = response.data
                this.isLoading = false
                console.log('sepec data',response)
            }).catch(error=>{
                console.log(error)
            });
        },
        openModal(id){
            this.getagents()
            this.getLeads()
            this.getrowdata(id)
            this.isComponentModalActive = true
        },
        onPageChange(page) {
                // this.page = page
                // this.$router.replace({ name: "logs", params: {page: page} })
                // this.getData()
            },

        dateFormatterFrom(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.single_task.due_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        deleteTask(id){
                deleteThisTask(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
        },
        filterTasks(){
            var data ={
                'id':this.ID,
                'agent_id':this.agent_id,
                'due_date':this.due_date,
                'task_type':this.task_type,
                'status':this.status,
                'searchInput':this.search_query,
                '_token':this.token,
            };
            filterTasks(data).then(response=>{
                this.taskData = response.data
            })
        .catch(error => {
            console.log(error)
            })
        },
        toggle(row) {
            this.$refs.table.toggleDetails(row)
        },
        // delete model 
        DeleteFromIndex(id) {
            this.$dialog.confirm({
                title: 'Deleting ',
                message: 'Are you sure you want to <b>delete</b> Task?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteTask(id)
            })
        },
        DeleteTask(id) {
            this.$dialog.confirm({
                title: 'Delete Lead Source ',
                message: 'Are you sure you want to <b>delete</b> +{props.row.agent}?',
                confirmText: 'Confirm',
                type: 'is-success',
                hasIcon: true,
                // onConfirm: () => this.deleteThisResale(id)
            })
        },
         errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Task you want to delete first',
                    type: 'is-danger',
                })
        },
        success(action) {
            this.$toast.open({
                message: 'Task '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        UpdateTask(id){
          const bodyFormData = new FormData();
          for (let key in this.single_task) {
                const value = this.single_task[key];
                bodyFormData.set(key, value);
            }
            bodyFormData.append('_method','put')
          UpdateThisTask(bodyFormData,id).then(response=>{
            console.log(response)
            this.isLoading = true
            this.getData()
            this.isComponentModalActive = false
          }).catch(error=>{
              console.log(error);
          }); 
        },
        confirmTask(id){
            confirmThisTask(id).then(response=>{
               console.log("CONFIRM",response)
               $(location).attr('href', '/admin/vue/task')
            }).catch(error=>{
                console.log(error)
            })
        }
         
    },
       
}
</script>