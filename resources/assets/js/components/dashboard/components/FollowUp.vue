<template>
  <div class="row">
    <div class="sections" id="followUP">
      <label style="display: inline-block; max-width: 100%; margin-bottom: 25px; font-weight: 700;">
        <div>
          <img
            src="/icon/Follow up-05.png"
            style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
          >
          <h2 style="float: right; margin-top: 8%; font-size: 25px; font-weight: bold;">Tasks</h2>
        </div>
      </label>

      <div class="columns"  :key="reloadKey">
        <div class="column">
        <h2 style="margin-left: 4%; font-size: 22px; font-weight: bold;">Today Tasks</h2>
          <div class="rows" id="scroll" style="height: 268px; overflow: auto;">
            <div
              v-for="todayFollowUp in todayFollowUpEvents"
              :key="todayFollowUp.id"
              class="row followSection"
              :style="{'background-color': getFollowUpSectionColor(todayFollowUp)}"
            >
              <div class="columns is-mobile">
                <div class="column is-1">
                  <img
                    :src="getFollowUpSectionIconPath(todayFollowUp)"
                    style="width: 35px; margin-left: 10%"
                  >
                </div>
                <div class="column is-8" style="margin-left: 3%;">
                  <p style="color: black; font-size: 16px">{{ todayFollowUp.name }}</p>
                  <p style="color: white; font-size: 15px">{{ todayFollowUp.phone }}</p>
                  <p style="font-size: 14px;">{{ todayFollowUp.description }}</p>
                  <p style="color: white; font-size: 15px">{{ todayFollowUp.dateTime12Formatted }}</p>
                </div>
                <div class="column is-3" style="position: relative">
                  <!-- <p style="color: black; font-size: 14px;">{{ todayFollowUp.time }}</p> -->
                  <p
                    style="color: black; font-size: 14px;"
                  >{{todayFollowUp.datetime24Formatted | momentFromNow}}</p>
                  <img
                    src="/icon/Follow up-06.png"
                    style="width: 25%; cursor: pointer"
                    @click="openTodoModel(todayFollowUp)"
                  >
          <i class="fas fa-trash" @click="confirmDelete(todayFollowUp.id)"></i>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="column">
          <h2 style="margin-left: 4%; font-size: 22px; font-weight: bold;">Delayed Tasks</h2>
          <div class="rows" id="scroll" style="height: 268px; overflow: auto;">
            <div
              v-for="prevFollowUp in prevFollowUpEvents"
              :key="prevFollowUp.id"
              class="row followSection"
              :style="{'background-color': getPrevFollowUpSectionColor(prevFollowUp)}"
            >
              <div class="columns is-mobile">
                <div class="column is-1">
                  <img
                    :src="getFollowUpSectionIconPath(prevFollowUp)"
                    style="width: 35px; margin-left: 10%"
                  >
                </div>
                <div class="column is-8" style="margin-left: 3%;">
                  <p style="color: black; font-size: 16px;">{{ prevFollowUp.name }}</p>
                  <p style="color: white; font-size: 15px">{{ prevFollowUp.phone }}</p>
                  <p style="font-size: 14px;">{{ prevFollowUp.description }}</p>
                  <p
                    style="color: white; font-size: 14px;"
                  >{{ prevFollowUp.due_date }} {{ prevFollowUp.dateTime12Formatted }}</p>
                </div>
                <div class="column is-3" style="position: relative">
                  <p
                    style="color: black; font-size: 14px;"
                  >{{prevFollowUp.due_date | momentFromNow}}</p>
                  <img
                    src="/icon/Follow up-06.png"
                    style="width: 20%; cursor: pointer"
                    @click="openTodoModel(prevFollowUp)"
                  >
          <i class="fas fa-trash" @click="confirmDelete(prevFollowUp.id)"></i>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <b-modal :active.sync="isCallModalActive">
        <form action>
          <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
              <p class="modal-card-title">Add Call</p>
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
                    <select v-model="newMeetingDataFollowUp.contact_id">
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
                                <select v-model="newMeetingDataFollowUp.to_do_type">
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
                                v-model="newMeetingDataFollowUp.to_do_due_date"
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
                                                position="is-bottom-left" v-model="newMeetingDataFollowUp.to_do_due_date">
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
                                v-model="newMeetingDataFollowUp.to_do_description"
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
                <b-input v-model="newMeetingDataFollowUp.duration"></b-input>
              </b-field>

              <b-field label="Date">
                <b-datepicker
                  placeholder="Click to select..."
                  :date-formatter="dateFormatter"
                  position="is-bottom-left"
                  v-model="newMeetingDataFollowUp.date"
                ></b-datepicker>
              </b-field>

              <b-field label="Time">
                <b-timepicker
                  placeholder="Select Time"
                  :hour-format="format"
                  v-model="newMeetingDataFollowUp.time"
                  :time-formatter="timeFormater"
                ></b-timepicker>
              </b-field>

              <b-field label="Probability">
                <div class="control">
                  <div class="select is-fullwidth">
                    <select v-model="newMeetingDataFollowUp.probability">
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
                <b-input v-model="newMeetingDataFollowUp.budget"></b-input>
              </b-field>

              <b-field label="Location">
                <div class="control">
                  <div class="select is-fullwidth">
                    <select v-model="newMeetingDataFollowUp.location" @change="selectEvent">
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
                      v-model="newMeetingDataFollowUp.projects"
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
                  <textarea
                    class="textarea"
                    placeholder
                    v-model="newMeetingDataFollowUp.description"
                  ></textarea>
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
    </div>
  </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import moment from "moment";
