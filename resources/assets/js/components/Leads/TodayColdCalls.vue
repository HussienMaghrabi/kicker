<template>
  <div>
    <div class="level mb-5">
      <div class="level">
          <div class="level-item">

          </div>
      </div>

      <div class="level">
          <div class="level-item filters">
              <a v-if="authType === 'admin'" class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="autoSwitchDialog('0')">Auto Switch</a>
              <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkActionDialog('0')">Bulk Action</a>
              <a class="button is-success is-small filter-btn" style="margin-right: 50px;" @click="bulkDeleteDialog('0')">Bulk Delete</a>

              <div class="field  mr-10">
                  <div class="control">
                      <input class="input is-meduim mt-10" type="text" placeholder="Search" v-model="searchInput" @input="search">
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
      default-sort="id"
    >
      <template slot-scope="props">
        <b-table-column field="id" label="ID" sortable>{{props.row.id}}</b-table-column>

        <b-table-column
          field="first_name"
          label="Name"
          sortable
        >{{props.row.first_name+' '+props.row.last_name}}</b-table-column>
        <b-table-column field="tag" label="Tag" sortable>{{props.row.tag}}</b-table-column>
        <b-table-column field="phone" label="Hint" centered>
          <i class="fa fa-eye" aria-hidden="true" @click="openHint(props.row.id)"></i>
        </b-table-column>

        <b-table-column field="email" label="Email" sortable>
          <a :href="'mailto:'+props.row.email">{{props.row.email}}</a>
        </b-table-column>

        <b-table-column field="phone_iso" label="CO" sortable>
            {{props.row.phone_iso}}
        </b-table-column>

        <b-table-column field="phone" label="Phone" sortable>{{props.row.phone}}</b-table-column>

        <b-table-column field="sourceName" label="Source" sortable>{{props.row.sourceName}}</b-table-column>

        <b-table-column field="created_at" label="Created At" sortable>{{props.row.created_at}}</b-table-column>

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

        <b-table-column
          field="id"
          label="Switch"
          centered
          v-if="permArray.switch_leads == 1 || userType == 'admin'"
        >
          <a class="button is-success is-small" @click="switchLeadDialog(props.row)">Switch</a>
        </b-table-column>
      </template>

      <template slot="empty" v-if="!isLoading && isEmpty">
        <section class="section">
          <div class="content has-text-grey has-text-centered">
            <p>
              <b-icon icon="emoticon-sad" size="is-large"></b-icon>
            </p>
            <p>Nothing here.</p>
          </div>
        </section>
      </template>
    </b-table>
    <div class="leads-number">{{leadsCurrentNumber + ' / ' + leadsTotalNumber}}</div>
    <!-- <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading> -->
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
                  <option
                    v-for="rAgent in residentialAgents"
                    :key="rAgent.id"
                    :value="rAgent.id"
                  >{{rAgent.name}}</option>
                </select>
              </div>
            </div>
          </div>

          <div class="field">
            <label class="label">Commercial Agent</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select v-model="switchLeadData.cAgent">
                  <option
                    v-for="cAgent in commercialAgents"
                    :key="cAgent.id"
                    :value="cAgent.id"
                  >{{cAgent.name}}</option>
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
                    <button class="button is-link" @click="bulkActionAction">Bulk Actoin</button>
                </footer>
            </div>
        </b-modal>
    <!-- Hint Component -->
    <Hint
      :class="{openSide: ShowHint}"
      @closeSide="ShowHint = $event"
      :hintId="hintId"
      :sideView="ShowHint"
      @changeHint="refreshPage"
      :tab="'today_cold_calls'"
    ></Hint>
  </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {
  getTodayColdCalls,
  deleteLead,
  switchLeads,
  searchForLead,
  getAgents,
  checkUserGroupAndRoles,
  autoSwitchAPi,
  bulkActions,
  getPublicData

} from "./../../calls";
import Hint from "./Hint";
import Multiselect from 'vue-multiselect';
export default {
  data() {
    return {
      leads: [],
      isEmpty: false,
      isLoading: true,
      hasMobileCards: true,
      isPaginated: true,
      isPaginationSimple: false,
      defaultSortDirection: "desc",
      leadsCurrentNumber: 0,
      leadsTotalNumber: 0,
      total: 0,
      page: parseInt(this.$route.hash.split('/')[1]),
      perPage: 100,
      authType: window.auth_user.type,

      isLoading: true,
      isFullPage: true,
      searchInput: "",
      selectedLeads: [],
      token: window.auth_user.csrf,
      userId: window.auth_user.id,
      userType: window.auth_user.type,
      switchLeadModel: false,
      switchLeadData: {},
      leadsIds: [],
      ShowHint: false,
      hintId: "",
      commercialAgents: [],
      residentialAgents: [],
      permArray: [],
      autoSwitchModel: false,
      autoSwitchData: {},
      bulkActionModel: false,
      newCallData: {date: new Date()},
      call_status_id: null,
      callStatus: [],
      
    };
  },

  mounted() {
    this.checkUserHasGroup();
    this.getCompanyAgents();
    this.getData();
  },
  components: {
    Hint,
    Multiselect
  },
  created() {
    this.$router.replace({hash: '#/1'});
  },
  methods: {
    refreshPage() {
      this.getData();
    },
    getPublic(){
      getPublicData().then(response=>{
          this.callStatus = response.data.callStatus
      })
      .catch(error => {
          console.log(error)
      })
    },
    getData(scrollSwitch = false) {
      this.isLoading = true;
      getTodayColdCalls(this.page)
        .then(response => {
          console.log(response);
          this.perPage = response.data.per_page
          this.leadsCurrentNumber = Math.min(
            response.data.total,
            this.page * this.perPage
          );
          this.leadsTotalNumber = response.data.total;
          this.leads = response.data.data;

          if (this.leads.length == 0) {
            this.isEmpty = true;
          }
          let currentTotal = response.data.total;
          if (response.data.total / this.perPage > 1000) {
            currentTotal = this.perPage * 1000;
          }
          this.total = currentTotal;
          this.isLoading = false;
          this.getPublic()
        })
        .catch(error => {
          console.log(error);
        });
    },
    search() {
      if (this.searchInput) {
        //this.isLoading = true
        var data = {
          searchInput: this.searchInput,
          _token: this.token,
          agent_id: this.userId
        };
        searchForLead(data)
          .then(response => {
            console.log(response);
            this.leads = response.data;
            //this.isLoading = false
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    leadActions(event, id) {
      var action = event.target.value;
      if (action == "show") {
        window.location = "/admin/leads/" + id;
      } else if (action == "edit") {
        window.location = "/admin/leads/" + id + "/edit";
      } else if (action == "delete") {
        this.confirmDelete(id);
      }
    },
    switchLeadDialog(lead = 0) {
      if (this.selectedLeads.length != 0) {
        this.switchLeadModel = true;
        console.log(this.residentialAgents);
      } else if (lead != 0) {
        this.selectedLeads.push(lead);
        this.switchLeadModel = true;
      } else {
        this.errorDialog();
      }
    },
    switchLeadAction() {
      this.isLoading = true;
      console.log(this.selectedLeads);
      this.selectedLeads.forEach(element => {
        this.leadsIds.push(element.id);
      });

      var data = {
        agent_id: this.switchLeadData.rAgent,
        commercial_agent_id: this.switchLeadData.cAgent,
        leads: this.leadsIds,
        _token: this.token
      };
      switchLeads(data)
        .then(response => {
          console.log(response);
          this.getData();
          this.switchLeadModel = false;
          this.selectedLeads = [];
          this.leadsIds = [];
          this.success("Switched");
        })
        .catch(error => {
          console.log(error);
        });
    },
    confirmDelete(id) {
      this.$dialog.confirm({
        title: "Deleting Lead",
        message: "Are you sure you want to <b>delete</b> Lead?",
        confirmText: "Delete Lead",
        type: "is-danger",
        hasIcon: true,
        onConfirm: () => this.deleteThisLead(id)
      });
    },
    deleteThisLead(id) {
      this.isLoading = true;
      deleteLead(id)
        .then(response => {
          console.log(response);
          this.getData();
          this.success("Deleted");
        })
        .catch(error => {
          console.log(error);
        });
    },
    onPageChange(page) {
      this.page = page;
      this.$router.replace({ name: "todaycoldcalls", params: { page: page } });
      this.getData();
    },
    success(action) {
      this.$toast.open({
        message: "Lead " + action + " Successfully",
        type: "is-success",
        position: "is-bottom",
        duration: 5000
      });
    },
    errorDialog() {
      this.$dialog.alert({
        title: "Error",
        message: "Please select the leads you want to switch frist",
        type: "is-danger"
      });
    },
    getCompanyAgents() {
      getAgents()
        .then(response => {
          console.log(response);
          this.commercialAgents = response.data.commercialAgents;
          this.residentialAgents = response.data.residentialAgents;
        })
        .catch(error => {
          console.log(error);
        });
    },
    checkUserHasGroup() {
      checkUserGroupAndRoles()
        .then(response => {
          console.log(response);
          this.teamLeader = response.data.leaderHasGroup;
          this.permArray = response.data.permArray;
        })
        .catch(error => {
          console.log(error);
        });
    },
    openHint(id) {
      this.ShowHint = true;
      this.hintId = id;
    },
    autoSwitchDialog(lead=0) {
        console.clear()
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
        this.selectedLeads.forEach(element => {
            this.leadsIds.push(element.id)
        });

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
            if(response.data.status == 501){
              this.error('Call')
              this.isLoading = false
            }else {
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
  }
};
</script>

<style type="text/css" scoped="">
.leads-number {
  position: absolute;
  left: 200px;
  bottom: 45px;
}

@media screen and (max-width: 767px) {
  .leads-number {
    right: 10% !important;
    bottom: 10px !important;
    left: unset !important;
  }
}
</style>
