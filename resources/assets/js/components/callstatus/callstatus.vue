<template>

<div class="parent">
  
     <section class="table">
           <section class ="add">
        <button class="button is-primary is-medium">
           <router-link style="color:white" to="/admin/vue/addcallstatus"> Add </router-link>
        </button>

      
    </section>
    <div style="clear:both"> </div>
     
       <h1 style="display:inline" class="title">  Call Statuses </h1> 
       <b-field class="search" label="Search"> 
            <b-input @input="filterCallStatus" v-model="search_query" type="text" class="inputSearch"></b-input>  
        </b-field> 
        <div style="clear:both"> </div>
        <b-table
            :data="callstatus"

            
            paginated
            backend-pagination

            :current-page="page"
            :total="total"
            :per-page="perPage"
            @page-change="onPageChange"
            
            :default-sort-direction="defaultSortDirection"
            default-sort="user.first_name"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">

            <template slot-scope="props">
                <b-table-column field="id" label="ID"  sortable numeric style="margin-right:20px;">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column class="padding" field="callstatus.name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>
                <b-table-column class="padding" field="callstatus.name" label="Has Next Action" sortable>
                    {{ props.row.has_next_action }}
                </b-table-column>
                 <b-table-column class="padding" field="" label="show" sortable >
                        <button class="button is-primary is-medium">
                                <router-link style="color:white" :to="'/admin/vue/showcallstatus/'+props.row.id"> show  </router-link>
                         </button>
                      
                </b-table-column>

                <b-table-column class="padding btn_delete" field="user.user_id" label="delete" sortable>
                   <button @click="confirmDeleteBulk(props.row.id)" class=" button is-medium">
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
    import {callstatus,deleteThisCallStatus,filterCallStatus} from './../../calls'
      
export default {
    data() {
            return {
                ID: null,
                name: null,
                has_next_action: null,
                isSwitched: false,
                isSwitchedCustom: 'Yes',
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                callstatus: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 10,
                isLoading: true,
                isFullPage: true,

                selectedagents: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               items:[],
                
            }
        },
        mounted() {
            this.getData()
        },
        components: {
            
        },
        created() {
            this.$router.replace({hash: '#/1'});
            this.localData()
            this.callstatus = JSON.parse(localStorage.getItem('callstatus'))
         },
         methods: {
         getData(){
            this.isLoading = true
                callstatus(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.callstatus = response.data.data
                this.localData()
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.callstatus.length == 0){
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
        deleteCallStatus(id){
            console.log('this id',id)
                deleteThisCallStatus(id).then(response=>{
                    this.success('Deleted')
                    this.isLoading = true
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
        },

        confirmDeleteBulk(id) {
        this.$dialog.confirm({
            title: 'Deleting',
            message: 'Are you sure you want to <b>delete</b>  Call Status ?',
            confirmText: 'Delete Call Status',
            type: 'is-danger',
            hasIcon: true,
            onConfirm: () => this.deleteCallStatus(id)
          })
        },

        filterCallStatus(){
        var data ={
            'id':this.ID,
            'name':this.name,
            'has_next_action':this.has_next_action,
            'searchInput':this.search_query,
            '_token':this.token,
          };
        filterCallStatus(data).then(response=>{
            this.callstatus = response.data
        })
        .catch(error => {
            console.log(error)
            })
        },

        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Call Status  you want to delete first',
                    type: 'is-danger',
                })
            },
        success(action) {
            this.$toast.open({
                message: 'Call Status '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        localData(){
            let parsed = JSON.stringify(this.callstatus)
            localStorage.setItem('callstatus',parsed)
        }
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
   margin-top: 20px;
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
.parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
}
</style>