import Multiselect from "vue-multiselect";
import {
  getDevProjects,
  addCall,
  getPublicData,
  getLeadSources,
  getLeadData,
  addMeeting,
  fetchDashboardEvents,
  getLeadsByAgentId,
  confirmTodo,
  deleteTodo
} from "../../../calls";
import { log } from "util";

export default {
  name: "FollowUp",
  components: { Multiselect },
  computed: {
    format() {
      return this.formatAmPm ? "12" : "24";
    }
  },
  props: {
    todayFollowUpEvents: {
      type: Array,
      required: true
    },
    prevFollowUpEvents: {
      type: Array,
      required: true
    }
  },
  watch: {
    call_status_id: function(newId, oldId) {
      this.showDue("call");
    }
  },
  data() {
    return {
      todoInfoLeads: "",
      todoInfoDuedate: "",
      todoInfoTodoType: "",
      todoInfoStatus: "",
      todoInfoPhone: "",
      todoInfoDescription: "",
      reloadKey: 0,
      desc: "",
      isCallModalActive: false,
      isMeetingModalActive: false,
      isCalenderModalActive: false,
      leadData: {},
      contacts: [],
      isLoading: false,
      callStatus: [],
      projects: [],
      locations: [],
      developers: [],
      devProjects: [],
      meetingStatus: [],
      newCallData: { date: new Date() },
      newMeetingDataFollowUp: { date: new Date(), time: null },
      newRequestData: {},
      token: window.auth_user.csrf,
      userId: window.auth_user.id,
      phone_in_out: "out",
      call_status_id: "",
      meeting_status_id: "",
      request_type: "",
      showDueCard: false,
      formatAmPm: true,
      newNote: "",
      showPhone: false,
      unitTypes: [],
      todo: {},
      cilData: {},
      showFullDataCard: false,
      options: [],
      phone: "",
      meetingPhone: "",
      todoID: "",
      leadName: ""
    };
  },
  methods: {
    getFollowUpSectionIconPath(followupEvent) {
      // console.log(followupEvent.to_do_type);

      if (followupEvent.to_do_type === "call") {
        return "/icon/Follow up-02.png";
      } else if (followupEvent.to_do_type === "meeting") {
        return "/icon/Follow up-03.png";
      } else if (
        followupEvent.to_do_type === "todo" ||
        followupEvent.to_do_type === "task" ||
        followupEvent.to_do_type === "others"
      ) {
        return "/icon/Follow up-04.png";
      }
    },

    // Today FollowUp Sections color
    getFollowUpSectionColor(followupEvent) {
      // let hours = moment
      //   .duration(moment(new Date()).diff(followupEvent.datetime24Formatted))
      //   .asHours();
      let fullhours = moment(followupEvent.datetime24Formatted).fromNow();
      let hours = fullhours.substr(0, fullhours.indexOf(" "));
      if (hours === "an") {
        hours = 1;
      }
      // console.log("hours", hours)

      if (hours === 1) {
        return "#45aeae";
      } else if (hours == 2) {
        return "#fcc82b";
      } else if (hours >= 3) {
        return "#3e7b97";
      } else if (hours === "in" || hours === "a") {
        return "#2a7d3a";
      }
    },

    // Prev FollowUp Sections color
    getPrevFollowUpSectionColor(followupEvent) {
      let days = moment().diff(moment(followupEvent.due_date), "days");
      // console.log("days ", days);

      if (days === 1) {
        return "#FFC30F";
      } else if (days === 2) {
        return "#FF5733";
      } else if (days >= 3) {
        return "#C70039";
      }
    },

    openTodoModel(todo) {
      if (todo.to_do_type === "call") {
        // console.log("tag", todo);
        this.phone = todo.phone;
        this.leadData.id = todo.leads;
        this.todoID = todo.id;
        this.desc = todo.description;
        this.leadName = todo.name;
        this.isCallModalActive = true;
      } else if (todo.to_do_type === "meeting") {
        this.leadData.id = todo.leads;
        this.meetingPhone = todo.phone;
        this.todoID = todo.id;
        this.desc = todo.description;
        this.leadName = todo.name;
        this.isMeetingModalActive = true;
        // console.log("lead id from meeting is ", this.leadData.id)
      } else if (todo.to_do_type === "others") {
        this.todoID = todo.id;
        this.todoInfoLeads = todo.name;
        this.todoInfoDuedate = todo.due_date + " " + todo.dateTime12Formatted;
        this.todoInfoTodoType = todo.to_do_type;
        this.todoInfoStatus = todo.status;
        this.todoInfoPhone = todo.phone;
        this.todoInfoDescription = todo.description;
        this.isCalenderModalActive = true;
      }
    },

    addNewCall() {
      this.isLoading = true;
      let data = {
        _token: this.token,
        user_id: this.userId,
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

    getData() {
      this.isLoading = true;
      getLeadData(this.hintId)
        .then(response => {
          this.leadData = response.data.lead || {};
          this.contacts = response.data.contacts;
          this.newCallData.contact_id = 0;
          this.newMeetingDataFollowUp.contact_id = 0;
          this.newCallData.phone = (this.leadData && this.leadData.phone) || "";
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

    getPublic() {
      getPublicData()
        .then(response => {
          this.callStatus = response.data.callStatus;
          this.projects = response.data.projects;
          this.meetingStatus = response.data.meetingStatus;
          this.locations = response.data.locations;
          this.developers = response.data.developers;
        })
        .catch(error => {
          console.log(error);
        });
    },

    selectEvent() {
      let payload = [];
      this.projects.map(project => {
        if (this.newCallData.location == project.location_id)
          payload.push(project);
        if (this.newMeetingDataFollowUp.location == project.location_id)
          payload.push(project);
        if (this.newRequestData.location == project.location_id)
          payload.push(project);
      });
      this.options = payload;
    },

    getDevPro(event) {
      getDevProjects(event.target.value)
        .then(response => {
          // console.log(response);
          this.devProjects = response.data;
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

    timeFormater(dt) {
      var time = dt.toLocaleTimeString();
      this.time = time;
      return time;
    },

    showDue(type) {
      this.showDueCard = false;
      if (type == "call") {
        if (this.call_status_id) {
          this.callStatus.forEach(element => {
            if (this.call_status_id == element.id) {
              if (element.has_next_action) {
                this.showDueCard = true;
                // console.log(this.showDueCard);
              }
            }
          });
        }
      } else if (type == "meeting") {
        if (this.meeting_status_id) {
          this.meetingStatus.forEach(element => {
            if (this.meeting_status_id == element.id) {
              if (element.has_next_action) {
                this.showDueCard = true;
                // console.log(this.showDueCard);
              }
            }
          });
        }
      }
    },

    addNewMeeting() {
      this.isLoading = true;
      let h = this.newMeetingDataFollowUp.time.getHours();
      let m = this.newMeetingDataFollowUp.time.getMinutes();
      let time = h + ":" + m;
      var data = {
        _token: this.token,
        user_id: this.userId,
        lead_id: this.leadData.id,
        contact_id: this.newMeetingDataFollowUp.contact_id,
        phone: this.meetingPhone,
        meeting_status_id: this.meeting_status_id,
        duration: this.newMeetingDataFollowUp.duration,
        date: this.parsedDate,
        time: this.newMeetingDataFollowUp.time,
        location: this.newMeetingDataFollowUp.location,
        probability: this.newMeetingDataFollowUp.probability
          ? this.newMeetingDataFollowUp.probability
          : "normal",
        budget: this.newMeetingDataFollowUp.budget,
        projects: this.newMeetingDataFollowUp.projects,
        // "projects":this.mapProjects(this.newMeetingDataFollowUp.projects),
        description: this.newMeetingDataFollowUp.description,
        to_do_type: this.newMeetingDataFollowUp.to_do_type,
        to_do_due_date: this.newMeetingDataFollowUp.to_do_due_date,
        to_do_description: this.newMeetingDataFollowUp.to_do_description
      };
      // console.log(data)
      addMeeting(data)
        .then(response => {
          // console.log(response)
          // console.log(response)
          if (response.data.status == 501) {
            this.error("Meeting");
            this.isLoading = false;
          } else {
            this.newMeetingDataFollowUp = {};
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

    confirmTodo() {
      let id = this.todoID;
      confirmTodo(id)
        .then(response => {
          // console.log(response);
          this.isCalenderModalActive = false;

          this.$emit("newFollow", null);
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

    getLeadsByAgentId() {
      getLeadsByAgentId()
        .then(response => {
          // console.log("response data from follow up", response)
          // this.contacts = response.data
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
          this.$emit("newFollow", null);
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
  },
  mounted() {
    try {
      this.getData();
      this.getPublic();
      this.selectEvent();
      // this.getDevPro();
      // this.dateFormatter();
      this.getLeadsByAgentId();
    } catch (e) {
      console.log("e ", e);
    }

    // console.log("this.$props followup ", this.$props);
    // console.log("this ", this);
  },

  filters: {
    momentFromNow(date) {
      return moment(date).fromNow();
    }

    // todayMomentFromNow(date) {
    //   var diff =(dt2.getTime() - dt1.getTime()) / 1000;
    //   diff /= (60 * 60);
    //   return Math.abs(Math.round(diff));
    // }
  }
};
</script>
<style scoped>
.sections,
.right-side {
  background: #f2e8da;
  margin-bottom: 5%;
  padding-bottom: 3%;
  height: fit-content;
}

.sections h2 {
  font-size: 30px;
  margin-bottom: 3%;
}

.sections h2 img {
  width: 50px !important;
  margin-right: 15px;
  margin-left: 15px;
  margin-top: 15px;
}

.sections .div-title {
  background: #efefef;
  padding: 5px 10px 5px 10px;
  margin: 0;
  text-align: center;
}

.sections .div-value {
  font-size: 46px;
  font-weight: 600;
  margin: 0;
  background-color: white;
  text-align: center;
}

.sections .div-footer {
  background-color: white;
  text-align: center;
}

.followSection {
  margin-top: 3%;
  margin-left: 3%;
  padding-left: 3%;
  padding-top: 5%;
  padding-bottom: 5%;
}

#scroll::-webkit-scrollbar {
  width: 5px;
}

#scroll::-webkit-scrollbar-track {
  background: #9e6800;
}

#scroll::-webkit-scrollbar-thumb {
  background: #333333;
}

#scroll::-webkit-scrollbar-thumb:hover {
  background: black;
}

.fc-scroller .fc-day-grid-container {
  height: 308px !important;
}

.fa-trash:hover {
  color: white;
  cursor: pointer;
}

.fa-trash {
  font-size: 1.25rem;
  color: #eee7e7;
  position: absolute;
  bottom: 4%;
  right: 15%;
}
</style>