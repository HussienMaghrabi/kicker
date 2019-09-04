<template lang="html">
    <div>
      <full-calendar
      :events="teamCalendarEvents"
      @event-selected="teamCalendarEventSeclected"
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

    <b-modal :active.sync="isCalenderModalActive">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Show To-Do</p>
        </header>
        <section class="modal-card-body">
          <p>
            <span style="font-weight: bold;">Agent:</span>
            {{ todoInfoAgent }}
          </p>
          <hr>
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
        </footer>
      </div>
    </b-modal>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
    
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import {
  getTeams,
  getAgents,
  teamCalendar,
  getAgentNames,
  getLeadName,
  store,
  getLeadData,
  getLeadsByAgentId
} from "../calls.js";

import { FullCalendar } from "vue-full-calendar";
import "fullcalendar/dist/fullcalendar.css";
import moment from "moment";
import Multiselect from "vue-multiselect";

export default {
  name: "HeaderFollowUp",

  data() {
    return {
      isLoading:true,
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
      newRequestData: {},
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
      teamCalendarEvents: [],
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
    this.getAgentNames();
    this.getLeadName();
    this.teamCalendar();
  },

  computed: {
    format() {
      return this.formatAmPm ? "12" : "24";
    }
  },

  methods: {
    teamCalendar() {
      teamCalendar()
        .then(response => {
          // console.log("team calendar ", response);
          return response.data;
        })
        .then(data => {
          let events = [];
          for (let i = 0; i < data.length; i++) {
            if (data[i].status === "pending") {
              events.push(data[i]);
            }
          }
          this.teamCalendarEvents = events.map(curr => {
            if (curr.to_do_type === "call") {
              return {
                start: curr.due_date,
                title:
                  curr.to_do_type +
                  " " +
                  curr.leadFirstName +
                  " " +
                  curr.leadLastName +
                  "\n" +
                  curr.agent +
                  "\n" +
                  curr.time +
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
                  curr.leadFirstName +
                  " " +
                  curr.leadLastName +
                  "\n" +
                  curr.agent +
                  "\n" +
                  curr.time +
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
                  curr.leadFirstName +
                  " " +
                  curr.leadLastName +
                  "\n" +
                  curr.agent +
                  "\n" +
                  curr.time +
                  "\n" +
                  curr.description,
                data: curr,
                color: "#f8c932",
                textColor: "black"
              };
            }
          });
          this.isLoading = false
          // console.log("map", this.teamCalendarEvents)
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
          console.log(response);
          this.isImageModalActive = false;
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

    teamCalendarEventSeclected(event, jsEvent, view) {
      //   console.log("teamCalendarEventSeclected",event);
      let selectedEvent = event.data;
      this.todoInfoAgent = selectedEvent.agent;
      this.todoInfoLeads =
        selectedEvent.leadFirstName + " " + selectedEvent.leadLastName;
      this.todoInfoDuedate = selectedEvent.due_date + " " + selectedEvent.time;
      this.todoInfoTodoType = selectedEvent.to_do_type;
      this.todoInfoStatus = selectedEvent.status;
      this.todoInfoPhone = selectedEvent.leadPhone;
      this.todoInfoDescription = selectedEvent.description;

      this.isCalenderModalActive = true;
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
    }
  }
};
</script>

<style lang="css" scoped>
</style>
