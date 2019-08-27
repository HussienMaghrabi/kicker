<template>

<div class="parent">
     <section class="table">
      
     <section class ="add">
        <router-link to="/admin/vue/createAgent" class="button is-primary is-medium">Add</router-link>
         
        <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <modal-form v-bind="formProps"></modal-form>
        </b-modal>
    </section>
    <div style="clear:both"> </div>
       <h1 style="display:inline" class="title"> All agents</h1>
         <b-field class="search" label="Search">
            <b-input @input="filterAgents" v-model="search_query"></b-input>
        </b-field> 
        <div style="clear:both"> </div>

        <b-table
            :data="agents"
            :paginated="isPaginated"
            :per-page="perPage"
            :current-page.sync="currentPage"
            :pagination-simple="isPaginationSimple"
            :pagination-position="paginationPosition"
            :default-sort-direction="defaultSortDirection"
            default-sort="user.first_name"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">

            <template slot-scope="props">
                <b-table-column style="float:left;" field="id" label="ID" width="40" sortable numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column class="width" field="user.name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>

                 <b-table-column class="width" field="user.email" label="E-mail" sortable>
                    {{ props.row.email }}
                </b-table-column>

                 <b-table-column class="width" field="user.phone" label="phone" sortable>
                    {{ props.row.phone }}
                </b-table-column>
                 <b-table-column class="width" field="user.source_name" label="source name" sortable>
                    {{ props.row.source_name }}
                </b-table-column>

                 <b-table-column class="padding" field="" label="show" sortable >
                        <button class="button is-primary is-medium">
                            <router-link :to="'/admin/vue/agents/'+props.row.id" style="color:#fff;">
                                Show
                            </router-link>  
                         </button>
                     
                </b-table-column>

                <b-table-column class="padding btn_delete" field="user.user_id" label="delete" sortable>
                   <button class=" button is-medium" @click="deleteModalActive(props.row.id)">
                            Delete  
                    </button>
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
        <!-- <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div> -->
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </section>
</div>     
    
</template>
<script>
    import {allAgents,deleteAgent,filterAgents} from './../../calls'
      const ModalForm = {
        props: ['name','email', 'password',"password","phone"],
        template: `
            <div class="modal-card" >
                <header class="modal-card-head">
                    <p class="modal-card-title">Add agent</p>
                </header>
                <section class="modal-card-body">
                   <b-field label="Name">
                        <b-input
                            type="text"
                            :value="name"
                            placeholder="Your name"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="Email">
                        <b-input
                            type="email"
                            :value="email"
                            placeholder="Your email"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="Password">
                        <b-input
                            type="password"
                            :value="password"
                            password-reveal
                            placeholder="Your password"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="Email Password">
                        <b-input
                            type="password"
                            :value="password"
                            password-reveal
                            placeholder="Your Email password"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="phone">
                        <b-input
                            type="number"
                            :value="phone"
                           
                            placeholder="Your phone"
                            required>
                        </b-input>
                    </b-field>

                    <b-field
                        label="Agent type">
                        <b-select placeholder="Select a agent type" expanded>
                            <option value="flint">CEO</option>
                            <option value="silver">Sales director</option>
                            <option value="flint">property consultant</option>
                            <option value="silver"> sales property consultant</option>
                            <option value="flint">sales manager</option>
                        </b-select>
                   </b-field>
                       <b-field
                        label="Residential/Commercial">
                        <b-select placeholder="Residential/Commercial" expanded>
                            <option value="flint">Residential</option>
                              <option value="flint">Commercial</option>
                        </b-select>
                   </b-field>


                   <div class="field">
                        <b-switch v-model="isSwitchedCustom"
                            true-value="Yes"
                            false-value="No">
                           
                        </b-switch>
                  </div>

                   <b-field
                        label="Role">
                        <b-select placeholder="Role" expanded>
                            <option value="flint">Admin</option>
                       
                          
                   </b-field>

                    <b-field label="Image">
                        <b-input
                            type="file"
                            :value="image"
                           
                            placeholder="Your image"
                            required>
                        </b-input>
                    </b-field>


                    
                </section>
                <footer class="modal-card-foot">
                    
                    <button class="button is-primary">submit</button>
                </footer>
            </div>
        `
    }
export default {
    data() {
            return {
                isSwitched: false,
                isSwitchedCustom: 'Yes',
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                agents: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 10,
                isLoading: true,
                isFullPage: true,
                search_query: '',
                selectedagents: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
                isComponentModalActive: false,
                 formProps: {
                     name:'',
                    email: '',
                    password: ''
                }
              
            
                
            }
        },
        mounted() {
            this.getData()
        },
        components: {
            ModalForm
        },
        created() {
            this.$router.replace({hash: '#/1'});
         },
         methods: {
            filterAgents(){
                var data ={
                    'searchInput':this.search_query,
                    '_token':this.token,
                };
               filterAgents(data).then(response=>{
                   this.agents = response.data
               })
            .catch(error => {
                console.log(error)
            })
            },
            addAgent(){
            const bodyFormData = new FormData();
            for (const key in this.agent) {
                const value = this.agent[key];
                bodyFormData.set(key, value);
            }
            // bodyFormData.append("from_time", this.agent.from);
            // bodyFormData.append("to_time", this.agent.to);
            AddNewAgent(bodyFormData).then(response=>{
                console.log('eeee',response)

            }).catch(error => {
                console.log(error)
            })
            },
            getData(){
                this.isLoading = true
                    allAgents(this.page).then(response=>{
                    console.log("TEST",response)
                    this.perPage = response.data.per_page
                    this.agents = response.data.data
                    this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.leadsTotalNumber = response.data.total
                    this.total = response.data.total
                    
                    if(this.agents.length == 0){
                        this.isEmpty = true
                    }
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
            deleteModalActive(id) {
                console.log("dsajdalksjd")
                    this.$dialog.confirm({
                        title: 'Deleting ',
                        message: 'Are you sure you want to <b>delete</b> Agent?',
                        confirmText: 'Delete',
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm: () => this.deleteThisAgent(id)
                    })
            },
            deleteThisAgent(id){
                deleteAgent(id).then(response=>{
                    this.success('Deleted')
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
                    message: 'Please select the agents you want to delete first',
                    type: 'is-danger',
                })
            },
            success(action) {
                this.$toast.open({
                    message: 'Agent '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
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
.parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
}
.add
{
    float: right;
   margin-right: 60px;
   margin-top: 20px;
}
.width
{
    width: 300px;
}
.btn_edit .button
{
     background-color: #f39c12;
     color:white;
}
.btn_delete .button
{
  background-color: #d43f3a;
     color: white;
     
}
.search
{
    width: 10%;
    float: right;
    margin-right: 50px;
    margin-bottom: 0px;

}
</style>

