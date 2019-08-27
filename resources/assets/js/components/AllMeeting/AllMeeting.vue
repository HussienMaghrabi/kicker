<template>

<div class="parent">
    
     <section class ="add">
        <button class="button is-primary is-medium">  
            <router-link style="color:white" to="/admin/vue/AddMeeting">   Add  </router-link>
             </button>

    </section>
    <div style="clear:both"> </div>
     
       <h1 style="display:inline" class="title"> All Meeting</h1> 
       <b-field class="search" label="Search">
            <b-input @input="filterMeeting" v-model="search_query" type="text" ></b-input>
        </b-field> 
        <div style="clear:both"> </div>
  
     <section class="table">
      

        <b-table
            :data="Meeting"
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
                <b-table-column  label="ID" width="40" sortable numeric style="float:left;">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column class="padding"  label="Lead" sortable>
                    {{ props.row.lead }}
                </b-table-column>
                 <b-table-column class="padding"  label="Agent" sortable>
                    {{ props.row.agent }}
                </b-table-column>
                
                 <b-table-column class="padding"  label="Date" sortable>
                    {{ props.row.date }}
                </b-table-column>
                
                 <b-table-column class="padding"  label="Time" sortable>
                    {{ props.row.time }}
                </b-table-column>
                 <b-table-column class="padding"  label="Location On Map" sortable>
                    {{ props.row.location }}
                </b-table-column>
                
                

                 
                 <b-table-column class="padding" field="" label="show" sortable >
           
                    <button class="button is-primary is-medium">   
                        <router-link style="color:white" :to="'/admin/vue/ShowMeeting/'+props.row.id"> Show</router-link>  
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
</div>     
    
</template>
<script>
    import {deleteMeeting,Meeting,filterMeeting} from './../../calls'
     
export default {
    data() {
            return {
                isSwitched: false,
                isSwitchedCustom: 'Yes',
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                Meeting: {},
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 10,
                isLoading: true,
                isFullPage: true,

                selectedMeeting: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               search_query:'',
               search:'',
               agent:'',
               
            
            
                
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
                Meeting(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.Meeting = response.data.data
                this.agent = response.data.data.agent
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.Meeting.length == 0){
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
          deleteMeeting(id){
            console.log('this id',id)
                deleteMeeting(id).then(response=>{
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
                title: 'Deleting Meeting',
                message: 'Are you sure you want to <b>delete</b>  Meeting ?',
                confirmText: 'Delete Meeting',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteMeeting(id)
            })
        },
        errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please select the Meeting  you want to delete first',
                    type: 'is-danger',
                })
            },
        success(action) {
            this.$toast.open({
                message: 'Meeting '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
            // filterMeeting() {
            //     console.log('key up fillter');
            //     return this.Meeting.filter(option => {
            //         return option
            //             .toString()
            //             .toLowerCase()
            //             .indexOf(this.search.toLowerCase()) >= 0
            //     })
            // },
        filterMeeting(){
        var data ={
            'id':this.id,
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterMeeting(data).then(response=>{
            this.Meeting = response.data
            console.log('filter test',this.Meeting)
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

