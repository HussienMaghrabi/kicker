<template>
    <section >
<div >
        <div class="card ">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title title">
                           All Requests
                        </p>
                        <div style="clear:both"> </div>
            
                 <section class ="add">
                    <button class="button is-primary is-medium">  
                    <router-link style="color:white" to="/admin/vue/AddMeRequest">   Add  </router-link>
                    </button>

                </section>
                    <div style="clear:both"> </div>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <div class="parent"> 
                <!-- tap meeeeeeeeeeeeeee -->
                <b-tabs class="tabbs" v-model="activeTab">
                    <b-tab-item label="Me">
                    <b-field class="search" label="Search">
                            <b-input @input="filterRequest" v-model="search_query" type="text" ></b-input>
                        </b-field> 
                
        
                <section class="table">
            

                <b-table
                    :data="requests"
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
                        <b-table-column  label="ID"  sortable numeric >
                            {{ props.row.id }}
                        </b-table-column>

                        <b-table-column class="padding"  label="Lead" sortable>
                            {{ props.row.first_name }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Type" sortable>
                            {{ props.row.unit_type }}
                        </b-table-column>
                        
                        <b-table-column class="padding"  label="Price From" sortable>
                            {{ props.row.price_from }}
                        </b-table-column>
                        
                        <b-table-column class="padding"  label="Price To" sortable>
                            {{ props.row.price_to }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Date Start" sortable>
                            {{ props.row.created_at }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Date End" sortable>
                            {{ props.row.date }}
                        </b-table-column>
                        
                        <b-table-column class="padding" field="" label="show" sortable >
                
                            <button class="button is-primary is-medium">   
                                <router-link style="color:white" :to="'/admin/vue/ShowMeRequest/'+props.row.id"> Show</router-link>  
                            </button>
                            
                        </b-table-column>

                        <b-table-column class="padding btn_delete"  label="delete" sortable>
                        <button @click="confirmDeleteBulk(props.row.id)" class=" button is-medium">   Delete    </button>
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

                    </b-tab-item>
                        <!-- end tap meeeeeeeeeeeeeeeeeeeeeee -->
                        <!-- tap teeeeeeeeeeeeeeeeeam -->
                    <b-tab-item label="Team">
                
                    <b-field class="search" label="Search">
                        <b-input @input="filterTeam" v-model="Team_search_query" type="text" ></b-input>
                    </b-field> 
                <div style="clear:both"> </div>
        
                <section class="table">
            

                <b-table
                    :data="Teamrequests"
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
                        <b-table-column  label="ID"  sortable numeric >
                            {{ props.row.id }}
                        </b-table-column>

                        <b-table-column class="padding"  label="Lead" sortable>
                            {{ props.row.first_name }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Agent" sortable>
                            {{ props.row.agent }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Type" sortable>
                            {{ props.row.unit_type }}
                        </b-table-column>
                        
                        <b-table-column class="padding"  label="Price From" sortable>
                            {{ props.row.price_from }}
                        </b-table-column>
                        
                        <b-table-column class="padding"  label="Price To" sortable>
                            {{ props.row.price_to }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Date Start" sortable>
                            {{ props.row.created_at }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Date End" sortable>
                            {{ props.row.date }}
                        </b-table-column>
                        
                        
                        

                        
                        <b-table-column class="padding" field="" label="show" sortable >
                
                            <button class="button is-primary is-medium">   
                                <router-link style="color:white" :to="'/admin/vue/ShowMeRequest/'+props.row.id"> Show</router-link>  
                            </button>
                            
                        </b-table-column>

                        <b-table-column class="padding btn_delete"  label="delete" sortable>
                        <button @click="confirmDeletTeam(props.row.id)" class=" button is-medium">   Delete    </button>
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
                    </b-tab-item>
                    <!-- end tap teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeam -->
                    <!-- tap request broadcaaaaaaaaaaaaaaaaaast -->
                    <b-tab-item label="Requests BroadCast">
                            
               
                    <b-field class="search" label="Search">
                        <b-input @input="filterBroadcast" v-model="Broadcast_search_query"  type="text" ></b-input>
                    </b-field> 
                <div style="clear:both"> </div>
        
                <section class="table">
            

                <b-table
                    :data="requestsBroadcast"
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
                        <b-table-column  label="ID"  sortable numeric >
                            {{ props.row.id }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Agent" sortable>
                            {{ props.row.name}}
                        </b-table-column>
                        <b-table-column class="padding"  label="Type" sortable>
                            {{ props.row.unit_type }}
                        </b-table-column>
                        
                        <b-table-column class="padding"  label="Price From" sortable>
                            {{ props.row.price_from }}
                        </b-table-column>
                        
                        <b-table-column class="padding"  label="Price To" sortable>
                            {{ props.row.price_to }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Date Start" sortable>
                            {{ props.row.created_at }}
                        </b-table-column>
                        <b-table-column class="padding"  label="Date End" sortable>
                            {{ props.row.date }}
                        </b-table-column>
                        
                        <b-table-column class="padding" field="" label="show" sortable >
                
                            <button class="button is-primary is-medium">   
                                <router-link style="color:white" :to="'/admin/vue/ShowMeRequest/'+props.row.id"> Show</router-link>  
                            </button>
                            
                        </b-table-column>

                        <b-table-column class="padding btn_delete"  label="delete" sortable>
                        <button @click="confirmDeletBroadcast(props.row.id)" class=" button is-medium">   Delete    </button>
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
                    </b-tab-item>

                    
                    <!-- end tap broadcaaaaaaaaaaaaaaaaaaast -->
                
                </b-tabs>
                </div>
            </div>
        </div>
</div>
    </section>
</template>


<script>
    import {requests,Teamrequests,requestsBroadcast,deleterequest,deleteTeam,deleteBroadcast,filterRequest,filterTeam,filterBroadcast} from './../../calls'
     
export default {
    data() {
            return {
                activeTab:0,
                isSwitched: false,
                isSwitchedCustom: 'Yes',
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                requests: {},
                Teamrequests:{},
                requestsBroadcast:[],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 10,
                isLoading: true,
                isFullPage: true,
                name:null,
                selecterequests: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               search_query:'',
               Team_search_query:'',
               Broadcast_search_query:'',
               
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
            this.isLoading = false
                requests(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.requests = response.data.myrequest.data
                 this.Teamrequests = response.data.teamRequests.data
                 this.requestsBroadcast = response.data.broadcastRequests.data
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.requests.length == 0){
                    this.isEmpty = true
                }
                 
                if(this.Teamrequests.length == 0){
                    this.isEmpty = true
                }
                if(this.requestsBroadcast.length == 0){
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
          deleterequest(id){
            console.log('this id',id)
                deleterequest(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
                this.getData()
        },
         deleteTeam(id){
            console.log('this id',id)
                deleteTeam(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
                this.getData()
        },
         deleteBroadcast(id){
            console.log('this id',id)
                deleteBroadcast(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
                this.getData()
        },
     
        confirmDeleteBulk(id) {
            this.$dialog.confirm({
                title: 'Deleting Request',
                message: 'Are you sure you want to <b>delete</b>  Request ?',
                confirmText: 'Delete Request',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleterequest(id)
            })
        },
         confirmDeletTeam(id) {
            this.$dialog.confirm({
                title: 'Deleting Request',
                message: 'Are you sure you want to <b>delete</b>  Request ?',
                confirmText: 'Delete Request',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteTeam(id)
            })
        },
        confirmDeletBroadcast(id) {
            this.$dialog.confirm({
                title: 'Deleting Request',
                message: 'Are you sure you want to <b>delete</b>  Request ?',
                confirmText: 'Delete Request',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteBroadcast(id)
            })
        },
        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Request  you want to delete first',
                    type: 'is-danger',
                })
            },
        success(action) {
            this.$toast.open({
                message: 'Request '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        filterRequest(){
        var data ={
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterRequest(data).then(response=>{
            this.requests = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },
    filterTeam(){
        var data ={
            'searchInput':this.Team_search_query,
            '_token':this.token,
        };
        filterTeam(data).then(response=>{
            console.log('team request',response.data)
            this.Teamrequests = response.data
            
        })
    .catch(error => {
        console.log(error)
        })
    },
       filterBroadcast(){
        var data ={
            'searchInput':this.Broadcast_search_query,
            '_token':this.token,
        };
        filterBroadcast(data).then(response=>{
            console.log('filter response',response)
            this.requestsBroadcast = response.data
        })
    .catch(error => {
        console.log(error)
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



.add
{
    float: right;
   margin-right: 60px;
}
.padding
{
width:496.01px;
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
.tabs li 
{
        margin-left: 50px;
}
.is-active
{
     font-weight: bold;
}
.tabs li.is-active a{
    color: black;
}
/* .parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
} */
.level 
{
    width: 100%;
}
.level-item 
{
    width: 100%;
}
</style>
