<template>
                        <div>
                            <div class="level mb-5">
                                <div class="level">
                                    <div class="level-item">

                                    </div>
                                </div>

                                <div class="level">
                                    <div class="level-item filters">
                                        <a class="button is-success is-small" style="margin-right: 50px;" @click="bulkDeleteDialog('0')">Bulk Delete</a>
                                        <div class="field  mr-10">
                                            <div class="control">
                                                <input class="input is-meduim mt-10" type="text" placeholder="Search" v-model="searchInput" @input="search">
                                            </div>
                                        </div>
                                        <a class="button is-link is-small mr-10" @click="startFilter = !startFilter">Filter</a>
                                        <a class="button is-success is-small" @click="switchLeadDialog('0')" v-if="permArray.switch_leads == 1 || userType == 'admin'">Switch</a>
                                    </div>
                                </div>

                            </div>
                            <div class="" v-if="startFilter">
                               <div class="columns is-multiline mb-5 ml-0 filter-content">
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
                                            <b-field label="From">
                                                <b-datepicker
                                                    placeholder="Click to select..."
                                                    :date-formatter="dateFormatterFrom"
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
                                                    :date-formatter="dateFormatterTo"
                                                    position="is-bottom-left" v-model="filter.to">
                                                </b-datepicker>
                                            </b-field>
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
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label">Location</label>
                                            <div class="control is-expanded">
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.location">
                                                        <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label">Project</label>
                                            <div class="control is-expanded">
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.projects">
                                                        <option v-for="project in projects" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                     <div class="column is-4">
                                        <label class="label">Lead source</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="filter.sourceId">
                                                    <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-4" v-if="userType == 'admin'">
                                        <div class="field">
                                            <label class="label">Groups</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.selectedGroup">
                                                        <option v-for="group in groups" :key="group.id" :value="group.id">{{group.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-12">
                                        <div class="field">
                                            <b-field label="leadsActionType">
                                                <b-radio v-model="leadsActionType" name="leadsActionType" native-value="leadsWithActions">
                                                    leads With Actions
                                                </b-radio>
                                                <b-radio v-model="leadsActionType" name="leadsActionType" native-value="leadsNoAction">
                                                    leads With No Actions
                                                </b-radio>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="column is-3">
                                       <label class="label">Leads With Action</label>
                                       <div class="control">
                                           <div class="select is-fullwidth">
                                             <select v-model="leadsWithAction" :disabled="leadsActionType == 'leadsNoAction'">
                                                 <option value="residential">Residential</option>
                                                 <option value="commercial">Commercial</option>
                                                 <option value="both">Both</option>
                                             </select>
                                           </div>
                                       </div>
                                   </div>
                                    <div class="column is-3">
                                       <label class="label">Leads With No Action</label>
                                       <div class="control">
                                           <div class="select is-fullwidth">
                                             <select v-model="leadsNoAction" :disabled="leadsActionType == 'leadsWithActions'">
                                                 <option value="residential">Residential</option>
                                                 <option value="commercial">Commercial</option>
                                                 <option value="both">Both</option>
                                             </select>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="column is-3">
                                        <label class="label">Phone ISO</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="phoneIso">
                                                    <option value="national">National</option>
                                                    <option value="international">International</option>
                                                    <option value="both">Both</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-3">
                                        <label class="label">probability</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="probability">
                                                    <option value="Follow Up">Follow Up</option>
                                                    <option value="On going">On going</option>
                                                    <option value="Expected Closing">Expected Closing</option>
                                                    <option value="Closed">Closed</option>
                                                    <option value="Rotation">Rotation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-3">
                                        <label class="label">Agent</label>
                                        <div class="field has-addons">
                                            <div class="control is-expanded">
                                                <div class="select is-fullwidth">
                                                    <select v-model="filter.selectedAgent">
                                                        <option v-for="agent in allAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control">
                                                <a class="button is-success" @click="filterLeads">Get</a>
                                            </div>
                                            <div class="control">
                                                <!-- 'leadSources':this.filter.sourceId,
                                                'location':this.filter.location,
                                                'meetingStatus':this.filter.meeting_status_id,
                                                'callStatus':this.filter.call_status_id,
                                                'dateTo':this.parsedDateTo,
                                                'dateFrom':this.parsedDateFrom,
                                                '_token':this.token,
                                                "agent_id": this.filter.selectedAgent,
                                                "group_id": this.filter.selectedGroup,
                                                "reportType": reportType, -->
                                                <form method="post" action="/admin/newLeadsFilter?page=1" v-if="userType == 'admin'">
                                                    <input type="hidden" name="leadSources" v-bind:value="filter.sourceId">
                                                    <input type="hidden" name="location" v-bind:value="filter.location">
                                                    <input type="hidden" name="project" v-bind:value="filter.projects">
                                                    <input type="hidden" name="meetingStatus" v-bind:value="filter.meeting_status_id">
                                                    <input type="hidden" name="callStatus" v-bind:value="filter.call_status_id">
                                                    <input type="hidden" name="dateTo" v-bind:value="parsedDateTo">
                                                    <input type="hidden" name="dateFrom" v-bind:value="parsedDateFrom">
                                                    <input type="hidden" name="_token" v-bind:value="token">
                                                    <input type="hidden" name="agent_id" v-bind:value="filter.selectedAgent">
                                                    <input type="hidden" name="group_id" v-bind:value="filter.selectedGroup">
                                                    <input type="hidden" name="leadsNoAction" v-bind:value="leadsNoAction">
                                                    <input type="hidden" name="leadsWithAction" v-bind:value="leadsWithAction">
                                                    <input type="hidden" name="reportType" value="report">
                                                    <button type="submit" class="button is-success" download>Report</button>
                                                    <!-- @click="filterLeads(false, 'report')" -->
                                                </form>
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
                                    default-sort="created_at">

                                    <template slot-scope="props">
                                        <b-table-column field="id" label="ID" sortable>
                                            {{props.row.id}}
                                        </b-table-column>

                                        <b-table-column field="id" label="RS" sortable>
                                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.personal_status == 1"></i>
                                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                                        </b-table-column>

                                        <b-table-column field="id" label="CS" sortable>
                                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.commercial_status == 1"></i>
                                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i>
                                        </b-table-column>

                                        <b-table-column field="leadProbability" label="Probability" sortable>
                                            {{props.row.leadProbability}}
                                        </b-table-column>

                                        <b-table-column field="agentName" label="Residential Agent" sortable>
                                            {{props.row.agentName}}
                                        </b-table-column>

                                        <b-table-column field="commercialAgentName" label="Commercial Agent" sortable>
                                            {{props.row.commercialAgentName}}
                                        </b-table-column>

                                        <b-table-column field="phone_iso" label="CO" sortable>
                                            {{props.row.phone_iso}}
                                        </b-table-column>

                                        <b-table-column field="phone" label="Hint" centered>
                                            <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id)"></i>
                                        </b-table-column>

                                        <b-table-column field="first_name" label="Name" sortable>
                                            {{props.row.first_name+' '+props.row.last_name}}
                                        </b-table-column>
                                        <b-table-column field="tag" label="Tag" sortable>
                                            {{props.row.tag}}
                                        </b-table-column>
                                        <!--<b-table-column field="email" label="Email" sortable>
                                            <a :href="'mailto:'+props.row.email">{{props.row.email}}</a>
                                        </b-table-column>-->

                                        <b-table-column field="phone" label="Phone" sortable>
                                            {{props.row.phone}}
                                        </b-table-column>

                                        <b-table-column field="projectName" label="Req Project" sortable>
                                            {{props.row.projectName}}
                                        </b-table-column>

                                        <b-table-column field="sourceName" label="Source" sortable>
                                            {{props.row.sourceName}}
                                        </b-table-column>

                                        <b-table-column field="created_at" label="Created At" sortable>
                                            {{props.row.created_at}}
                                        </b-table-column>

                                         <b-table-column field="phone" label="Options" centered>
                                            <div class="select">
                                                <select @change="leadActions($event,props.row.id)">
                                                    <option disabled selected value="options">Options</option>
                                                    <option value="show">Show</option>
                                                    <option value="edit">Edit</option>
                                                    <option value="delete">Delete</option>
                                                </select>
                                            </div>
                                        </b-table-column>

                                        <b-table-column field="id" label="Switch" centered v-if="permArray.switch_leads == 1 || userType == 'admin'">
                                            <a class="button is-success is-small" @click="switchLeadDialog(props.row)">Switch</a>
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
                                </template>
                            </b-table>
                            <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div>
                            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
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

                    </section>
                    <footer class="modal-card-foot" style="justify-content: flex-end;">
                        <button class="button is-link" @click="switchLeadAction">Switch</button>
                    </footer>
                </div>
            </b-modal>
            <!-- Hint Component -->
            <Hint :class="{openSide: ShowHint}" @closeSide="ShowHint = $event" :hintId='hintId' :sideView='ShowHint' @changeHint="refreshPage"></Hint>
                        </div>
</template>

<script>
import {getTeamLeads,deleteLead,newLeadsFilter,exportReportLeads,getPublicData,switchLeads,searchForLead,getAgents,checkUserGroupAndRoles,getLeadSources} from './../../calls'
import Hint from './Hint'
    export default {
        data() {
            return {
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                leadSources: [],
                leads: [],
                isEmpty: false,
                isLoading: true,
                hasMobileCards: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',

                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,

                isLoading: true,
                isFullPage: true,
                selectedLeads: [],
                callStatus: [],
                projects: [],
                locations: [],
                meetingStatus:[],
                filter: {},
                startFilter: false,
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                switchLeadModel: false,
                switchLeadData: {},
                leadsIds: [],
                ShowHint: false,
                hintId: '',
                commercialAgents: [],
                residentialAgents: [],
                allAgents: [],
                permArray: [],
                groups: [],
                searchInput: '',
                leadsNoAction: '',
                leadsWithAction:'',
                teamLeadsTab: true,
                leadsActionType: 'leadsWithActions',
                phoneIso: '',
                probability: ''
            }
        },
        mounted() {
            this.checkUserHasGroup()
            this.getCompanyAgents()
            this.getData()
        },
        components: {
            Hint
        },
        created() {
            this.$router.replace({hash: '#/1'});
            this.getSources()
        },
        methods: {
            refreshPage() {
                 this.getData();
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
            getData(scrollSwitch = false){
                this.isLoading = true
                getTeamLeads(this.page).then(response=>{
                    // console.log('response.dataaaaaaaaaaaaaaaaaa')
                    // console.log(response.data.data)
                    this.perPage = response.data.per_page
                    this.leads = response.data.data;
                    this.leadsCurrentNumber  = Math.min(response.data.total,this.page * this.perPage);
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
                    //console.log(response.data)
                    this.getPublic()

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
                        console.log(response)
                        this.leads = response.data
                        //this.isLoading = false

                    })
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
            // exportLeads(scrollSwitch = false){
            //     this.isLoading = true
            //     this.fitlerFlag = true
            //     var data ={
            //         'leadSources':this.filter.sourceId,
            //         'location':this.filter.location,
            //         'meetingStatus':this.filter.meeting_status_id,
            //         'callStatus':this.filter.call_status_id,
            //         'dateTo':this.parsedDateTo,
            //         'dateFrom':this.parsedDateFrom,
            //         '_token':this.token,
            //         "agent_id": this.filter.selectedAgent,
            //         "group_id": this.filter.selectedGroup,
            //     };
            //     console.log(data)
            //     exportReportLeads(this.page,data).then(response=>{
            //         console.log(response)
            //         this.leads = response.data.data

            //         if(this.leads.length == 0){
            //             this.isEmpty = true
            //         }
            //         let currentTotal = response.data.total
            //             if (response.data.total / this.perPage > 1000) {
            //                 currentTotal = this.perPage * 1000
            //             }
            //         this.total = currentTotal
            //         this.isLoading = false

            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // },
            filterLeads(scrollSwitch = false, reportType = null){
                this.isLoading = true
                this.fitlerFlag = true
                var data ={
                    'leadSources':this.filter.sourceId,
                    'location':this.filter.location,
                    'project':this.filter.projects,
                    'meetingStatus':this.filter.meeting_status_id,
                    'callStatus':this.filter.call_status_id,
                    'dateTo':this.parsedDateTo,
                    'dateFrom':this.parsedDateFrom,
                    '_token':this.token,
                    "agent_id": this.filter.selectedAgent,
                    "group_id": this.filter.selectedGroup,
                    "reportType": reportType,
                    'teamLeadsTab': this.teamLeadsTab,
                    'phoneIso': this.phoneIso,
                    'probability': this.probability
                    };
                if(this.leadsActionType == 'leadsNoAction'){
                    data['leadsNoAction'] = this.leadsNoAction
                    console.log(data['leadsNoAction'])
                }else if(this.leadsActionType == 'leadsWithActions'){
                    data['leadsWithActions'] = this.leadsWithAction
                    console.log(data['leadsWithActions'])
                }
                newLeadsFilter(this.page,data).then(response=>{
                    this.perPage = response.data.per_page
                    this.leads = response.data.data
                    this.leadsCurrentNumber = response.data.data.length;
                    this.leadsTotalNumber = response.data.total
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
            switchLeadDialog(lead=0) {
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
            getPublic(){
                getPublicData().then(response=>{
                    console.log(response)
                    console.log("projects", response.data.projects)
                    this.callStatus = response.data.callStatus
                    this.projects = response.data.projects
                    this.meetingStatus = response.data.meetingStatus
                    this.locations = response.data.locations
                    this.groups = response.data.groups
                })
                .catch(error => {
                    console.log(error)
                })
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
                this.$router.replace({ name: "TeamLeads", params: {page: page} })
                if(this.fitlerFlag){
                    this.filterLeads()
                }else {
                    this.getData()
                }

            },
            openHint(id){
                this.ShowHint = true
                this.hintId = id
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
                    this.commercialAgents.forEach(element => {
                        this.allAgents.push(element)
                    });
                    this.residentialAgents.forEach(element => {
                        this.allAgents.push(element)
                    });
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
        }
    }
</script>

<style type="text/css" scoped="">
    .leads-number
    {
        position: absolute;
        left: 200px;
        bottom: 45px;

    }

    @media screen and (max-width: 767px) {
    .filters {
        display: block;
    }

    .leads-number{
        right: 10% !important;
        bottom: 10px !important;
        left: unset !important;
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>
