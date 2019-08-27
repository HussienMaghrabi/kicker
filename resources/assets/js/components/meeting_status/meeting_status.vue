<template>

<div class="parent">
  
     <section class="table">
           <section class ="add">
        <button class="button is-primary is-medium"
        
            @click="toggleModal">
            Add
        </button>

    </section>
    <div style="clear:both"> </div>
       <h1 style="display:inline" class="title"> meeting status</h1>
         <b-field class="search" label="Search">
             <b-input @input="filterMeetingStatus" v-model="search_query" type="text" class="inputSearch"></b-input>
        </b-field> 
        <div style="clear:both"> </div>

        <b-table
            :data="meetingStatus"
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

                <b-table-column class="padding" field="user.name" label="English Name" sortable>
                    {{ props.row.name }}
                </b-table-column>
                 <b-table-column class="padding" field="user.name" label="Has Next Action" sortable>
                    {{ props.row.has_next_action }} 
                </b-table-column>



                 

                 
                 
               <b-table-column class="padding" field="" label="show" sortable >
                        <button class="button is-primary is-medium">
                            <router-link style="color:white" :to="'/admin/vue/showMeetingStatus/'+props.row.id"> show  </router-link>
                         </button>
                </b-table-column>

                <b-table-column class="padding btn_edit" field="user.user_id" label="update" sortable>
                     <button class="button  is-medium ">
                            update  
                    </button>
                </b-table-column>


                <b-table-column class="padding btn_delete" field="user.user_id" label="delete" sortable>
                   <b-button class=" button is-medium" type="is-danger" @click="DeleteFromIndex(props.row.id)">
                            Delete  
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
        <!-- <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div> -->
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </section>
    <b-modal :active.sync="addMeetingModel">
        <div class="modal-card" >
            <header class="modal-card-head">
                <p class="modal-card-title">meeting status</p>
            </header>
            <section class="modal-card-body">
                
                <b-field label=" Name">
                    <b-input 
                            v-model="name"
                        type="text"
                        :value="name"
                        placeholder=" name"
                        required>
                    </b-input>
                </b-field>

                <div class="field">
                    <b-switch  v-model="has_next_action">Has Next Action</b-switch>
                </div>
                
            </section>
            <footer class="modal-card-foot">
                
                <b-button @click="addMeetingStatus" type="is-info">Submit</b-button>
            </footer>
        </div>
    </b-modal>
</div>     
    
</template>
<script>
    import {getMeetingStatus,deleteThisMeetingStatus,filterMeetingStatus,addMeetingStatus} from './../../calls'
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
                meetingStatus: [],
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
                isComponentModalActive: false,
                 formProps: {
                     name:'',
                    email: '',
                    password: ''
                },
                isComponentModalActive: false,
                search_query: '',
                addMeetingModel: false
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
         toggleModal(){
             this.addMeetingModel = !this.addMeetingModel
         },
         getData(){
            this.isLoading = true
                getMeetingStatus(this.page).then(response=>{
                console.log("TEST",response)
                this.perPage = response.data.per_page
                this.meetingStatus = response.data
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
               this.isLoading = false
        },

          DeleteFromIndex(id) {
            this.$dialog.confirm({
                title: 'Deleting ',
                message: 'Are you sure you want to <b>delete</b> DELETE?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteMeetingStatus(id)
            })
        },
        deleteMeetingStatus(id){
            deleteThisMeetingStatus(id).then(response=>{
                this.success('Deleted')
                this.isLoading = true
                this.getData()
            })
            .catch(error => {
                this.errorDialog('Are you sure you want to <b>delete</b> Meeting Status?')
                console.log(error)
            })
        },
          errorDialog(msg) {
                this.$dialog.alert({
                    title: 'Error',
                    message: msg,
                    type: 'is-danger',
                })
        },
        success(action) {
            this.$toast.open({
                message: 'Meeting Status '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        filterMeetingStatus(){
        var data ={
             'id':this.ID,
            'name':this.name,
            'has_next_action':this.has_next_action,
            'searchInput':this.search_query,
            '_token':this.token,
        };
        filterMeetingStatus(data).then(response=>{
            this.meetingStatus = response.data
        })
    .catch(error => {
        console.log(error)
        })
    },

    addMeetingStatus(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'has_next_action':this.has_next_action
        };
        console.log(data)
        addMeetingStatus(data).then(response=>{
            if(response.status == 200){
                this.success("Added")
                $(location).attr('href', '/admin/vue/meeting_status')
            }
            else{
                this.errorDialog('Please Check Your Inputs!')
            }
        })
        .catch(error => {
                this.errorDialog('Please Check YOur Inputs!')
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
   margin-right: 50px;
   margin-top: 20px;
}
.padding
{
width:496.01px;
}
.width
{
    width: 400px;
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
.parent
{
    background-color:white;
    margin-right: 20px;
    margin-left: 20px;
}
</style>

