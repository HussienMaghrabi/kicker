<template>
    <div class="container is-fluid">
      <div class="card">
          <header class="card-header level ">
            <div class="level">
                <div class="level-item">
                    <p class="card-header-title">
                        All Leads
                    </p>
                </div>
            </div>
          </header>
          <div class="filters_wrapper">
            <div class="columns is-multiline is-mobile mb-5 ml-0">
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
              <div class="column is-3">
                  <div class="field">
                      <label class="label">Projects</label>
                      <div class="control is-expanded">
                          <div class="select is-fullwidth">
                              <!-- <select v-model="filter.projects">
                                  <option v-for="project in projects" :key="project.id" :value="project.id">{{project.en_name}}</option>
                              </select> -->
                              <multiselect :close-on-select="false" v-model="filter.projects"  tag-placeholder="Add this as new tag" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="projects" :multiple="true" :taggable="true" style="z-index: 1000000000;"></multiselect>
                          </div>
                      </div>

                  </div>
              </div>
               <div class="column is-3">
                  <label class="label">Lead source</label>
                  <div class="control">
                      <div class="select is-fullwidth">
                          <!-- <select v-model="filter.sourceId">
                              <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
                          </select> -->
                          <multiselect :close-on-select="false" v-model="filter.sourceId"  tag-placeholder="Add this as new tag" placeholder="Select Lead Sources" label="name" track-by="id" value="id" :options="leadSources" :multiple="true" :taggable="true" style="z-index: 1000000000;"></multiselect>
                      </div>
                  </div>
              </div>
              <div class="column is-3   " v-if="userType == 'admin'">
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
              <div class="column is-3">
                 <label class="label">Leads With No Action</label>
                 <div class="control">
                     <div class="select is-fullwidth">
                       <select v-model="leadsNoAction">
                           <option value="residential">Residential</option>
                           <option value="commercial">Commercial</option>
                           <option value="both">Both</option>
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
                 </div>
             </div>
            </div>
          </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
      </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import {getPublicData,getAgents,getLeadSources,deleteFilteredLeads} from './../../calls'
import Multiselect from 'vue-multiselect'
export default {
  data() {
    return {
      isLoading: false,
      isFullPage: true,
      selectedLeads: [],
      callStatus: [],
      projects: [],
      leadSources: [],
      locations: [],
      meetingStatus:[],
      filter:{},
      token: window.auth_user.csrf,
      userId: window.auth_user.id,
      userType: window.auth_user.type,
      leadsNoAction: '',
      parsedDateTo: '',
      parsedDateFrom: '',
      allAgents: [],
      permArray: [],
      groups: [],
      commercialAgents: [],
      residentialAgents: [],
    }
  },
  mounted() {
      this.getCompanyAgents()
      this.getPublic()
  },
  components: {
      Multiselect,
  },
  created() {
      this.getSources()
  },
  methods: {
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
    filterLeads(scrollSwitch = false){
        this.isLoading = true
        this.fitlerFlag = true
        var data ={
            'leadSources':this.filter.sourceId,
            'project':this.filter.projects,
            'meetingStatus':this.filter.meeting_status_id,
            'callStatus':this.filter.call_status_id,
            'dateTo':this.parsedDateTo,
            'dateFrom':this.parsedDateFrom,
            '_token':this.token,
            "agent_id": this.filter.selectedAgent,
            "group_id": this.filter.selectedGroup,
            'leadsNoAction': this.leadsNoAction,
        };
        console.log("TEST1")
        console.log(data)
        deleteFilteredLeads(data).then(response=>{
            console.log("TEST2")
            console.log(response)
            this.leads = response.data.data
            this.leadsCurrentNumber = response.data.data.length;
            this.leadsTotalNumber = response.data.total
            this.perPage = response.data.per_page;
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

  }

}
</script>

<style>
.filters_wrapper{
  margin: 0 20px;
}
.container.is-fluid {
    margin-left: 30px;
    margin-right: 30px;
}

.card-content {
    padding: 10px 10px 10px 10px;
}
.card-header {
    margin-bottom: 2.5em !important;
}
.modal-card-body {
    text-align: left;
}
.content figure:not(:last-child) {
    margin-bottom: .5em;
}

.navbar {
    margin-bottom: 0;
    border-bottom: 2px solid #f9d176;
}

.navbar .level{
    margin-bottom: 0;
}
html.has-navbar-fixed-top, body.has-navbar-fixed-top {
    padding-top: 6.25rem;
}
.content ul {
    margin-left: 0em;
    margin-top: 0em;
    border-bottom-width: 0px;
}
li.is-active {
    background: #b07d12;
}
li.is-active a {
    color : #ffff !important;
    border-bottom-color: #b07d12;
}

.tabs a {
    border-bottom-width: 0px;
}
</style>
