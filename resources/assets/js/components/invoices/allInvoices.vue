<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="level mb-5">
            <div class="level">
                <div class="level-item">

                </div>
            </div>

            <div class="level">
                <div class="level-item filters">
                    <div class="field  mr-10">
                        <div class="control">
                            <input class="input is-meduim mt-10" type="text" placeholder="Search" v-model="searchInput" @input="search" style="width:70%;margin-bottom: 23px;">
                            <b-button type="is-info" style="margin-top:8px"><i class="fas fa-plus"></i>&nbsp
                                <router-link  :to="'/admin/vue/newInvoice'" style="color:#fff">
                                  New
                                </router-link>
                             </b-button>
                        </div>
                    </div>
                    
                </div>
            </div>

            </div>
                    <b-table
                    :data="leads"
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

                    :checked-rows.sync="selectedLeads"
                    :default-sort-direction="defaultSortDirection"
                    default-sort="created_at"
                    >

                    <template slot-scope="props">
                        <b-table-column  label="Proposed Company" sortable>
                             <router-link :to="'/admin/vue/showInvoice/'+props.row.id" style="color:#000"> 
                                      {{props.row.first_name+' '+props.row.last_name}}
                             </router-link>
                        </b-table-column>

                        <b-table-column label="Company" sortable>
                            <router-link :to="'/admin/vue/showInvoice/'+props.row.id" style="color:#000"> 
                                      {{props.row.first_name+' '+props.row.last_name}}
                            </router-link>
                           
                        </b-table-column>

                        <b-table-column label="Invoice Date" sortable>
                             <router-link :to="'/admin/vue/showInvoice/'+props.row.id" style="color:#000"> 
                                {{props.row.phone}}
                             </router-link>
                        </b-table-column>

                        <b-table-column  label="Subtotal" sortable>
                            <router-link :to="'/admin/vue/showInvoice/'+props.row.id" style="color:#000"> 
                              {{props.row.leadProbability}}
                            </router-link>
                        </b-table-column>

                        <b-table-column  label="Discount" sortable>
                            <router-link :to="'/admin/vue/showInvoice/'+props.row.id" style="color:#000">
                              {{props.row.first_name }}
                            </router-link>
                        </b-table-column>

                        <b-table-column  label="Total" sortable>
                            <router-link :to="'/admin/vue/showInvoice/'+props.row.id" style="color:#000">
                              {{props.row.first_name+' '+props.row.last_name}}
                            </router-link>
                        </b-table-column>
                   

                        <b-table-column  label="" sortable>
                            <i class="fas fa-envelope"></i>
                        </b-table-column>

                        <b-table-column sortable>
                           <i class="fas fa-trash-alt" style="cursor:pointer"></i>
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
            
            <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div>
             <div class="buttons">
                <b-button type="is-success"><i class="fas fa-envelope"></i>  Send Email</b-button>
                <b-button type="is-danger"><i class="fas fa-trash-alt"></i> Delete</b-button>
                <b-button type="is-info"><i class="fas fa-print"></i>  Print</b-button>
            </div>

            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>


    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
