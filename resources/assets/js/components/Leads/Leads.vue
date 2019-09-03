<template>
    <div>
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

                                    <div class="field">
                                    <div class="control has-icons-left">
                                        <div class="select">
                                        <select>
                                            <option value="all OPen Leads" selected>All Open Leads</option>
                                            <option value="Closed Leads">Closed Leads</option>
                                        </select>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="field">
                                    <div class="control has-icons-left">
                                        <div class="select">
                                        <select>
                                            <option value="Contacted" selected>Contacted</option>
                                            <option value="Not Contacted">Not Contacted</option>
                                        </select>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="level">
                                        <div class="level-item filters">
                                            <!-- <a v-if="userType === 'admin'" class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="autoSwitchDialog('0')">Auto Switch</a>
                                            <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkActionDialog('0')">Bulk Action</a>
                                            <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkDeleteDialog('0')">Bulk Delete</a> -->

                                            <div class="field  mr-10">
                                                <div class="control">
                                                    <input class="input is-meduim mt-10" type="text" placeholder="Search" v-model="searchInput" @input="search" style="margin-top:-19px !important">
                                                </div>
                                            </div>
                                            <!-- <a class="button is-link is-small mr-10" @click="startFilter = !startFilter">Filter</a>
                                            <a class="button is-success is-small" @click="switchLeadDialog('0')" v-if="permArray.switch_leads == 1 || userType == 'admin' || role == '1'">Switch</a> -->
                                        </div>
                                    </div>

                                </div>
                                <div class="" v-if="startFilter">
                                   <div class="columns mb-5 ml-0 filter-content">
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
                                    <!-- <div class="control">
                                        <a class="button is-success" @click="filterLeads">Get</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="columns is-mobile mb-5 ml-0">
                            <div class="column is-4">
                                <label class="label">Tags</label>
                                <div class="control">
                                    <div class=" is-fullwidth">
                                        <multiselect :close-on-select="false" v-model="selectedTags"  tag-placeholder="Add this as new tag" placeholder="Select Tags" label="en_name" track-by="id" value="id" :options="tags" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>                            
                                    </div>
                                </div>
                                <div class="control">
                                    <a class="button is-success" @click="filterLeads">Get</a>
                                </div>
                            </div>
                            <div class="column is-4">
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
                        <b-table-column field="id" label="Lead" sortable>
                             <router-link :to="'/admin/vue/showLead/'+props.row.id" style="color:#4AAED5"> 
                                      {{props.row.first_name+' '+props.row.last_name}}
                             </router-link>
                        </b-table-column>

                        <b-table-column field="status" label="Lead Type" sortable>
                            <router-link :to="'/admin/vue/showLead/'+props.row.id" style="color:#4AAED5"> 
                                      {{props.row.first_name+' '+props.row.last_name}}
                            </router-link>
                            <!-- <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-if="props.row.personal_status > 0"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i> -->
                        </b-table-column>

                        <b-table-column field="seen" label="Phone" sortable>
                            <!-- <i class="fa fa-circle" aria-hidden="true" style="color: orange;" v-if="props.row.seen == 1"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: green;" v-else-if="props.row.seen == 2"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: #ccffcc;" v-else-if="props.row.seen == 3"></i>
                            <i class="fa fa-circle" aria-hidden="true" style="color: red;" v-else></i> -->
                            {{props.row.phone}}
                        </b-table-column>

                        <b-table-column field="leadProbability" label="Mobile" sortable>
                            {{props.row.leadProbability}}
                        </b-table-column>

                        <b-table-column field="first_name" label="Email" sortable>
                            {{props.row.first_name }}
                        </b-table-column>

                        <b-table-column field="tag" label="Status" sortable>
                            <router-link :to="'/admin/vue/showLead/'+props.row.id" style="color:#4AAED5"> 
                                      {{props.row.first_name+' '+props.row.last_name}}
                             </router-link>
                        </b-table-column>
                        
                        <!-- <b-table-column field="phone" label="Hint" centered>
                            <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id, props.row.hot, props.row.favorite)"></i>
                        </b-table-column> -->

                        <b-table-column field="phone_iso" label="" sortable>
                            <!-- {{props.row.phone_iso}} -->
                            <i class="fas fa-envelope"></i>
                        </b-table-column>

                        <!-- <b-table-column field="phone" label="Phone" sortable>
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
                            <i class="fa fa-star" aria-hidden="true" style="color: #caa42d" v-if="Number(props.row.favorite)" @click="changeLeadStatus('fav',props.row.id)"></i>
                            <i class="fa fa-star" aria-hidden="true"  v-else @click="changeLeadStatus('fav',props.row.id)"></i>
                        </b-table-column>

                        <b-table-column field="hot" label="Hot" centered sortable>
                            <i class="fa fa-fire" aria-hidden="true"  style="color: #caa42d" v-if="Number(props.row.hot)" @click="changeLeadStatus('hot',props.row.id)"></i>
                            <i class="fa fa-fire" aria-hidden="true" v-else @click="changeLeadStatus('hot',props.row.id)"></i>
                        </b-table-column>

                        <b-table-column field="phone" label="Options" centered>
                            <div class="select">
                                <select @change="leadActions($event,props.row.id)">
                                    <option selected value="options">Options</option>
                                    <option value="show">Show</option>
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                        </b-table-column>

                        <b-table-column field="id" label="Switch" centered v-if="permArray.switch_leads == 1 || userType == 'admin'  || role == '1'">
                            <a class="button is-success is-small" @click="switchLeadDialog(props.row)">Switch</a>
                        </b-table-column> -->

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
            
           

            <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}
                  <div class="buttons">
                    <b-button type="is-success"><i class="fas fa-envelope"></i>  Send Email</b-button>
                    <b-button type="is-info"><i class="fas fa-print"></i>  Print</b-button>
                  </div>
            </div>

            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>


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
                                :date-formatter="dateFormatter"
                                position="is-bottom-left" v-model="newCallData.date">
                            </b-datepicker>
                        </b-field>
                    </div>



                    <div class="field">
                        <label class="label">Call Status</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <b-select v-model="call_status_id">
                                    <option v-for="status in callStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                                </b-select>
                            </div>
                        </div>
                    </div>



                    <div class="field">
                        <label class="label">Probability</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select v-model="newCallData.probability">
                                    <option value="Follow Up">Follow Up</option>
                                    <option value="On going">On going</option>
                                    <option value="Expected Closing">Expected Closing</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Rotation">Rotation</option>
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
                    <button class="button is-link" @click="bulkActionAction">Bulk Actoin</button>
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

                </section>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                    <button class="button is-link" @click="switchLeadAction">Switch</button>
                </footer>
            </div>
        </b-modal>
        <b-modal :active.sync="autoSwitchModel">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Auto Switch Lead</p>
                    <p class="modal-card-title" style="font-size: 15px; text-align: right;">{{ this.selectedLeads.length }} Leads</p>
                </header>
                <section class="modal-card-body">

                    <div class="field">
                        <label class="label">Residential Agent</label>
                        <div class="control">
                            <div class=" is-fullwidth">
                                <!-- <select v-model="autoSwitchData.rAgent">
                                    <option v-for="rAgent in residentialAgents" :key="rAgent.id" :value="rAgent.id">{{rAgent.name}}</option>
                                </select> -->
                                <multiselect :close-on-select="false" v-model="autoSwitchData.rAgent"  tag-placeholder="Add this as new tag" placeholder="Select Agents" label="name" track-by="id" value="id" :options="residentialAgents" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Commercial Agent</label>
                        <div class="control">
                            <div class=" is-fullwidth">
                                <!-- <select v-model="autoSwitchData.cAgent">
                                    <option v-for="cAgent in commercialAgents" :key="cAgent.id" :value="cAgent.id">{{cAgent.name}}</option>
                                </select> -->
                                <multiselect :close-on-select="false" v-model="autoSwitchData.cAgent"  tag-placeholder="Add this as new tag" placeholder="Select Agents" label="name" track-by="id" value="id" :options="commercialAgents" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Per Agent</label>
                        <div class="control">
                            <div class=" is-fullwidth">
                                <input type="number" name="" v-model="autoSwitchData.perAgent">
                            </div>
                        </div>
                    </div>

                </section>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                    <button class="button is-link" @click="autoSwitch">Auto Switch</button>
                </footer>
            </div>
        </b-modal>

        <b-modal :active.sync="deleteLeadsModal">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Delete No Action Leads</p>
                </header>
                <section class="modal-card-body">
                    <h4>Are you sure you want to delete all leads that have no actions ?</h4>
                </section>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                    <button class="button is-danger" @click="deleteNoActionLeads">Delete</button>
                </footer>
            </div>
        </b-modal>
        <!-- Hint Component -->

        <Hint :class="{openSide: ShowHint}" @closeSide="ShowHint = $event" :hintId='hintId' :fav="fav" :hot="hot" :flag="flag" :sideView='ShowHint' @changeHint="refreshPage"></Hint>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
changeLeadFav
<script>
    import {autoSwitchAPi,getMyLeads,changeLeadFav,changeLeadHot,deleteLead,newLeadsFilter,getPublicData,switchLeads,getAgents,checkUserGroupAndRoles,searchForLead, getLeadSources, getLeadsByAgent, getBtns, addCall,bulkActions,deleteNoActionLeads} from './../../calls'
    import Hint from './Hint'
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
            this.checkUserHasGroup()
            this.getCompanyAgents()
            this.getData()
        },
        components: {
            Hint,
            Multiselect
        },
        created() {
            this.$router.replace({hash: '#/1'});
            this.page = parseInt(this.$route.hash.split('/')[1])
            this.getSources()
             //this.getLeadsfilter()
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
                    // console.log('response.data')
                    // console.log(response.data)
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
    }

    .filter-content{
        margin-top: 2%;
    }
}
</style>
