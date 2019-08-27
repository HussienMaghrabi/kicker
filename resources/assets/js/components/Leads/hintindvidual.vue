<template>
    <div class="side-pop">
        <nav class="level is-mobile">
            <div class="level-left">
                <a class="level-item" aria-label="like" @click="sideClose">
                    <span class="icon is-small">
                        <i class="fa fa-close hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="level-right">
                <a class="level-item" aria-label="like">
                    <span class="icon is-small">
                        <i class="fa fa-cloud hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
                <a class="level-item" aria-label="like">
                    <span class="icon is-small">
                        <i class="fa fa-trash-o hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
        </nav>
        <div class="box" v-if="leadData.first_name" style="position: relative">
            <article class="media">
                <div class="media-left">
                    <figure class="image avatarImage"  v-if="leadData.image">
                        <img :src="'https://theaddress-eg.com/uploads/'+leadData.image">
                    </figure>
                    <span class="nameSpan" v-else>{{getShortName()}}</span>
                </div>
                <div class="media-content">
                <div class="content">
                    <div class="columns is-mobile">
                        <div class="column is-6" style="display: block; margin-top: 0; margin-left: 0">
                            <h3>{{leadData.first_name}} {{leadData.last_name}}</h3>
                            <h5>Lead Source  : {{leadData.lead_source_name}} </h5>
                            <p>Reference  : {{leadData.reference}}</p>
                            <p>Creation Date  : {{leadData.created_at}}</p>
                            <!-- <p>
                            <strong><h3>{{leadData.first_name}} {{leadData.last_name}}</h3></strong>
                            <h5>Lead Source  : {{leadData.lead_source_name}} </h5>
                            Reference  : {{leadData.reference}}<br>
                            Creation Date  : {{leadData.created_at}}
                        </p> -->
                        </div>
                        <div class="column is-6" style="margin-top: 0">
                            <div class="columns is-mobile" style="margin-top: 0; margin-left: 0">
                                <div class="column is-6" style="margin-left: 2rem;">
                                </div>
                                <div class="column is-6">
                                    <!-- <i class=""></i><a @click="HistoryLeadModel">History</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-6">
                        
                        </div>
                        <div class="col-6">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div> -->
                </div>
                <nav class="level is-mobile">
                    <div class="level-left">
                    <a class="level-item" aria-label="reply">
                        <span class="icon is-small">
                            <i class="fa fa-phone hintIcont" aria-hidden="true" @click="showPhone = !showPhone"></i>
                        </span>
                    </a>
                    <a class="level-item" aria-label="reply"  v-if="showPhone">
                        <span><a :href="'tel:'+leadData.phone">{{leadData.phone}}</a></span>
                    </a>
                    <b-dropdown  class="level-item">
                        <i class="fa fa-envelope hintIcont" aria-hidden="true" slot="trigger"></i>
                        <b-dropdown-item custom paddingless>
                                <div class="modal-card" style="width:300px;">
                                    <header class="card-header">
                                        <p class="card-header-title">
                                            Send CIL Request
                                        </p>
                                    </header>
                                    <section class="modal-card-body">
                                        <div class="field">
                                            <label class="label">Developer</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="cilData.dev" @change="getDevPro">
                                                        <option v-for="dev in developers" :key="dev.id" :value="dev.id">{{dev.en_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="label">Project</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="cilData.project">
                                                        <option v-for="devPro in devProjects" :key="devPro.id" :value="devPro.id">{{devPro.en_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!--<div class="field">
                                            <label class="label">File</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="todo.to_do_type">
                                                        <option value="call">Call</option>
                                                        <option value="meeting">Meeting</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->

                                    </section>
                                    <footer class="modal-card-foot">
                                        <button class="button is-link" @click="addNewCILRequest">Send</button>
                                    </footer>
                                </div>
                        </b-dropdown-item>
                    </b-dropdown>
                    <b-dropdown  class="level-item">
                        <i class="fa fa-bell hintIcont" aria-hidden="true" slot="trigger"></i>
                        <b-dropdown-item custom paddingless>
                                <div class="modal-card" style="width:300px;">
                                    <header class="card-header">
                                        <p class="card-header-title">
                                            Add To Do
                                        </p>
                                    </header>
                                    <section class="modal-card-body">
                                         <div class="field">
                                            <label class="label">To-Do Type</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="todo.to_do_type">
                                                        <option value="call">Call</option>
                                                        <option value="meeting">Meeting</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <b-field label="Due Date">
                                                <datetime
                                                type="datetime"
                                                v-model="todo.to_do_due_date"
                                                input-class="input"
                                                value-zone="Africa/Cairo"
                                                zone="Africa/Cairo"
                                                :phrases="{ok: 'Confirm', cancel: 'Cancel'}"
                                                format="yyyy-MM-dd HH:mm:ss"
                                                :hour-step="1"
                                                :minute-step="1"
                                                :week-start="7"
                                                use12-hour
                                                auto
                                                ></datetime>
                                            </b-field>
                                        </div>

                                        <div class="field">
                                            <label class="label">Description</label>
                                            <div class="control">
                                                <textarea class="textarea" placeholder="" v-model="todo.to_do_description"></textarea>
                                            </div>
                                        </div>

                                    </section>
                                    <footer class="modal-card-foot">
                                        <button class="button is-link" @click="addNewToDo">Save</button>
                                    </footer>
                                </div>
                        </b-dropdown-item>
                    </b-dropdown>

                    <a class="button is-success is-small" @click="switchLeadDialog(leadData)">Switch</a>

                    </div>
                </nav>
                </div>
            </article>
        </div>
        <section>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <strong> <span class="fa fa-star"></span> Interest </strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <thead>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Date</th>
                            </thead>
                        <tbody>
                            <tr v-for="interest in InterestArray" :key="interest.id">
                                <td>{{ interest.type }}</td>
                                <td>{{ interest.en_name }}</td>
                                <td>{{ interest.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <strong> <span class="fa fa-comment"></span> Massege </strong>
                        </div>
                        <div class="card-body">
                            <table>
                                <thead>
                                    <th>Massege</th>
                                </thead>
                                <tbody>
                                    <tr v-for="massege in massegeArray" :key="massege.id">
                                        <td><textarea class="form-control" rows="5">{{ massege.massage }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <strong> <span class="fa fa-hart"></span> Favorite </strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <thead>
                                <th>Property</th>
                                <th>title</th>
                                <th>Type</th>
                            </thead>
                        <tbody>
                            <tr v-for="favorite in favoriteArray" :key="favorite">
                                <td>{{ favorite.id }}</td>
                                <td>{{ favorite.en_name }}</td>
                                <td>{{ favorite.type }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <strong> <span class="fa fa-at"></span> Requet page </strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <thead>
                                <th>ID</th>
                                <th>Location</th>
                                <th>Unit type</th>
                                <th>Created at</th>
                            </thead>
                            <tbody>
                                <tr v-for="requestUnit in requestLeadArray" :key="requestUnit.id">
                                    <td>{{ requestUnit.id }}</td>
                                    <td>{{ requestUnit.location_name }}</td>
                                    <td>{{ requestUnit.unit_name }}</td>
                                    <td>{{ requestUnit.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
                    <div v-if="leadData.requests">
                        <nav class="panel" v-if="leadData.requests.length > 0"  v-for="(req,i) in leadData.requests" :key="req.id">
                            <p class="panel-heading">
                                Request {{i+1}}
                            </p>

                            <div class="panel-block">
                                <ul>
                                    <li><strong>Date:</strong> {{req.created_at}}</li>
                                    <li><strong>Location:</strong> {{req.loc ? req.loc.en_name : ''}}</li>
                                    <li><strong>Time from:</strong>{{req.contact_time_from}} : <strong>To:</strong> {{req.contact_time_to}}</li>
                                    <li><strong>Down Payment:</strong> {{req.down_payment}}</li>
                                    <li><strong>Price from:</strong> {{req.price_from}} <strong>To:</strong>{{req.price_to}}</li>
                                    <li><strong>Unit Type:</strong> {{req.unittype ? req.unittype.en_name : ''}}</li>
                                    <li><strong>Project:</strong>
                                        <span v-for="project in req.project">
                                            {{ project.en_name }}
                                            {{project.id == req.project[req.project.length - 1 ].id ? '' : '---' }}
                                        </span>
                                    </li> <!-- {{req.project ? req.project.en_name : ''}} -->
                                    <li><strong>Area from:</strong> {{req.area_from}} <strong>To:</strong> {{req.area_to}}</li>
                                    <li><strong>Requested By:</strong> {{(req.user || {}).name}}</li>
                                    <li><strong>Note:</strong> {{req.notes}}</li>
                                </ul>
                            </div>
                        </nav>
                        <div class="notification" v-if="leadData.requests.length == 0">
                            No Requests Added
                        </div>
                    </div>

        </section>

<!-- // tabs website model -->

<b-modal :active.sync="EditCallsModel">
    <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Edit Calls</p>
        </header>
        <section class="modal-card-body">
            <div class="container">
                <div class="row">
                    <b-field label="Lead">
                        <b-input v-model="Leadinfoedit.first_name"></b-input>
                    </b-field>
                    <b-field label="phone">
                        <b-input v-model="Leadinfoedit.phone"></b-input>
                    </b-field>
                    <b-field label="Duration">
                        <b-input v-model="Leadinfoedit.duration"></b-input>
                    </b-field>
                    <b-field label="Simple">
                        <!-- <b-select placeholder="Select a name">
                            <option
                                v-for="option in StatusName"
                                :v-if="option.name == Leadinfoedit.status_name"
                                :value="option.id"
                                :key="option.id"
                                v-bind="option.id"
                                >
                                {{ option.name }}
                            </option>
                        </b-select> -->
                    </b-field>
                    <b-field label="Call Status">
                        <b-input v-model="Leadinfoedit.status_name"></b-input>
                    </b-field>
                    <b-field label="date">
                        <b-datepicker
                            placeholder="Click to select..."
                            icon="calendar-today"
                            v-model="Leadinfoedit.created_at"
                            >
                        </b-datepicker>
                    </b-field>
                    <b-field label="Probability">
                        <b-input v-model="Leadinfoedit.probability"></b-input>
                    </b-field>
                    <b-field label="Projects">
                        <b-input v-model="Projects"></b-input>
                    </b-field>
                    <b-field label="Description">
                        <b-input type="textarea"></b-input>
                    </b-field>
                </div>
            </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="EditCallsModel = false">Close</button>
          <button class="button is-info" @click="EditLeadCall">Add</button>
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
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>


</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>



import {switchLeads,getAgents,editCalls,callstatus,GetleadInfo,GetleadSwitchHistory,Getcilslead,GetFavoriteLead,GetleadInterest,saveOtherContacts,GetLeadContacts,GetLeadContracts,GetleadHistory,GetLeadMassege,getLeadData,addCall,addMeeting,addRequest,addNote,getPublicData,getUnitTypes,addToDo,getDevProjects,addCILRequest,getLeadSources,getSuggestionsNew,changeLeadFav,changeLeadHot,getOwnedUnits,getHintTags,storeMultipleTags,addSuggestions,getLeadSuggestions,convertLeadCC,FromrequestPage} from './../../calls'

import Multiselect from 'vue-multiselect'
import createUnitHintSection from "../Resale/createUnitHintSection";
// import Create from "../Resale/Create";
  // register globally
  // Vue.component('multiselect', Multiselect)

export default {
    components: { Multiselect ,
        createUnitHintSection : createUnitHintSection,
    },
    data(){
        return {
            activeTab2: 0,
            activeTabsHistory:0,
            EditCallsModel: false,
            OpenMassegeData: false,
            OpenInterest: false,
            OpenHistory: false,
            OpenContracts: false,
            requestPage: false,
            OpenFavorite: false,
            openclis:false,
            siteiconsmodel:false,
            leadhistorymodel:false,
            openHistorySwitch: false,
            AppendContractsData: [],
            commercialAgents: [],
            residentialAgents: [],
            leadID: null,
            AppendContactsData: [],
            AppendHistoryArray:[],
            Contactform: [],
            intrestArray:[],
            InterestArray:[],
            favoriteArray: [],
            switchLeadArray: [],
            massegeArray: [],
            cilsArray:[],
            OpenContact: false,
            activeTab: 0,
            activeTabActions: 0,
            leadData: {},
            contacts: [],
            isLoading: false,
            isFullPage:false,
            callStatus: [],
            projects: [],
            locations: [],
            developers: [],
            devProjects: [],
            meetingStatus:[],
            switchLeadData: {},
            autoSwitchData: {},
            StatusName:[],
            Leadinfoedit:{
                first_name: null,
                phone: null,
                duration: null,
                status_name: null,
                probability: null,
                created_at: null,
            },
            newCallData: {date: new Date()},
            newMeetingData: {date: new Date()},
            newRequestData: {},
            token: window.auth_user.csrf,
            userId: window.auth_user.id,
            phone_in_out : 'out',
            call_status_id : '',
            meeting_status_id : '',
            request_type: '',
            showDueCard: false,
            formatAmPm: true,
            newNote: '',
            showPhone: false,
            unitTypes: [],
            todo: {},
            cilData: {},
            showFullDataCard: false,
            options: [],
            suggestions : '',
            disabled: true,
            resales: [],
            rentals: [],
            hintTags: [],
            selectedTags: [],
            defaultSortDirection: 'desc',
            units: [],
            selectedLeads: [],
            selectedSuggestions: [],
            suggestionsActive: false,
            leadNewHomeSuggestions: [],
            leadResaleSuggestions: [],
            leadRentalSuggestions: [],
            suggestions_request_type: '',
            requestLeadArray: [],
            ides:[],
            switchLeadModel: false,
        }
    },
    props: {
        sideView: {
            type: Boolean,
        },
        hintId: null,
        fav: null,
        hot: null,
        flag: null,
        tab: ''
    },
    updated() {
        if(this.leadData.favorite == 1){
                document.getElementById("fav").style.color = "#caa42d"
        }else{
                document.getElementById("fav").style.color = "unset"
        }
        if(this.leadData.hot == 1){
                document.getElementById("hot").style.color = "#caa42d"
        }else{
                document.getElementById("hot").style.color = "unset"
        }
    },
    watch: {
        'hintId': function(newId, oldId) {
            console.log(this.hintId)
            this.getData()
        },
        'call_status_id': function(newId, oldId) {
            this.showDue('call')
        },
        'meeting_status_id': function(newId, oldId) {
            this.showDue('meeting')
        },
        'request_type': function(newId, oldId) {
            if(newId == 'resale' || newId == 'rental'){
                this.showFullDataCard = true
            }else this.showFullDataCard = false
        },
        'fav': function() {
            this.getData();
        },
        'flag': function() {
            this.getData();
        }
    },
    mounted(){
            this.getCompanyAgents()
    },
    computed: {
        format() {
            return this.formatAmPm ? '12' : '24'
        }
    },
    methods: {
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
        changeLeadStatus(type,id){
                if(type == 'fav'){
                    changeLeadFav({id:id}).then(response=>{
                        console.log(response)
                        if(this.leadData.favorite == 1){
                            document.getElementById("fav").style.color = "#caa42d"
                        }else
                            document.getElementById("fav").style.color = "unset"
                        
                        this.getData()
                        this.$emit("changeHint", null)
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }else if (type == 'hot'){
                    changeLeadHot({id:id}).then(response=>{
                        console.log(response)
                        if(this.leadData.hot == 1){
                            document.getElementById("hot").style.color = "#caa42d"
                        }else
                            document.getElementById("hot").style.color = "unset"
                        this.getData()
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
        selectEvent(){
            console.clear()
            let payload = [];
            this.projects.map(project=>{
                if (this.newCallData.location == project.location_id)
                    payload.push(project);
                if (this.newMeetingData.location == project.location_id)
                    payload.push(project);
                if (this.newRequestData.location == project.location_id)
                    payload.push(project);
            });
            this.options = payload;
        },
        getData(){
            this.isLoading = true
            getLeadData(this.hintId).then(response=>{
                console.log(response)
                this.leadData = response.data.lead
                this.ides.push(this.leadData.id)
                this.contacts = response.data.contacts
                this.newCallData.contact_id = 0
                this.newMeetingData.contact_id = 0
                this.newCallData.phone = this.leadData.phone
                this.selectedTags = response.data.lead.tags
                /*if(this.contacts.length > 0){
                    this.newCallData.contact_id = this.contacts[0].id
                }*/
                this.getHintTags()
                this.getOwnedUnits()
                this.getLeadSuggestions()
                this.LeadInterest()
                this.favoriteLead()
                this.getRequestPageData()
                this.isLoading = false
                this.getPublic()
                if(response.data.lead.status === "not_seen")
                this.$emit("changeHint", null)
            })
            .catch(error => {
                console.log(error)
            })
        },
        
        getShortName(){
            return this.leadData.first_name.charAt(0)+this.leadData.last_name.charAt(0)
        },
        getPublic(){
            getPublicData().then(response=>{
                //console.log(response)
                this.callStatus = response.data.callStatus
                this.projects = response.data.projects
                //console.log('this.projectssssssss');
                //console.log(this.projects);
                this.meetingStatus = response.data.meetingStatus
                this.locations = response.data.locations
                this.developers = response.data.developers
            })
            .catch(error => {
                console.log(error)
            })
        },
        getDevPro(event){
            getDevProjects(event.target.value).then(response=>{
                console.log(response)
                this.devProjects = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        unitsTypes(event){
            var usage = event.target.value
            getUnitTypes({usage: usage, _token: this.token}).then(response=>{
                console.log(response)
                this.unitTypes = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewToDo(){
            this.isLoading = true
            var data = {
                "_token": this.token,
                "user_id": this.userId,
                'leads': this.leadData.id,
                "to_do_type": this.todo.to_do_type,
                "due_date": this.todo.to_do_due_date,
                "description": this.todo.to_do_description,
            };
            console.log(data)
            addToDo(data).then(response=>{
                console.log(response)
                if(response.data.status == 501){
                    this.error('To Do')
                    this.isLoading = false
                }else {
                    //this.isLoading = false
                    this.newCallData = {}
                    this.call_status_id = 0
                    this.getData()
                    this.success('To Do')
                }

            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewCall(){
            this.isLoading = true
            let data = {
                "_token": this.token,
                "user_id": this.userId,
                'lead_id': this.leadData.id,
                "phone_in_out": this.phone_in_out,
                "contact_id": this.newCallData.contact_id,
                "phone": this.newCallData.phone,
                "call_status_id": this.call_status_id,
                "duration": this.newCallData.duration,
                "date": this.parsedDate,
                "probability": this.newCallData.probability ? this.newCallData.probability : 'normal',
                "budget": this.newCallData.budget,
                "location_id": this.newCallData.location,
                "projects": this.mapProjects(this.newCallData.projects),
                "description": this.newCallData.description,
                "to_do_type": this.newCallData.to_do_type,
                "to_do_due_date": this.newCallData.to_do_due_date,
                "to_do_description": this.newCallData.to_do_description,
            };
            console.log(data)
            addCall(data).then(response=>{
                console.log(response)
                if(response.data.status == 501){
                    this.error('Call')
                    this.isLoading = false
                }else {
                    //this.isLoading = false
                    if(this.call_status_id == 6 && (this.tab == 'cold_calls' || this.tab == 'today_cold_calls')){
                        console.log("TRUEEEEEEEEEEEEEEEEEEEE")
                        this.convertLeadCC();
                    }
                    this.newCallData = {}
                    this.call_status_id = 0
                    this.$emit("changeHint", null)
                    this.getData()
                    this.success('Call')
                }

            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewMeeting(){
            this.isLoading = true
            var data = {
                "_token": this.token,
                "user_id": this.userId,
                'lead_id': this.leadData.id,
                "contact_id": this.newMeetingData.contact_id,
                "phone": this.newMeetingData.phone,
                "meeting_status_id": this.meeting_status_id,
                "duration": this.newMeetingData.duration,
                "date": this.parsedDate,
                "time": this.time,
                "location": this.newMeetingData.location,
                "probability": this.newMeetingData.probability ?  this.newMeetingData.probability : 'normal',
                "budget": this.newMeetingData.budget,
                "projects":this.mapProjects(this.newMeetingData.projects),
                "description": this.newMeetingData.description,
                "to_do_type": this.newMeetingData.to_do_type,
                "to_do_due_date": this.newMeetingData.to_do_due_date,
                "to_do_description": this.newMeetingData.to_do_description,
            };
            console.log(data)
            addMeeting(data).then(response=>{
                console.log(response)
                console.log(response)
                if(response.data.status == 501){
                    this.error('Meeting')
                    this.isLoading = false
                }else {
                    this.newMeetingData = {}
                    this.meeting_status_id = 0
                    this.$emit("changeHint", null)
                    this.getData()
                    this.success('Meeting')
                }
                //this.isLoading = false

            })
            .catch(error => {
                console.log(error)
            })
        },

        mapProjects(projects = [], id = null){
            let payload = [];
            projects.map(project=>{
                payload.push(project.id);
            });

            return payload;
        },
        Addcontcatform: function() {
        this.Contactform.push({
            name: null,
            relation: null,
            phone: null,
            email: null,
            jobtitle: null,
        });
        },

        addNewRequest(){
            console.clear()
            this.isLoading = true
            var data = {
                'lead_id': this.leadData.id,
                "buyer_seller": this.newRequestData.buyer_seller,
                "location": this.newRequestData.location,
                "unit_type": this.newRequestData.unit_type,
                "unit_type_id": this.newRequestData.unit_type_id ? this.newRequestData.unit_type_id : 0,
                "request_type": this.request_type,
                "bathrooms_from": this.newRequestData.bathrooms_from,
                "bathrooms_to": this.newRequestData.bathrooms_to,
                "rooms_from": this.newRequestData.rooms_from,
                "rooms_to": this.newRequestData.rooms_to,
                "price_from": this.newRequestData.price_from,
                "price_to": this.newRequestData.price_to,
                "area_from": this.newRequestData.area_from,
                "area_to": this.newRequestData.area_to,
                "date": this.newRequestData.date,
                "down_payment": this.newRequestData.down_payment,
                "notes": this.newRequestData.notes,
                "project_id": this.mapProjects(this.newRequestData.projects),
            };
            console.log(data)
            addRequest(data).then(response=>{
                console.log(response)
                //this.isLoading = false
                this.newRequestData = {}
                this.getData()
                if (response.data.status == 'error')


                    this.error('Please Fille Required Date')
                else
                    this.success('Request')

            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewNote(){
            this.isLoading = true
            var data = {
                lead_id: this.leadData.id,
                user_id: this.userId,
                note: this.newNote,
                _token: this.token

            };
            console.log(data)
            addNote(data).then(response=>{
                console.log(response)
                //this.isLoading = false
                this.newRequestData = {}
                this.getData()
                this.success('Note')
            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewCILRequest(){
            this.isLoading = true
            var data = {
                lead_id: this.leadData.id,
                developer: this.cilData.dev,
                project: this.cilData.project,
                _token: this.token

            };
            addCILRequest(data).then(response=>{
                console.log(response)
                //this.isLoading = false
                if(response.data.status == 501){
                    this.error('CIL Request')
                    this.isLoading = false
                }else {
                    this.isLoading = false
                    this.cilData = {}
                    this.success('CIL Request')
                }
            })
            .catch(error => {
                console.log(error)
            })
        },
        showDue(type){
            this.showDueCard = false
            if(type == 'call') {
                if(this.call_status_id){
                    this.callStatus.forEach(element => {
                        if(this.call_status_id == element.id){
                            if(element.has_next_action){
                                this.showDueCard = true
                                console.log(this.showDueCard)
                            }
                        }
                    });
                }
            }else if(type == 'meeting'){
                if(this.meeting_status_id){
                    this.meetingStatus.forEach(element => {
                        if(this.meeting_status_id == element.id){
                            if(element.has_next_action){
                                this.showDueCard = true
                                console.log(this.showDueCard)
                            }
                        }
                    });
                }
            }

        },
        dateFormatter(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.parsedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        dateFormatter2(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.to_do_due_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        timeFormater(dt){
            var time = dt.toLocaleTimeString();
            this.time = time
            return time
        },
        sideClose() {
            this.sideView = false;
            this.$emit('closeSide', this.sideView);
        },
        success(action) {
            this.$toast.open({
                message: action+' Added Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        error(action) {
            this.$toast.open({
                message: action+' Adding Error, Check missing data',
                type: 'is-danger',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        getSuggestionsNew(){
            //this.isLoading = true
            var data = {
                'lead_id': this.leadData.id,
                "buyer_seller": this.newRequestData.buyer_seller,
                "location": this.newRequestData.location,
                "unit_type": this.newRequestData.unit_type,
                "unit_type_id": this.newRequestData.unit_type_id ? this.newRequestData.unit_type_id : 0,
                "request_type": this.request_type,
                "bathrooms_from": this.newRequestData.bathrooms_from,
                "bathrooms_to": this.newRequestData.bathrooms_to,
                "rooms_from": this.newRequestData.rooms_from,
                "rooms_to": this.newRequestData.rooms_to,
                "price_from": this.newRequestData.price_from,
                "price_to": this.newRequestData.price_to,
                "area_from": this.newRequestData.area_from,
                "area_to": this.newRequestData.area_to,
                "date": this.newRequestData.date,
                "down_payment": this.newRequestData.down_payment,
                "notes": this.newRequestData.notes,
                "project_id": this.mapProjects(this.newRequestData.projects),
            };
            if(data['project_id'].length > 0){
                if(data['request_type'] == "new_home"){
                    this.suggestionsActive = false
                    console.log("No Suggestions when there are projects selected")
                    return;
                }
            }
            console.log(data)
            this.suggestions_request_type = this.request_type    
            // $("#suggestions").html("");            
            getSuggestionsNew(data).then(response=>{
                console.log(response)
                // this.suggestions = response.data;
                this.units = response.data
                this.suggestionsActive = true
                //$('#suggestions').html(response.data);
                // this.leadData = response.data.lead
                // this.contacts = response.data.contacts
                // this.newCallData.contact_id = 0
                // this.newMeetingData.contact_id = 0
                // this.newCallData.phone = this.leadData.phone
                /*if(this.contacts.length > 0){
                    this.newCallData.contact_id = this.contacts[0].id
                }*/
                this.isLoading = false
            })
            .catch(error => {
                console.log(error)
            })
        },
        getOwnedUnits(){
            getOwnedUnits(this.hintId).then(response=>{
                console.log(response)
                this.resales = response.data.resales
                this.rentals = response.data.rentals
            })
            .catch(error => {
                console.log(error)
            })
        },
        switchLeadDialog(lead=0) {
            console.log('Lead info',lead)
            if(this.selectedLeads.length != 0){
                this.switchLeadModel = true
                console.log(this.selectedLeads);
            }else if(lead != 0){
                console.log(this.selectedLeads);
                // this.selectedLeads.push(lead.id)
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
                'leads':this.ides,
                '_token':this.token,
            }
            switchLeads(data).then(response=>{
                // console.log('preview_data',data)
                console.log(response)
                window.location.href="/admin/vue/IndividualLeads"
                // this.getData()
                this.switchLeadModel = false
                this.selectedLeads = []
                this.leadsIds = []
                this.success('Switched')
            })
                .catch(error => {
                console.log(error)
            })
        },
        viewResaleUnit(id){
            console.log(id)
            window.location.href = '/admin/resale_units/' + id
        },
        viewRentalUnit(id){
            console.log(id)
            window.location.href = '/admin/rental_units/' + id
        },
        getHintTags(){
            getHintTags().then(response=>{
                console.log("Tags")
                console.log(response.data)
                this.hintTags = response.data
            })
        },
        storeMultipleTags(){
            let selected = []
            for(let i=0;i<this.selectedTags.length;i++){
                selected.push(this.selectedTags[i]['id']);
            }
            var data = {
                'lead_id': this.leadData.id,
                'selected_tags': selected
            };
            storeMultipleTags(data).then(response=>{
                console.log("Saved Tags")
                console.log(response.data)
                this.ignoreSaveTags();
            })
        },
        addSuggestions(){
            var data = {
                'lead_id': this.leadData.id,
                'selected_suggestions': this.selectedSuggestions,
                'request_type': this.request_type
            };
            addSuggestions(data).then(response=>{
                this.newRequestData = {}
                this.suggestionsActive = false
                this.request_type = ''
                this.$emit("changeHint", null)
                this.getData()
                this.success('Suggestions')
                console.log(response.data)
            })
        },
        getLeadSuggestions(){
            getLeadSuggestions(this.leadData.id).then(response=>{
                console.log(response.data)
                this.leadResaleSuggestions = response.data['resale_suggestions'];
                this.leadRentalSuggestions = response.data['rental_suggestions'];
                this.leadNewHomeSuggestions = response.data['new_home_suggestions'];
            })
        },
        editTags(){
            this.disabled = false
            document.getElementById('editTag').style.display = "none"
            document.getElementById('saveTag').style.display = "block"
            document.getElementById('ignoreSaveTag').style.display = "block"
        },
        ignoreSaveTags(){
            this.disabled = true
            document.getElementById('editTag').style.display = "block"
            document.getElementById('saveTag').style.display = "none"
            document.getElementById('ignoreSaveTag').style.display = "none"
        },
        // OpenMassegeData(){
        //     console.log("dataNewMassege")
        // },
        MassegeLead(){
            let data = this.leadData
            console.log("lead-Request",data)
            GetLeadMassege(data).then(response=>{
                this.massegeArray = response.data
                console.log(response)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenMassegeData = true;
        },
        convertLeadCC(){
            convertLeadCC(this.hintId).then(response=>{
                console.log("Lead Converted Successfully From cold calls")
            })
            .catch(error => {
                console.log(error)
            })
},
        HistoryLead(){
            let data = this.leadData
            console.log("lead-Request",data)
            GetleadHistory(data).then(response=>{
                console.log(response)
                this.AppendHistoryArray = response.data
                console.log('Lead-History',this.AppendHistoryArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenHistory = true;
        },
        ContractsData(){
            let data = this.leadData
            GetLeadContracts(data).then(response=>{
                console.log(response)
                this.AppendContractsData = response.data
                console.log('Lead-contracts',this.AppendContractsData)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenContracts = true;
        },
        getRequestPageData(){
            let data = this.leadData
            FromrequestPage(data).then(response=>{
                this.requestLeadArray = response.data
                console.log('Lead request from get function request',requestLeadArray)
            }).catch(error=>{
                console.log(error)
            })
        },
        saveContacts(){
        let lead_id = this.leadData.id
        const bodyFormData = new FormData();

        for (let key in this.Contactform) {
            const value = this.Contactform[key];
            bodyFormData.append(
            "data" + "[" + key + "]",
            JSON.stringify(this.Contactform[key])
            );
        }
            bodyFormData.append("lead_id", lead_id);

        saveOtherContacts(bodyFormData)
            .then(response => {
            console.log(response);
            this.isAgendaModalActive = false;
            // return true;
            })
            .catch(error => {
            console.log(error);
            });
            this.LeadContact()
        },
        AddNewContact(){
            this.saveContacts();
        },
        LeadContact(){
            let data = this.leadData
            GetLeadContacts(data).then(response=>{
                console.log(response)
                this.AppendContactsData = response.data
                console.log('Lead-Contacts',this.AppendContactsData)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenContact = true
        },
        LeadInterest(){
            console.log("taaaaaaaaaaaabs inter")
            // console.log('get lead data',this.leadData)
            GetleadInterest(this.leadData).then(response=>{
                // console.log('intrest data',response)
                this.InterestArray = response.data
                // console.log('Lead-intrest',this.InterestArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenInterest =true
        },
        favoriteLead(){
        let data = this.leadData
            GetFavoriteLead(data).then(response=>{
                console.log(response)
                this.favoriteArray = response.data
                console.log('Leada-favorit',this.favoriteArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenFavorite = true
        },
        leadCils(){
            let data = this.leadData
            Getcilslead(data).then(response=>{
                console.log(response)
                this.cilsArray = response.data
                console.log('Lead-cils',this.cilsArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.openclis = true
        },
        website(){
            this.siteiconsmodel = true
        },
        HistoryLeadModel(){
            this.leadhistorymodel = true
        },
        historySwitchLead(){
            let data = this.leadData
                GetleadSwitchHistory(data).then(response=>{
                    console.log(response)
                    this.switchLeadArray = response.data
                    console.log('Lead-switched',this.switchLeadArray)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        // testtabs(value){
        //     if(value === 0){
        //         this.LeadInterest()
        //         console.log("tab of 0")
        //     }else if(value === 1){
        //         this.MassegeLead()
        //         console.log("tab of 1")
        //     }else if(value === 2){
        //         this.favoriteLead()
        //         console.log("tab of 2")
        //     }else if(value === 3){
        //         this.getRequestPageData()
        //         console.log("tab of 3")
        //     }
        // },
        HistoryTabs(value){
            if(value === 0){
                this.HistoryLead()
                console.log("tab one is active")
            }else if(value === 1){
                this.leadCils()
                console.log("tab history cils")
            }else{
                this.historySwitchLead()
            }
        },
        getAllCallstatus(){
            callstatus().then(response=>{
                this.StatusName = response.data.data
                console.log('Call status',response)
            })
            .catch(error => {
                console.log(error)
            })
        },
        ShowEditCallsModel(){
            console.log("this edit calls")
            this.getAllCallstatus()
            let data = this.leadData
            GetleadInfo(data).then(response=>{
                console.log(response)
                this.leadID = response.data[0].lead_id
                this.Leadinfoedit.first_name = response.data[0].first_name
                this.Leadinfoedit.phone = response.data[0].phone
                this.Leadinfoedit.duration = response.data[0].duration
                this.Leadinfoedit.status_name = response.data[0].status_name
                this.Leadinfoedit.created_at = response.data[0].created_at
                this.Leadinfoedit.probability = response.data[0].probability
                // this.Leadinfoedit = response.data
                console.log('Lead-Lead edit',this.Leadinfoedit)
            })
            .catch(error => {
                console.log(error)
            })

            this.EditCallsModel = true
        },
        EditLeadCall(){
        const bodyFormData = new FormData();
            for (const key in this.Leadinfoedit) {
                const value = this.Leadinfoedit[key]
                bodyFormData.set(key, value)
                // bodyFormData.tagsID.push(this.value[i].id)
                // console.log('tags',this.value)
            }
        bodyFormData.append("Lead_id",this.leadID)
        editCalls(bodyFormData)
        .then(response => {
        // this.responseStatus = response.status
        // if(response.status === 200)
        // this.isLoading = false
        console.log(response);
        // return true;
        })
        .catch(error => {
        console.log(error);
        });
        },
    }
}


</script>
<style>
.multiselect__tag,
.multiselect__option--highlight{
    background: #b07d12 !important;
}

.multiselect__tag-icon:hover{
    background: #b07d12 !important;
}
</style>
