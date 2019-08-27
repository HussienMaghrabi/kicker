<template>
    <div>
	<Header />
        <div class="level mb-5">
            <!-- <b-dropdown style="float: left;">
            <button class="button is-primary" slot="trigger">
            <span>My Leads</span>
            <b-icon icon="menu-down"></b-icon>
        </button>

        <b-dropdown-item v-for="btns in getLeadsByAgent" :key="btns.id">
        <router-link to="/HotLeads/1" :class="checkClass('HotLeads')">
        {{btns.title}} {{btns.count}}
    </router-link>
</b-dropdown-item>
</b-dropdown> -->
<div class="level">
    <div class="level-item">

    </div>
</div>



</div>
<div class="" v-if="startFilter">
    <div class="columns is-mobile mb-5 ml-0">
        <div class="column is-2">
            <div class="field">
                <b-field label="From">
                    <b-datepicker
                    placeholder="Click to select..."
                    position="is-bottom-left" v-model="filter.from">
                </b-datepicker>
            </b-field>
        </div>
    </div>
    <div class="column is-2">
        <div class="field">
            <b-field label="To">
                <b-datepicker
                placeholder="Click to select..."
                position="is-bottom-left" v-model="filter.to">
            </b-datepicker>
        </b-field>
    </div>
</div>
<div class="column is-2">
    <div class="field">
        <label class="label">Call Status</label>
        <div class="control">
            <div class="select is-fullwidth">
                <select v-model="filter.call_status_id">
                    <option v-for="status in callStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="column is-2">
    <div class="field">
        <label class="label">Meeting Status</label>
        <div class="control">
            <div class="select is-fullwidth">
                <select v-model="filter.meeting_status_id">
                    <option v-for="status in meetingStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="column is-2">
    <label class="label">Lead source</label>
    <div class="control">
        <div class="select is-fullwidth">
            <select v-model="filter.sourceId">
                <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
            </select>
        </div>
    </div>
</div>
<div class="column is-2">
    <label class="label">Location</label>
    <div class="field has-addons">

        <div class="control is-expanded">
            <div class="select is-fullwidth">
                <select v-model="filter.location">
                    <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                </select>
            </div>
        </div>
        <div class="control">
            <a class="button is-success" @click="filterLeads">Get</a>
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
    <b-table-column field="id" label="ID" sortable>
        {{props.row.id}}
    </b-table-column>

    <b-table-column field="status" label="R. Status" sortable>
        <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.personal_status > 0"></i>
        <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
    </b-table-column>

    <b-table-column field="seen" label="Seen" sortable>
        <i class="fa fa-circle" aria-hidden="true" style="color: orange;" v-if="props.row.seen == 1"></i>
        <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-else-if="props.row.seen == 2"></i>
        <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
    </b-table-column>

    <b-table-column field="leadProbability" label="Probability" sortable>
        {{props.row.leadProbability}}
    </b-table-column>

    <b-table-column field="first_name" label="Name" sortable>
        {{props.row.first_name+' '+props.row.last_name}}
    </b-table-column>

    <b-table-column field="phone" label="Hint" centered>
        <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id)"></i>
    </b-table-column>

    <b-table-column field="phone" label="Phone" sortable>
        {{props.row.phone}}
    </b-table-column>

    <b-table-column field="sourceName" label="Source" sortable>
        {{props.row.sourceName}}
    </b-table-column>

    <b-table-column field="requestLocation" label="Req Location" sortable>
        {{props.row.requestLocation}}
    </b-table-column>

    <b-table-column field="projectName" label="Req Project" sortable>
        {{props.row.projectName}}
    </b-table-column>

    <b-table-column field="created_at" label="Created At" sortable>
        {{props.row.created_at}}
    </b-table-column>

    <b-table-column field="type" label="Type" sortable >
        <span v-if="props.row.type">{{props.row.type}}</span>
        <span v-else>N/A</span>
    </b-table-column>

    <b-table-column field="favorite" label="Favorite" centered sortable>
        <i class="fa fa-star" aria-hidden="true" style="color: #caa42d" v-if="props.row.favorite" @click="changeLeadStatus('fav',props.row.id)"></i>
        <i class="fa fa-star" aria-hidden="true"  v-else @click="changeLeadStatus('fav',props.row.id)"></i>
    </b-table-column>

    <b-table-column field="hot" label="Hot" centered sortable>
        <i class="fa fa-fire" aria-hidden="true"  style="color: #caa42d" v-if="props.row.hot" @click="changeLeadStatus('hot',props.row.id)"></i>
        <i class="fa fa-fire" aria-hidden="true" v-else @click="changeLeadStatus('hot',props.row.id)"></i>
    </b-table-column>

    <b-table-column field="phone" label="Options" centered>
        <div class="select">
            <select @change="leadActions($event,props.row.id)">
                <option disabled selected value="options">Options</option>
                <option value="restore">Restore</option>
                <option value="delete">Delete</option>
            </select>
        </div>
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
<b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
<div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div>