changeLeadFav
<script>
    import {autoSwitchAPi,getMyLeads,changeLeadFav,changeLeadHot,deleteLead,newLeadsFilter,getPublicData,switchLeads,getAgents,checkUserGroupAndRoles,searchForLead, getLeadSources, getLeadsByAgent, getBtns, addCall,bulkActions,deleteNoActionLeads} from './../../calls'
    import Multiselect from 'vue-multiselect'
    export default {
        data() {
            return {
                authType: '',
                call_status_id: null,
                dateFormatter: null,
                newCallData: {date: new Date()},
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                getLeadsByAgent: [],
                leadSources: [],
                leads: [],
                isEmpty: false,
                isLoading: true,
                hasMobileCards: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: 1,
                perPage: 100,

                isLoading: true,
                isFullPage: true,
                searchInput: '',
                selectedLeads: [],

                ShowHint: false,
                hintId: '',
                fav: '',
                hot:'',
                callStatus: [],
                projects: [],
                locations: [],
                meetingStatus:[],
                filter: {},
                startFilter: false,
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                role: window.auth_user.role,
                switchLeadModel: false,
                bulkActionModel: false,
                switchLeadData: {},
                leadsIds: [],
                commercialAgents: [],
                residentialAgents: [],
                permArray: [],
                reloadData: false,
                autoSwitchModel: false,
                autoSwitchData: {},
                deleteLeadsModal: false,
                flag: 0,
                tag_id: null,
                tags: [],
                selectedTags: [],
                tagIds : [],
                phoneIso: '',
                probability: '',
                project_id:null
            }
        },
        mounted() {
            this.authType = window.auth_user.type
            // this.checkUserHasGroup()
            // this.getCompanyAgents()
            this.getData()
        },
        components: {
            Multiselect
        },
        created() {
            this.$router.replace({hash: '#/1'});
            this.page = parseInt(this.$route.hash.split('/')[1])
            this.getSources()
         },
         methods: {
             refreshPage() {
                 if(Object.keys(this.filter).length < 1){
                     console.log('No Filters Detected')
                     this.getData();   
                 }else{
                     console.log('Filters Detected')
                     this.filterLeads();
                 }
             },
            checkClass(r){
                var path = this.$route.path.split('/');
                if(path[1] == r) return 'tabLinkActive'
                    else return 'tabLinkNotActive'
                },
            getLeadsfilter(){
                getBtns({
                  "user_id": this.userId,
                  "agent_id": " ",
              }).then(response=>{
                    this.getLeadsByAgent = response.data.btns
                })
              .catch(error => {
                console.log(error)
            })
          },

          getSources(){
            getLeadSources().then(response=>{
                    this.leadSources = response.data
                })
            .catch(error => {
                console.log(error)
            })
        },

        getData(loading = true){
            this.isLoading = loading
            getMyLeads(this.page).then(response=>{
                this.perPage = response.data.per_page
                this.leads = response.data.data
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total
                this.total = response.data.total
                
                if(this.leads.length == 0){
                    this.isEmpty = true
                }
                let currentTotal = response.data.total
                if (response.data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000
                }

                this.total = currentTotal
                this.isLoading = false
                this.getPublic()
                    //console.log(response.data)

                })
            .catch(error => {
                console.log(error)
            })
        },
        search(){
            if(this.searchInput){
                    //this.isLoading = true
                    var data ={
                        'searchInput':this.searchInput,
                        '_token':this.token,
                        'agent_id':this.userId,
                    };
                    searchForLead(data).then(response=>{
                        this.leads = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }  else if (this.searchInput.trim() === "") {
                    this.getData();
                }
            },
            filterLeads(scrollSwitch = false){
                this.isLoading = true
                this.fitlerFlag = true
                this.tagIds = []
                this.selectedTags.forEach(element => {
                    this.tagIds.push(element.id)
                });
                var data ={
                    'leadSources':this.filter.sourceId,
                    'location':this.filter.location,
                    'meetingStatus':this.filter.meeting_status_id,
                    'callStatus':this.filter.call_status_id,
                    'projects':this.filter.project_id,
                    'dateTo':this.parsedDateTo,
                    'dateFrom':this.parsedDateFrom,
                    '_token':this.token,
                    'agent_id':this.userId,
                    'tags':this.tagIds,
                    'phoneIso': this.phoneIso,
                    'probability': this.probability
                };
                newLeadsFilter(this.page, data).then(response=>{
                  console.log("asdsadad ", response.data.per_page);
                    this.perPage = response.data.per_page
                    this.leads = response.data.data;
                    this.leadsCurrentNumber = response.data.to;
                    this.leadsTotalNumber = response.data.total;
                    this.total = response.data.total;

                    if(this.leads.length == 0){
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
            bulkDeleteDialog(lead=0) {
                if(this.selectedLeads.length != 0){
                    this.confirmDeleteBulk()
                }else if(lead != 0){
                    this.selectedLeads.push(lead)
                    this.confirmDeleteBulk()

                }else{
                    this.errorDialog()
                }
            },

            bulkActionDialog(lead=0) {
                if(this.selectedLeads.length != 0){
                    this.bulkActionModel = true
                }else if(lead != 0){
                    this.selectedLeads.push(lead)
                    this.bulkActionModel = true

                }else{
                    this.errorDialog()
                }
            },
            bulkActionAction() {
                this.isLoading = true
                console.log(this.selectedLeads)
                this.selectedLeads.forEach(element => {
                    this.leadsIds.push(element.id)
                });

                // var data = {
                //     'agent_id':this.bulkActionData.rAgent,
                //     'commercial_agent_id':this.bulkActionData.cAgent,
                //     '_token':this.token,
                //     'leads':this.leadsIds,
                // }

                var data = {
                    "_token": this.token,
                    "user_id": this.userId,
                    'leads':this.leadsIds,
                    // "phone": '',
                    "call_status_id": this.call_status_id,
                    // "duration": this.newCallData.duration,
                    "date": this.newCallData.date,
                    "probability": this.newCallData.probability ? this.newCallData.probability : 'normal',
                    "description": this.newCallData.description,
                    // "to_do_type": this.newCallData.to_do_type,
                    // "to_do_due_date": this.newCallData.to_do_due_date,
                    // "to_do_description": this.newCallData.to_do_description,
                };

                bulkActions(data).then(response=>{
                    console.log(response)
                    if(response.data.status == 501){
                        this.error('Call')
                        this.isLoading = false
                    }else {
                    //this.isLoading = false
                    this.newCallData = {}
                    this.call_status_id = 0
                    this.getData()
                    this.success('Call')
                }
            })
                .catch(error => {
                    console.log(error)
                })
            },

            switchLeadDialog(lead=0) {
                console.log('this.selectedLeadsssssssssssss')
                console.log(this.selectedLeads)
                if(this.selectedLeads.length != 0){
                    this.switchLeadModel = true
                    console.log(this.residentialAgents);
                }else if(lead != 0){
                    this.selectedLeads.push(lead)
                    this.switchLeadModel = true

                }else{
                    this.errorDialog()
                }
            },
            switchLeadAction() {
                this.isLoading = true
                console.log(this.selectedLeads)
                this.selectedLeads.forEach(element => {
                    this.leadsIds.push(element.id)
                });

                var data = {
                    'agent_id':this.switchLeadData.rAgent,
                    'commercial_agent_id':this.switchLeadData.cAgent,
                    'leads':this.leadsIds,
                    '_token':this.token,
                }
                switchLeads(data).then(response=>{
                    console.log(response)
                    this.getData()
                    this.switchLeadModel = false
                    this.selectedLeads = []
                    this.leadsIds = []
                    this.success('Switched')
                })
                .catch(error => {
                    console.log(error)
                })
            },
            changeLeadStatus(type,id){
                if(type == 'fav'){
                    changeLeadFav({id:id}).then(response=>{
                        console.log(response)
                        this.getData()
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }else if (type == 'hot'){
                    changeLeadHot({id:id}).then(response=>{
                        console.log(response)
                        this.getData()
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
            leadActions(event,id){
                var action = event.target.value
                if(action == 'show') {window.location = "/admin/vue/showleadDetals/"+id;}
                else if(action == 'edit') {window.location = "/admin/leads/"+id+"/edit";}
                else if(action == 'delete') {
                    this.confirmDelete(id)
                }
            },
            confirmDelete(id) {
                this.$dialog.confirm({
                    title: 'Deleting Lead',
                    message: 'Are you sure you want to <b>delete</b> Lead?',
                    confirmText: 'Delete Lead',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteThisLead(id)
                })
            },
            deleteThisLead(id){
                this.isLoading = true
                deleteLead(id).then(response=>{
                    console.log(response)
                    this.getData()
                    this.success('Deleted')
                })
                .catch(error => {
                    console.log(error)
                })
            },
            confirmDeleteBulk() {
                this.$dialog.confirm({
                    title: 'Deleting Leads',
                    message: 'Are you sure you want to <b>delete</b> Bulk Leads ?',
                    confirmText: 'Delete Leads',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteBulkLead()
                })
            },
            deleteBulkLead(){
                this.selectedLeads.forEach((lead)=>{
                    this.deleteThisLead(lead.id)
                })
            },
            getPublic(){
                getPublicData().then(response=>{
                    console.log("public Data",response)
                    this.callStatus = response.data.callStatus
                    this.projects = response.data.projects
                    this.meetingStatus = response.data.meetingStatus
                    this.locations = response.data.locations
                    this.tags = response.data.tags
                })
                .catch(error => {
                    console.log(error)
                })
            },
            dateFormatterFrom(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            dateFormatterTo(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateTo = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            onPageChange(page) {
                this.page = page
                this.$router.replace({ name: "MyLeads", params: {page: page} })
                if(this.fitlerFlag){
                    this.filterLeads()
                }else {
                    this.getData()
                }
            },
            openHint(id, hot, fav){
                this.ShowHint = true
                this.hintId = id
                this.hot = hot
                this.fav = fav
                this.reloadData = true

                if(id == this.hintId)
                this.flag = Math.random();

                setInterval(function () {
                    if(this.reloadData) {
                            // this.getData(false)
                            this.reloadData = false
                        }
                    }.bind(this), 5000);


            },
            getRowClass(row) {
                if (!row.seen) return 'rowDanger'
            },
        success(action) {
            this.$toast.open({
                message: 'Lead '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        errorDialog() {
            this.$dialog.alert({
                title: 'Error',
                message: 'Please select the leads you want to switch frist',
                type: 'is-danger',
            })
        },
        getCompanyAgents(){
            getAgents().then(response=>{
                this.commercialAgents = response.data.commercialAgents
                this.residentialAgents = response.data.residentialAgents
            })
            .catch(error => {
                console.log(error)
            })
        },
        checkUserHasGroup(){
            checkUserGroupAndRoles().then(response=>{
                this.teamLeader = response.data.leaderHasGroup
                this.permArray = response.data.permArray
            })
            .catch(error => {
                console.log(error)
            })
        },
        deleteLeadsDialog(){
          console.log("Delete Leads Modal")
          this.deleteLeadsModal = true
        },
        deleteNoActionLeads(){
          console.log("deleteNoActionLeads Test")
            deleteNoActionLeads().then(response=>{
                console.log(response)
                this.deleteLeadsModal = false
            })
            .catch(error => {
                console.log(error)
            })
            this.getData()
        },
        autoSwitchDialog(lead=0) {
            console.clear()
            console.log('sssssssssssssss')
            if(window.auth_user.type == "admin"){
              if(this.selectedLeads.length != 0){
                  this.autoSwitchModel = true
                  // this.confirmAutoSwitch()
              }else if(lead != 0){
                  this.selectedLeads.push(lead)
                  this.autoSwitchModel = true
                  // this.confirmAutoSwitch()

              }else{
                  this.errorDialog()
              }
            }else{
              console.log("You are not admin , permission denied")
            }

        },
        autoSwitch(){
            var data = {
                'agent_id':this.autoSwitchData.rAgent,
                'commercial_agent_id':this.autoSwitchData.cAgent,
                'perAgent':this.autoSwitchData.perAgent,
                'selectedLeads':this.selectedLeads,
                '_token':this.token,
            }
            autoSwitchAPi(data)
            .then(response=>{
                this.autoSwitchModel = false;
                this.getData();
                this.selectedLeads = [];
            })
            .catch(error => {
                console.log(error)
            })
        },
    }
}
</script>

<style type="text/css" scoped="">
.leads-number
{
    position: absolute;
    bottom: 36px;

}
@media screen and (max-width: 767px) {
    .filters {
        display: block;
    }

    .filter-btn {
        margin-right: 2% !important;
        margin-bottom: 2% !important;
    }

    .leads-number{
        right: 10% !important;
        bottom: 10px !important;
        left: unset !important;
        margin-bottom: 17%;
        margin-right: 73%; 
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>
