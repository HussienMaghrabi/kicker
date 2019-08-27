<template lang="html">
    <div>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <full-calendar
        :events="calendarEvents"
        @event-selected="yourCalendarEventSelected"
        @day-click="dayClicked"
        ref="calendar"
        :config="config"
        ></full-calendar>
    <b-modal :active.sync="isImageModalActive">
        <form action>
          <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
              <p class="modal-card-title">{{clkDate}}</p>
            </header>
            <section class="modal-card-body">
              <b-field label="Agent">
                <b-select id="agent" placeholder="Select a name" v-model="agentIDYourCaln">
                  <option
                    v-for="agent in agentNames"
                    :value="agent.id"
                    :key="agent.id"
                  >{{ agent.name }}</option>
                </b-select>
              </b-field>

              <b-field label="Leads">
                <multiselect
                  :close-on-select="false"
                  :searchable="true"
                  v-model="value"
                  placeholder="Select Leads"
                  label="name"
                  track-by="id"
                  value="id"
                  :options="leadNames"
                  :multiple="true"
                  :taggable="true"
                  style="z-index: 1000000000;"
                ></multiselect>
              </b-field>

              <b-field label="Task Type">
                <b-select placeholder="Task Type" v-model="selectedTaskType">
                  <option value="call">Call</option>
                  <option value="meeting">Meeting</option>
                  <option value="others">Others</option>
                </b-select>
              </b-field>

              <b-field label="Description">
                <b-input v-model="desc" maxlength="200" type="textarea"></b-input>
              </b-field>
            </section>
            <footer class="modal-card-foot">
              <button
                class="button"
                type="button"
                @click="isImageModalActive = false"
              >Close</button>
              <button type="button" class="button is-success" @click="saveTodo">Submit</button>
            </footer>
          </div>
        </form>
      </b-modal>

      <b-modal :active.sync="isCallModalActive">
      <form action>
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Add Call</p>
          <i class="fas fa-trash" @click="confirmDelete(todoID)"></i>
          </header>
          <section class="modal-card-body">
            <b-collapse class="card">
              <div slot="trigger" slot-scope="props" class="card-header">
                <p class="card-header-title">Hint</p>
                <a class="card-header-icon">
                  <b-icon :icon="props.open ? 'menu-down' : 'menu-up'"></b-icon>
                </a>
              </div>
              <div class="card-content">
                <div class="content">
                  <b>Lead Name:</b>
                  {{leadName}}
                  <br>
                  <b>Your Description is:</b>
                  <br>
                  {{desc}}
                </div>
              </div>
            </b-collapse>
            <b-field label="Call In Or Out ?">
              <div class="control">
                <b-radio v-model="phone_in_out" native-value="out">Call Out</b-radio>
                <b-radio v-model="phone_in_out" native-value="in">Call In</b-radio>
              </div>
            </b-field>

            <b-field label="Contact">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newCallData.contact_id">
                    <option value="0" selected>Lead</option>
                    <option
                      v-for="contact in contacts"
                      :key="contact.id"
                      :value="contact.id"
                    >{{contact.name}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Phone">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newCallData.phone">
                    <option :value="phone" selected>{{phone}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Call Status">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="call_status_id">
                    <option
                      v-for="status in callStatus"
                      :key="status.id"
                      :value="status.id"
                    >{{status.name}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Date">
              <b-datepicker
                placeholder="Click to select..."
                :date-formatter="dateFormatter"
                position="is-bottom-left"
                v-model="newCallData.date"
              ></b-datepicker>
            </b-field>

            <div class="column is-12" v-if="showDueCard">
              <div class="card mb-8">
                <header class="card-header">
                  <p class="card-header-title">Next Action Data</p>
                </header>
                <div class="card-content cardContentDue">
                  <div class="content">
                    <div class="columns is-multiline is-mobile">
                      <div class="column is-6">
                        <div class="field">
                          <label class="label">To-Do Type</label>
                          <div class="control">
                            <div class="select is-fullwidth">
                              <select v-model="newCallData.to_do_type">
                                <option value="call">Call</option>
                                <option value="meeting">Meeting</option>
                                <option value="others">Other</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="column is-6">
                        <div class="field">
                          <b-field label="Due Date">
                            <datetime
                              type="datetime"
                              v-model="newCallData.to_do_due_date"
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
                      </div>

                      <div class="column is-12">
                        <div class="field">
                          <label class="label">Description</label>
                          <div class="control">
                            <textarea
                              class="textarea"
                              placeholder
                              v-model="newCallData.to_do_description"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <b-field label="Duration">
              <b-input v-model="newCallData.duration"></b-input>
            </b-field>

            <b-field label="Probability">
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
            </b-field>

            <b-field label="Budget">
              <b-input v-model="newCallData.budget"></b-input>
            </b-field>

            <b-field label="Location">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newCallData.location" @change="selectEvent">
                    <option
                      v-for="location in locations"
                      :key="location.id"
                      :value="location.id"
                    >{{location.en_name}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Projects">
              <div class="control">
                <div class="is-fullwidth">
                  <multiselect
                    :close-on-select="false"
                    v-model="newCallData.projects"
                    tag-placeholder="Add this as new tag"
                    placeholder="Select Projects"
                    label="en_name"
                    track-by="id"
                    value="id"
                    :options="options"
                    :multiple="true"
                    :taggable="true"
                    style="z-index: 1000000000;"
                  ></multiselect>
                </div>
              </div>
            </b-field>

            <b-field label="Description">
              <div class="control">
                <textarea class="textarea" placeholder v-model="newCallData.description"></textarea>
              </div>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isCallModalActive = false">Close</button>
            <button class="button is-link mr-10" @click="addNewCall">Submit</button>
            <a
              class="button is-danger is-meduim mr-10"
              v-if="showDueCard"
              @click="showDueCard = !showDueCard"
            >Remove Next Actions</a>
            <a
              class="button is-success is-meduim mr-10"
              v-else
              @click="showDueCard = !showDueCard"
            >Next Actions</a>
          </footer>
        </div>
      </form>
    </b-modal>

    <b-modal :active.sync="isMeetingModalActive">
      <form action>
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Add Meeting</p>
          <i class="fas fa-trash" @click="confirmDelete(todoID)"></i>

          </header>
          <section class="modal-card-body">
            <b-collapse class="card">
              <div slot="trigger" slot-scope="props" class="card-header">
                <p class="card-header-title">Hint</p>
                <a class="card-header-icon">
                  <b-icon :icon="props.open ? 'menu-down' : 'menu-up'"></b-icon>
                </a>
              </div>
              <div class="card-content">
                <div class="content">
                  <b>Lead Name:</b>
                  {{leadName}}
                  <br>
                  <b>Your Description is:</b>
                  <br>
                  {{desc}}
                </div>
              </div>
            </b-collapse>
            <b-field label="Contact">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newMeetingData.contact_id">
                    <option value="0" selected>Lead</option>
                    <option
                      v-for="contact in contacts"
                      :key="contact.id"
                      :value="contact.id"
                    >{{contact.name}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Meeting Status">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="meeting_status_id">
                    <option
                      v-for="status in meetingStatus"
                      :key="status.id"
                      :value="status.id"
                    >{{status.name}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <div class="column is-12" v-if="showDueCard">
              <div class="card mb-8">
                <header class="card-header">
                  <p class="card-header-title">Next Action Data</p>
                </header>
                <div class="card-content cardContentDue">
                  <div class="content">
                    <div class="columns is-multiline is-mobile">
                      <div class="column is-6">
                        <div class="field">
                          <label class="label">To-Do Type</label>
                          <div class="control">
                            <div class="select is-fullwidth">
                              <select v-model="newMeetingData.to_do_type">
                                <option value="call">Call</option>
                                <option value="meeting">Meeting</option>
                                <option value="others">Other</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="column is-6">
                        <div class="field">
                          <b-field label="Due Date">
                            <datetime
                              type="datetime"
                              v-model="newMeetingData.to_do_due_date"
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
                            <!--<b-datepicker
                                                placeholder="Click to select..."
                                                :date-formatter="dateFormatter2"
                                                position="is-bottom-left" v-model="newMeetingData.to_do_due_date">
                            </b-datepicker>-->
                          </b-field>
                        </div>
                      </div>

                      <div class="column is-12">
                        <div class="field">
                          <label class="label">Description</label>
                          <div class="control">
                            <textarea
                              class="textarea"
                              placeholder
                              v-model="newMeetingData.to_do_description"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <b-field label="Duration">
              <b-input v-model="newMeetingData.duration"></b-input>
            </b-field>

            <b-field label="Date">
              <b-datepicker
                placeholder="Click to select..."
                :date-formatter="dateFormatter"
                position="is-bottom-left"
                v-model="newMeetingData.date"
              ></b-datepicker>
            </b-field>

            <b-field label="Time">
              <b-timepicker
                placeholder="Select Time"
                :hour-format="format"
                v-model="newMeetingData.time"
                :time-formatter="timeFormater"
              ></b-timepicker>
            </b-field>

            <b-field label="Probability">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newMeetingData.probability">
                      <option value="Follow Up">Follow Up</option>
                      <option value="On going">On going</option>
                      <option value="Expected Closing">Expected Closing</option>
                      <option value="Closed">Closed</option>
                      <option value="Rotation">Rotation</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Budget">
              <b-input v-model="newMeetingData.budget"></b-input>
            </b-field>

            <b-field label="Location">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newMeetingData.location" @change="selectEvent">
                    <option
                      v-for="location in locations"
                      :key="location.id"
                      :value="location.id"
                    >{{location.en_name}}</option>
                  </select>
                </div>
              </div>
            </b-field>

            <b-field label="Projects">
              <div class="control">
                <div class="is-fullwidth">
                  <multiselect
                    :close-on-select="false"
                    v-model="newMeetingData.projects"
                    tag-placeholder="Add this as new tag"
                    placeholder="Select Projects"
                    label="en_name"
                    track-by="id"
                    value="id"
                    :options="options"
                    :multiple="true"
                    :taggable="true"
                    style="z-index: 1000000000;"
                  ></multiselect>
                </div>
              </div>
            </b-field>

            <b-field label="Description">
              <div class="control">
                <textarea class="textarea" placeholder v-model="newMeetingData.description"></textarea>
              </div>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isMeetingModalActive = false">Close</button>
            <button class="button is-link mr-10" @click="addNewMeeting">Submit</button>
            <a
              class="button is-danger is-meduim mr-10"
              v-if="showDueCard"
              @click="showDueCard = !showDueCard"
            >Remove Next Actions</a>
            <a
              class="button is-success is-meduim mr-10"
              v-else
              @click="showDueCard = !showDueCard"
            >Next Actions</a>
          </footer>
        </div>
      </form>
    </b-modal>

    <b-modal :active.sync="isCalenderModalActive">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Show To-Do</p>
          <i class="fas fa-trash" @click="confirmDelete(todoID)"></i>
        </header>
        <section class="modal-card-body">
          <p>
            <span style="font-weight: bold;">Leads:</span>
            {{ todoInfoLeads }}
          </p>
          <hr>
          <p>
            <span style="font-weight: bold;">Due Date:</span>
            {{ todoInfoDuedate }}
          </p>
          <hr>
          <p>
            <span style="font-weight: bold;">To-Do Type:</span>
            {{ todoInfoTodoType }}
          </p>
          <hr>
          <p>
            <span style="font-weight: bold;">Status:</span>
            {{ todoInfoStatus }}
          </p>
          <hr>
          <p>
            <span style="font-weight: bold;">phone:</span>
            {{ todoInfoPhone }}
          </p>
          <hr>
          <p>
            <span style="font-weight: bold;">Description:</span>
            {{ todoInfoDescription }}
          </p>
          <hr>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isCalenderModalActive = false">Close</button>
          <button class="button is-success" @click="confirmTodo">Done</button>
        </footer>
      </div>
    </b-modal>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import {
  fetchDashboardEvents,
  fetchDashboardSingleEventsYourCalender,
  getTeams,
  getAgents,
  teamCalendar,
  singleTodoTeamCalendar,
  getAgentNames,
  getLeadName,
  store,
  confirmTodo,
  addCall,
  addMeeting,
  getLeadData,
  getDevProjects,
  getPublicData,
  getLeadsByAgentId,
  deleteTodo
} from "../calls.js";

import { FullCalendar } from "vue-full-calendar";
import "fullcalendar/dist/fullcalendar.css";
import moment from "moment";
import Multiselect from "vue-multiselect";

export default {
  name: "HeaderFollowUp",

  data() {
    return {
      agentIDYourCaln: "",
      desc: "",
      leadID: "",
      meetingStatus: [],
      meeting_status_id: "",
      locations: [],
      options: [],
      callStatus: [],
      call_status_id: "",
      phone: "",
      contacts: [],
      phone_in_out: "out",
      showDueCard: false,
      newCallData: {
        duration: "",
        probability: "",
        contact_id: "",
        budget: "",
        description: "",
        to_do_type: "",
        to_do_due_date: null,
        to_do_description: "",
        projects: [],
        date: new Date(),
        location: null
      },
      newMeetingData: {
        date: new Date(),
        location: null,
        time: null
      },
      isLoading:true,
      newRequestData: {},
      isMeetingModalActive: false,
      isCallModalActive: false,
      todoID: "",
      selectedAgent: "",
      selectedTaskType: "",
      agentNames: [],
      leadName: "",
      leadNames: [],
      todoInfoAgent: "",
      todoInfoLeads: "",
      todoInfoDuedate: "",
      todoInfoTodoType: "",
      todoInfoStatus: "",
      todoInfoPhone: "",
      todoInfoDescription: "",
      calendarEvents: [],
      config: {
        selectable: true,
        defaultView: "month"
      },
      data: null,
      isImageModalActive: false,
      isCalenderModalActive: false,
      clkDate: "",
      value: null
    };
  },

  components: {
    FullCalendar,
    Multiselect
  },

  mounted() {
    this.fetchDashboardEvents();
    this.getAgentNames();
    this.getLeadName();
    this.getPublic();
  },

  computed: {
    format() {
      return this.formatAmPm ? "12" : "24";
    }
  },

  methods: {
    getPublic() {
      getPublicData()
        .then(response => {
          this.callStatus = response.data.callStatus;
          this.projects = response.data.projects;
          this.meetingStatus = response.data.meetingStatus;
          this.locations = response.data.locations;
          this.developers = response.data.developers;
          this.isLoading = false
        })
        .catch(error => {
          console.log(error);
        });
    },
    timeFormater(dt) {
      var time = dt.toLocaleTimeString();
      this.time = time;
      return time;
    },
    selectEvent() {
      let payload = [];
      this.projects.map(project => {
        if (this.newCallData.location == project.location_id)
          payload.push(project);
        if (this.newMeetingData.location == project.location_id)
          payload.push(project);
        if (this.newRequestData.location == project.location_id)
          payload.push(project);
      });
      this.options = payload;
    },
    addNewCall() {
      this.isLoading = true;
      let data = {
        _token: window.auth_user.csrf,
        user_id: window.auth_user.id,
        lead_id: this.leadData.id,
        phone_in_out: this.phone_in_out,
        contact_id: this.newCallData.contact_id,
        phone: this.phone,
        call_status_id: this.call_status_id,
        duration: this.newCallData.duration,
        date: this.parsedDate,
        probability: this.newCallData.probability
          ? this.newCallData.probability
          : "normal",
        budget: this.newCallData.budget,
        location_id: this.newCallData.location,
        projects: this.newCallData.projects,
        // "projects": this.mapProjects(this.newCallData.projects),
        description: this.newCallData.description,
        to_do_type: this.newCallData.to_do_type,
        to_do_due_date: this.newCallData.to_do_due_date,
        to_do_description: this.newCallData.to_do_description
      };
      addCall(data)
        .then(response => {
          if (response.data.status == 501) {
            this.error("Call");
            this.isLoading = false;
          } else {
            //this.isLoading = false
            this.newCallData = {};
            this.call_status_id = 0;
            this.getData();
            this.success("Call");
            this.isCallModalActive = false;
            this.confirmTodo();
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    addNewMeeting() {
      this.isLoading = true;
      let h = this.newMeetingData.time.getHours();
      let m = this.newMeetingData.time.getMinutes();
      let time = h + ":" + m;
      var data = {
        _token: window.auth_user.csrf,
        user_id: window.auth_user.id,
        lead_id: this.leadData.id,
        contact_id: this.newMeetingData.contact_id,
        phone: this.phone,
        meeting_status_id: this.meeting_status_id,
        duration: this.newMeetingData.duration,
        date: this.parsedDate,
        time: time,
        location: this.newMeetingData.location,
        probability: this.newMeetingData.probability
          ? this.newMeetingData.probability
          : "normal",
        budget: this.newMeetingData.budget,
        projects: this.newMeetingData.projects,
        // "projects":this.mapProjects(this.newMeetingData.projects),
        description: this.newMeetingData.description,
        to_do_type: this.newMeetingData.to_do_type,
        to_do_due_date: this.newMeetingData.to_do_due_date,
        to_do_description: this.newMeetingData.to_do_description
      };
      // console.log(data)
      addMeeting(data)
        .then(response => {
          // console.log(response)
          if (response.data.status == 501) {
            this.error("Meeting");
            this.isLoading = false;
          } else {
            this.newMeetingData = {};
            this.meeting_status_id = 0;
            this.getData();
            this.success("Meeting");
            this.isMeetingModalActive = false;
            this.confirmTodo();
          }
          //this.isLoading = false
        })
        .catch(error => {
          console.log(error);
        });
    },
    success(action) {
      this.$toast.open({
        message: action + " Added Successfully",
        type: "is-success",
        position: "is-bottom",
        duration: 5000
      });
    },
    error(action) {
      this.$toast.open({
        message: action + " Adding Error, Check missing data",
        type: "is-danger",
        position: "is-bottom",
        duration: 5000
      });
    },
    getData() {
      this.isLoading = true;
      getLeadData(this.leadID)
        .then(response => {
          this.leadData = response.data.lead || {};
          this.contacts = response.data.contacts;
          this.newCallData.contact_id = 0;
          this.newMeetingData.contact_id = 0;
          this.newCallData.phone = (this.leadData && this.leadData.phone) || "";
          this.phone = this.newCallData.phone;
          /*if(this.contacts.length > 0){
                this.newCallData.contact_id = this.contacts[0].id
            }*/
          this.isLoading = false;
          this.getPublic();
        })
        .catch(error => {
          console.log(error);
        });
    },
    dateFormatter(dt) {
      var date = dt.toLocaleDateString();
      const [month, day, year] = date.split("/");
      this.parsedDate = `${year}-${month.padStart(2, "0")}-${day.padStart(
        2,
        "0"
      )}`;
      return date;
    },
    saveTodo() {
      let agent = document.getElementById("agent");
      this.selectedAgent = agent.value;
      // console.log("agent id", this.selectedAgent)
      let leads = [];
      for (let i = 0; i < this.value.length; i++) {
        leads.push(this.value[i].id);
      }

      const bodyFormData = new FormData();
      for (const key in leads) {
        const value = leads[key];
        bodyFormData.set(key, value);
      }

      bodyFormData.append("agent_id", this.selectedAgent);
      // bodyFormData.append("leads", this.value);
      bodyFormData.append("leads", leads);
      bodyFormData.append("to_do_type", this.selectedTaskType);
      bodyFormData.append("description", this.desc);
      bodyFormData.append("due_date", this.clkDate);
      store(bodyFormData)
        .then(response => {
          console.log("TEsxhdsadk")
          console.log(response);
          this.isImageModalActive = false;
          this.fetchDashboardEvents();
          this.selectedAgent = "";
          this.value = [];
          this.selectedTaskType = "";
          this.desc = "";
          this.clkDate = "";
        })
        .catch(error => {
          console.log(error);
        });
    },
    fetchDashboardEvents() {
      const todayDateStr = moment().format("YYYY-MM-DD");
      // const todayDateStr = "2018-10-12";

      const params = {
        lang: "en",
        token: window.auth_user.token,
        user_id: window.auth_user.id,
        date: moment().format("YYYY-MM-DD"),
        // "date": "2018-10-12",
        date: todayDateStr
      };

      fetchDashboardEvents(params)
        .then(response => {
          // console.log("response.data ", response.data);
          return response.data;
        })
        .then(data => {
          const todayDateStr = moment().format("YYYY-MM-DD");
          // const todayDateStr = "2018-10-12";
          let events = [];
          for (let i = 0; i < data.length; i++) {
            if (data[i].status === "pending") {
              events.push(data[i]);
            }
          }
          // console.log("data.calendar", events)
          this.calendarEvents = events.map(curr => {
            if (curr.to_do_type === "call") {
              return {
                start: curr.due_date,
                title:
                  curr.to_do_type +
                  " " +
                  curr.name +
                  "\n" +
                  curr.dateTime12Formatted +
                  "\n" +
                  curr.description,
                data: curr,
                color: "#3493d4",
                textColor: "white"
              };
            } else if (curr.to_do_type === "meeting") {
              return {
                start: curr.due_date,
                title:
                  curr.to_do_type +
                  " " +
                  curr.name +
                  "\n" +
                  curr.dateTime12Formatted +
                  "\n" +
                  curr.description,
                data: curr,
                color: "#55adac",
                textColor: "white"
              };
            } else {
              return {
                start: curr.due_date,
                title:
                  curr.to_do_type +
                  " " +
                  curr.name +
                  "\n" +
                  curr.dateTime12Formatted +
                  "\n" +
                  curr.description,
                data: curr,
                color: "#f8c932",
                textColor: "black"
              };
            }
          });
          // this.$refs._slider.$refs._slider.init();
        })
        .catch(error => {
          console.error(error);
        });
    },

    confirmTodo() {
      let id = this.todoID;
      confirmTodo(id)
        .then(response => {
          // console.log(response);
          this.isCalenderModalActive = false;
          this.fetchDashboardEvents();
        })
        .catch(error => {
          console.log(error);
        });
    },

    yourCalendarEventSelected(event, jsEvent, view) {
      // this.isCalenderModalActive = true;
      // console.log("event", event.data)
      this.desc = event.data.description;
      this.leadName = event.data.name;
      this.leadID = event.data.leads;
      // getLeadsByAgentId()
      // .then((response) => {
      //   // this.contacts = response.data
      // })
      // .catch((error) => {
      //   console.log(error)
      // });
      this.getData();

      const id = event.data.id;
      this.todoID = id;
      // debugger
      // console.log("event id", id)
      fetchDashboardSingleEventsYourCalender(id)
        .then(response => {
          this.phone = response.data.lead.phone;
          this.lead_id = response.data.leads;
          // console.log("response data", response);

          if (response.data.lead) {
            this.todoInfoLeads =
              response.data.lead.first_name +
              " " +
              response.data.lead.last_name;
          } else {
            this.todoInfoLeads = "No Lead!.";
          }

          this.todoInfoDuedate = response.data.due_date;
          this.todoInfoTodoType = response.data.to_do_type;
          this.todoInfoStatus = response.data.status;
          this.todoInfoPhone = (response.data.lead || {}).phone;
          this.todoInfoDescription = response.data.description;
          if (event.data.to_do_type === "call") this.isCallModalActive = true;

          if (event.data.to_do_type === "meeting")
            this.isMeetingModalActive = true;

          if (event.data.to_do_type === "others")
            this.isCalenderModalActive = true;
        })
        .catch(error => {
          console.error(error);
        });
      // // console.log(event, jsEvent, view);
      // this.fetchDashboardSingleEventsYourCalender(id)
      // .then((response) => {
      //   console.log(response);
      // })
      // .catch((err) => {
      //   console.log(err);
      // });
    },

    dayClicked(date, jsEvent, view) {
      // console.log(" dayClicked 2 ");

      var selectedDate = date.format();

      // Selected date variables
      var selectedY = date.year();
      var selectedM = date.month();
      var selectedD = date.date();

      // current date variables
      var today = new Date();
      var cD = today.getDate();
      var cM = today.getMonth();
      var cY = today.getFullYear();

      if (selectedY >= cY && selectedM >= cM && selectedD >= cD) {
        this.desc = "";
        this.isImageModalActive = true;
      } else {
        this.isImageModalActive = false;
      }

      this.clkDate = selectedDate;
    },

    getAgentNames() {
      getAgentNames()
        .then(response => {
          // console.log("agents name ", response.data);
          this.agentNames = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    getLeadName() {
      getLeadName()
        .then(response => {
          this.leadNames = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    confirmDelete(id) {
      console.log(id);
      this.$dialog.confirm({
        title: "Deleting Todo",
        message: "Are you sure you want to <b>delete</b> this todo?",
        confirmText: "Delete Todo",
        type: "is-danger",
        hasIcon: true,
        onConfirm: () => this.deleteTodo(id)
      });
    },

    deleteTodo(id) {
      deleteTodo(id)
        .then(response => {
          this.isCalenderModalActive = false;
          this.isCallModalActive = false;
          this.isMeetingModalActive = false;
          this.fetchDashboardEvents();
          this.$toast.open({
            duration: 5000,
            message: `Todo is deleted successfully!`,
            position: "is-bottom",
            type: "is-danger"
          });
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style lang="css" scoped>
.fa-trash:hover {
  color: #cd3c3c;
  cursor: pointer;
}

.fa-trash {
  font-size: 1.25rem;
}
</style>