<b-modal :active.sync="bulkActionModel">
    <div class="modal-card" style="width: auto">

        <header class="modal-card-head">
            <p class="modal-card-title">Bulk Action</p>
        </header>
        <section class="modal-card-body">


            <div class="field">
                <b-field label="Date">
                    <b-datepicker
                    placeholder="Click to select..."
                    position="is-bottom-left" v-model="newCallData.date">
                </b-datepicker>
            </b-field>
        </div>



        <div class="field">
            <label class="label">Call Status</label>
            <div class="control">
                <div class="select is-fullwidth">
                    <select v-model="call_status_id">
                        <option v-for="status in callStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                    </select>
                </div>
            </div>
        </div>



        <div class="field">
            <label class="label">Probability</label>
            <div class="control">
                <div class="select is-fullwidth">
                    <select v-model="newCallData.probability">
                        <option value="highest">Highest</option>
                        <option value="high">High</option>
                        <option value="normal">Normal</option>
                        <option value="low">Low</option>
                        <option value="lowest">Lowest</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="column is-12">
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <textarea class="textarea" placeholder="" v-model="newCallData.description"></textarea>
                </div>
            </div>
        </div>

    </section>
    <footer class="modal-card-foot" style="justify-content: flex-end;">
        <button class="button is-link" @click="bulkActionAction">Bulk Action</button>
    </footer>
</div>
</b-modal>

<b-modal :active.sync="switchLeadModel">
    <div class="modal-card" style="width: auto">

        <header class="modal-card-head">
            <p class="modal-card-title">Switch Lead</p>
        </header>
        <section class="modal-card-body">

            <div class="field">
                <label class="label">Residential Agent</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select v-model="switchLeadData.rAgent">
                            <option v-for="rAgent in residentialAgents" :key="rAgent.id" :value="rAgent.id">{{rAgent.name}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Commercial Agent</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select v-model="switchLeadData.cAgent">
                            <option v-for="cAgent in commercialAgents" :key="cAgent.id" :value="cAgent.id">{{cAgent.name}}</option>
                        </select>
                    </div>
                </div>
            </div>

        <Footer />
        </section>
        <footer class="modal-card-foot" style="justify-content: flex-end;">
            <button class="button is-link" @click="switchLeadAction">Switch</button>
        </footer>
    </div>
</b-modal>
<!-- Hint Component -->
<Hint :class="{openSide: ShowHint}" @closeSide="ShowHint = $event" :hintId='hintId' :sideView='ShowHint'></Hint>
</div>
</template>

<script>
    import {getMyLeads, getArchive,changeLeadFav,changeLeadHot,deleteLead,newLeadsFilter,getPublicData,switchLeads,getAgents,checkUserGroupAndRoles,searchForLead, getLeadSources, getLeadsByAgent, addCall,bulkActions,restoreLead,deleteArchiveLead} from './../../calls'
    import Hint from '../Leads/Hint'
import Header from '../Layout/Header'
import Footer from '../Layout/Footer'
    export default {
        data() {
            return {
                call_status_id: null,
                answered_not_interest: false,
                wrong_number: false,
                probability: false,
                frome: '',
                to: '',
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
                page: parseInt(this.$route.params.page),
                perPage: 100,

                isLoading: true,
                isFullPage: true,
                searchInput: '',
                selectedLeads: [],

                ShowHint: false,
                hintId: '',
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
            }
        },
        mounted() {
            this.checkUserHasGroup()
            this.getCompanyAgents()
            this.getAllArchive()
        // this.getData()
    },
    components: {
        Hint,
         Header: Header,
            Footer: Footer,
    },
    created() {
        this.getSources()
        //this.getLeadsfilter()
    },
    methods: {
        archive() {
            var data = {
                // answered_not_interest : this.answered_not_interest,
                wrong_number : this.wrong_number,
                probability : this.probability,
                from : this.from,
                to : this.to,

            }
            axios.post('/admin/archive', data)
            .then(response=>{
                this.getAllArchive();
            })
            .catch(error => {
                console.log(error)
            });
        },
        getAllArchive(loading = true){
            this.isLoading = loading
            console.clear()
            console.log('response.data.totallllllllllllllllllllllll')

            getArchive(this.page).then(response=>{
                console.log('response.data.sssssssssssssssssssssss')
                console.log('this.leads = response.data.data')
                console.log(response.data.data)

                this.perPage = response.data.per_page
                this.leads = response.data.data
                //console.clear()
                //console.log(this.leads)
                this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.leadsTotalNumber = response.data.total

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
        checkClass(r){
            var path = this.$route.path.split('/');
            if(path[1] == r) return 'tabLinkActive'
                else return 'tabLinkNotActive'
            },
        getLeadsfilter(){
            console.log('this.token')
            console.log(window.auth_user)
            getLeadsByAgent({
                "user_id": this.userId,
                "agent_id": " ",
            }).then(response=>{
                // console.log('response.data')
                console.log('response.datassssss')
                console.log(response.data)
                this.getLeadsByAgent = response.data.btns
            })
            .catch(error => {
                console.log(error)
            })
        },

        getSources(){
            getLeadSources().then(response=>{
                // console.log('response.data')
                // console.log(response.data)
                this.leadSources = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },

        /*getData(loading = true){

            this.isLoading = loading
            getMyLeads(this.page).then(response=>{

                console.log('this.leads = response.data.data')
                console.log(response.data.total)

                this.leads = response.data.data
                //console.clear()
                //console.log(this.leads)
                this.leadsCurrentNumber = this.leads.length
                this.leadsTotalNumber = response.data.total

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
        },*/
        search(){
            if(this.searchInput){
                //this.isLoading = true
                var data ={
                    'searchInput':this.searchInput,
                    '_token':this.token,
                    'agent_id':this.userId,
                };
                searchForLead(data).then(response=>{

                    console.log(response)
                    this.leads = response.data
                    //this.isLoading = false

                })
                .catch(error => {
                    console.log(error)
                })
            }
        },
        filterLeads(scrollSwitch = false){
            this.isLoading = true
            this.fitlerFlag = true
            var data ={
                'leadSources':this.filter.sourceId,
                'location':this.filter.location,
                'meetingStatus':this.filter.meeting_status_id,
                'callStatus':this.filter.call_status_id,
                'dateTo':this.parsedDateTo,
                'dateFrom':this.parsedDateFrom,
                '_token':this.token,
                'agent_id':this.userId,
            };
            newLeadsFilter(this.page,data).then(response=>{
                console.log('this.leads = response.data.data')
                console.log(this.leads = response.data.data)
                this.leads = response.data.data
                this.leadsCurrentNumber = this.leads.length
                this.leadsTotalNumber = response.data.total

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
                console.log(this.residentialAgents);
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
                console.log(this.residentialAgents);
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
                this.error('Call')
                this.isLoading = false
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
            console.log(action)
            if(action == 'restore'){
                this.confirmRestore(id)
                // window.location = "/admin/leads/"+id+"/restore";
            }
            else if(action == 'delete') {
                this.confirmDelete(id)
            }
        },
        confirmDelete(id) {
            this.$dialog.confirm({
                title: 'Deleting Lead',
                message: 'Are you sure you want to <b>delete</b> this Lead?',
                confirmText: 'Delete Lead',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteThisLead(id)
            })
        },
        deleteThisLead(id){
            deleteArchiveLead(id).then(response=>{
                console.log(response)
                this.getAllArchive()
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
                console.log(response)
                this.callStatus = response.data.callStatus
                this.projects = response.data.projects
                this.meetingStatus = response.data.meetingStatus
                console.log('response.data')
                this.locations = response.data.locations
            })
            .catch(error => {
                console.log(error)
            })
        },
        // dateFormatterFrom(dt){
        //     var date = dt.toLocaleDateString();
        //     const [month, day, year] = date.split('/')
        //     this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        //     return date
        // },
        // dateFormatterTo(dt){
        //     var date = dt.toLocaleDateString();
        //     const [month, day, year] = date.split('/')
        //     this.parsedDateTo = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        //     return date
        // },
        onPageChange(page) {
            this.page = page
            this.$router.replace({ name: "MyLeads", params: {page: page} })
            if(this.fitlerFlag){
                this.filterLeads()
            }else {
                this.getData()
            }
        },
        openHint(id){
            this.ShowHint = true
            this.hintId = id
            this.reloadData = true

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
            console.log(response)
            this.commercialAgents = response.data.commercialAgents
            this.residentialAgents = response.data.residentialAgents
        })
        .catch(error => {
            console.log(error)
        })
    },
    checkUserHasGroup(){
        checkUserGroupAndRoles().then(response=>{
            console.log(response)
            this.teamLeader = response.data.leaderHasGroup
            this.permArray = response.data.permArray
        })
        .catch(error => {
            console.log(error)
        })
    },
    confirmRestore(id) {
        this.$dialog.confirm({
            title: 'Restoring Lead',
            message: 'Are you sure you want to <b>restore</b> this Lead?',
            confirmText: 'Restore Lead',
            type: 'is-info',
            hasIcon: true,
            onConfirm: () => this.restoreThisLead(id)
        })
    },
    restoreThisLead(id){
        restoreLead(id).then(response=>{
            console.log(response)
            this.getAllArchive()
            this.success('Restored')
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
    transform: translate(20%, -10vh);
}

@media screen and (max-width: 767px) {
    .leads-number
    {
        transform: translate(42%, -2vh);
    }
}
</style>
