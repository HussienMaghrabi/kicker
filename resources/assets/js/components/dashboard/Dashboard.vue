<template>
  <div>
  <section class="overlaySec" id="loadd" :is-full-page="true">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </section>
    <div class="dashboard container">
      <div class="columns">
        <div class="column left-side-dash-col" style="width: 65%;">
          <div class="row">
            <div class="edit-bar">
              <button class="btn btn-default editBtn">
                <i class="fa fa-edit" v-on:click="enableEdit"></i>
              </button>
              <div
                id="reportrange"
                style="background: #9e6900; color:white; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; min-width: 300px;"
              >
                <i class="fa fa-caret-down"></i>
                <date-picker v-model="time3" lang="en" range></date-picker>
              </div>
            </div>
          </div>

          <Assistant @newFollow="updateFromFollow"
          @newAssistant="updateFromFollow"
          ref="_slider"/>

          <FollowUp
            :todayFollowUpEvents="todayFollowUpEvents"
            :prevFollowUpEvents="prevFollowUpEvents"
            @newFollow="updateFromFollow"
          />

          <Vuedraggable
            v-model="dashboardSectionsComponents"
            @update="handleDashboardSectionsSort"
            :options="{disabled:isActive}"
          >
            <component
              v-for="component in dashboardSectionsComponents"
              :is="component.name"
              :key="component.id"
              v-bind="$data"
              :teamAchievement="teamAchievement"
            ></component>
          </Vuedraggable>
        </div>
        <div class="column right-side" style="margin-left: 3%; padding: 1%; width: 35%;">
          <div class="rows">
            <div class="row">
              <label
                style="display: inline-block; max-width: 100%; margin-bottom: 5px; font-weight: 700;"
              >
                <div>
                  <img
                    src="/icon/Activity-log.png"
                    style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
                  >
                  <h2
                    style="float: right; margin-top: 8%; font-size: 20px; font-weight: bold;"
                  >Activity Log</h2>
                </div>
              </label>
              <b-dropdown v-if="authUserType == 'admin'" hoverable style="margin-top: -7%;">
                <button
                  class="button is-info"
                  slot="trigger"
                  style="background-color: unset; color: black; margin-top: 55%;"
                >
                  <span>Teams</span>
                  <b-icon icon="menu-down"></b-icon>
                </button>
                <div id="scroll" style="overflow-y: auto; height: 350px">
                  <b-dropdown-item v-for="team in teams" :key="team.id">
                    <b-checkbox v-model="teamID" :native-value="team.id">{{team.name}}</b-checkbox>
                  </b-dropdown-item>
                </div>
              </b-dropdown>

              <b-dropdown hoverable style="margin-top: -7%;">
                <button
                  class="button is-info"
                  slot="trigger"
                  style="background-color: unset; color: black; margin-top: 53%;"
                >
                  <span>Agents</span>
                  <b-icon icon="menu-down"></b-icon>
                </button>
                <div id="scroll" style="overflow-y: auto; height: 350px">
                  <b-dropdown-item v-for="agent in agents" :key="agent.employee_id">
                    <b-checkbox v-model="agentID" :native-value="agent.id">{{agent.name}}</b-checkbox>
                  </b-dropdown-item>
                </div>
              </b-dropdown>
              <div class="rows" id="scroll" style="height: 268px; overflow: auto; margin-top: 5%">
                <ul>
                  <div v-html="activityData" class="row" style="margin-left: 5%; font-size: 13px;"></div>
                </ul>
              </div>
            </div>

            <div class="row">
              <b-collapse
                class="card"
                style="background-color: unset; margin-top: 3%; margin-top: 15%;"
              >
                <div slot="trigger" slot-scope="props" class="card-header">
                  <p class="card-header-title">
                    <label
                      style="display: inline-block; max-width: 100%; margin-bottom: 5px; font-weight: 700;"
                    >
                      <div>
                        <img
                          src="/icon/calendar.png"
                          style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
                        >
                        <h2
                          style="float: right; margin-top: 8%; font-size: 20px; font-weight: bold; color: #4a4a4a"
                        >Your Calendar</h2>
                      </div>
                    </label>
                  </p>
                  <a class="card-header-icon">
                    <b-icon :icon="props.open ? 'minus' : 'plus'" style="color: #4a4a4a"></b-icon>
                  </a>
                </div>
                <div class="card-content">
                  <div class="content">
                    <yourCalendarSection/>
                  </div>
                </div>
              </b-collapse>
            </div>
            <div class="row">
              <a style="color: #9e6900; float: right;" @click="isBroadModalActive = true">
                <img src="/icon/event.png" width="30">
                BroadcastEvent
              </a>
              <b-modal :active.sync="isBroadModalActive">
                <form action>
                  <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                      <p class="modal-card-title">BroadcastEvent</p>
                    </header>
                    <section class="modal-card-body">
                      <b-field label="Date">
                        <datetime
                          type="datetime"
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

                      <b-field label="Title">
                        <b-input placeholder="Title" v-model="broadcatEventTitle"></b-input>
                      </b-field>

                      <b-field label="Description">
                        <b-input maxlength="200" type="textarea" v-model="broadcatEventDescription"></b-input>
                      </b-field>

                      <b-field label="Select Teams">
                        <b-select id="selectTeams" placeholder="Select Teams">
                          <option
                            v-for="team in teams"
                            :value="team.id"
                            :key="team.id"
                          >{{ team.name }}</option>
                        </b-select>
                      </b-field>

                      <b-field label="Select Member">
                        <b-select id="selectTeams" placeholder="Select Teams">
                          <option
                            v-for="team in teams"
                            :value="team.id"
                            :key="team.id"
                          >{{ team.name }}</option>
                        </b-select>
                      </b-field>
                    </section>
                    <footer class="modal-card-foot">
                      <button class="button" type="button" @click="isBroadModalActive = false">Close</button>
                      <button class="button is-success" @click="broadcastEventSend">Send</button>
                    </footer>
                  </div>
                </form>
              </b-modal>
            </div>

            <div class="row" style="margin-top: 25%;" v-if="authUserType == 'Team Leader' || authUserType == 'admin' ">
              <b-collapse
                class="card"
                style="background-color: unset; margin-top: 3%; margin-top: 15%;"
              >
                <div slot="trigger" slot-scope="props" class="card-header">
                  <p class="card-header-title">
                    <label
                      style="display: inline-block; max-width: 100%; margin-bottom: 5px; font-weight: 700;"
                    >
                      <div>
                        <img
                          src="/icon/calendar.png"
                          style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
                        >
                        <h2
                          style="float: right; margin-top: 8%; font-size: 20px; font-weight: bold; color: #4a4a4a"
                        >Team Calendar</h2>
                      </div>
                    </label>
                  </p>
                  <a class="card-header-icon">
                    <b-icon :icon="props.open ? 'minus' : 'plus'" style="color: #4a4a4a"></b-icon>
                  </a>
                </div>
                <div class="card-content">
                  <div class="content">
                    <teamCalendarSection/>

                  </div>
                </div>
              </b-collapse>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="true"></b-loading> -->
  </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
$(window).load(function() {
  // Animate loader off screen
  document.getElementById("loadd").style.display = "none";
  
});
import Multiselect from "vue-multiselect";
// import { log } from "util";
import {
  dashgetstatus,
  dashgetsource,
  dashdashboard,
  fetchDashboardEvents,
  fetchDashboardSectionStatistics,
  fetchDashboardProjectSection,
  achievementsSectionDashboard,
  dashActivity,
  getTeams,
  getAgents,
  getAgentNames,
  getLeadName,
  getLeadData,
  getDevProjects,
  getPublicData,
  getLeadsByAgentId,
  edit_dashboard,
  getOrder,
  teamAchievements
} from "./../../calls";

import teamCalendarSection from "../teamCalendarSection";
import yourCalendarSection from "../yourCalendarSection";

import DashboardSection from "./components/DashboardSection";
import LeadsSection from "./components/LeadsSection";
import ProjectSection from "./components/ProjectSection";
import CallByCallSection from "./components/CallByCallSection";
import AchievementsSection from "./components/AchievementsSection";
import TeamAchievementsSection from "./components/TeamAchievementsSection";
import pipeline from "../pipeline/pipeline";


import FollowUp from "./components/FollowUp";
import Assistant from "./components/Assistant";

import VueApexCharts from "vue-apexcharts";
import "fullcalendar/dist/fullcalendar.css";
import { FullCalendar } from "vue-full-calendar";
import Vuedraggable from "vuedraggable";
import DatePicker from "vue2-datepicker";
import moment from "moment";

export default {
  name: "dashboard",
  filters: {
    date(value) {
      let options = { year: "numeric", month: "long", day: "numeric" };
      return Intl.DateTimeFormat("en-US", options).format(value);
    }
  },

  data() {
    return {
      // loading: true,
      isLoading: true,
      flag: 0,
      authUserType: window.auth_user.type,
      dateFrom: new Date(new Date().getFullYear(), 0, 1),
      dateTo: new Date(),
      dashboardOrder: {
        type: 'deskEdit',
        data: [],
      },
      agentIDYourCaln: '',
      agentID: [],
      teamID: [],
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
      teams: {},
      agents: [],
      broadcatEventTitle: "",
      broadcatEventDescription: "",
      activityData: "",
      dashboardSectionStats: {},
      calendarEvents: [],
      teamCalendarEvents: [],
      todayFollowUpEvents: [],
      prevFollowUpEvents: [],
      data: null,
      isActive: true,
      time3: "",
      dashboardSectionsComponents: [
        { id: 1, order: 1, name: "DashboardSection" },
        { id: 2, order: 2, name: "LeadsSection" },
        { id: 3, order: 3, name: "ProjectSection" },
        { id: 4, order: 4, name: "CallByCallSection" },
        { id: 5, order: 5, name: "AchievementsSection" },
        { id: 6, order: 6, name: "TeamAchievementsSection" }
      ],
      stat: [],
      source: [],
      dash: [],
      isBroadModalActive: false,

      foptions: {
        labels: [],
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
              legend: {
                position: "bottom"
              }
            }
          }
        ]
      },
      fseries: [],

      yesterdayAchievementsseries: [],
      yesterdayAchievementsChartOptions: {
        plotOptions: {
          radialBar: {
            hollow: {
              size: "70%"
            },
            dataLabels: {
              name: {
                offsetY: -10,
                show: true
              },
              value: {
                formatter: function(val) {
                  return parseInt(val);
                },
                color: "#111",
                show: true
              }
            }
          }
        },
        labels: ["Yesterday"]
      },

      todayAchievementsseries: [],
      todayAchievementsChartOptions: {
        plotOptions: {
          radialBar: {
            hollow: {
              size: "70%"
            },
            dataLabels: {
              name: {
                offsetY: -10,
                show: true
              },
              value: {
                formatter: function(val) {
                  return parseInt(val);
                },
                color: "#111",
                show: true
              }
            }
          }
        },
        labels: ["Today"]
      },

      monthAchievementsseries: [],
      monthAchievementsChartOptions: {
        plotOptions: {
          radialBar: {
            hollow: {
              size: "70%"
            },
            dataLabels: {
              name: {
                offsetY: -10,
                show: true
              },
              value: {
                formatter: function(val) {
                  return parseInt(val);
                },
                color: "#111",
                show: true
              }
            }
          }
        },
        labels: ["Month"]
      },

      tchartOptions: {
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "25%"
          }
        },
        dataLabels: {
          enabled: false
        },
        chart: {
          id: "basic-bar"
        },
        xaxis: {
          categories: []
        },
        fill: {
          colors: ["#6a5a4d"]
        }
      },
      tseries: [
        {
          name: "# of Leads",
          data: []
        }
      ],

      tabledata: [],
      tablecolumns: [
        {
          field: "Project",
          label: "Project",
          width: "20"
        },
        {
          field: "Leads",
          label: "Leads",
          centered: true,
          numeric: true,
          width: "20"
        }
      ],

      plotOptions: {
        radialBar: {
          hollow: {
            size: "70%"
          },
          dataLabels: {
            name: {
              fontSize: "12px"
            }
          }
        }
      },

      value: null,
      teamAchievement : []
    };
  },

  watch: {
    'agentID': function(){
      this.dashActivity();
    },

    'teamID': function(){
      this.dashActivity();
    },

    'time3': function(){
      this.dateFrom = this.time3[0]
      this.dateTo = this.time3[1]
      this.getStatus();
      this.getSource();
      this.getDashboard();
      this.dashActivity();
      this.fetchDashboardProjectSection();
      this.fetchDashboardSectionStatistics();
    },

    'dashboardSectionsComponents': function(){
      this.flag = 1
      this.dashboardOrder.data = []
      for (let i = 0; i < this.dashboardSectionsComponents.length; i++) {
        this.dashboardOrder.data.push("r" + this.dashboardSectionsComponents[i].order)
      }
      // console.log(this.dashboardOrder.data)
    }
  },
  components: {
    FollowUp,
    apexcharts: VueApexCharts,
    apexchart: VueApexCharts,
    FullCalendar,
    DashboardSection,
    LeadsSection,
    ProjectSection,
    CallByCallSection,
    AchievementsSection,
    TeamAchievementsSection,
    Vuedraggable,
    DatePicker,
    Multiselect,
    Assistant,
    teamCalendarSection,
    yourCalendarSection,
    'pipeline': pipeline
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
        })
        .catch(error => {
          console.log(error);
        });
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
    dateFormatter(dt) {
      var date = dt.toLocaleDateString();
      const [month, day, year] = date.split("/");
      this.parsedDate = `${year}-${month.padStart(2, "0")}-${day.padStart(
        2,
        "0"
      )}`;
      return date;
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
    handleDashboardSectionsSort(evt) {
      this.dashboardSectionsComponents[evt.oldIndex].order = evt.oldIndex + 1;
      this.dashboardSectionsComponents[evt.newIndex].order = evt.newIndex + 1;
    },

    updateFromFollow(t) {
      // console.log(t , 'test update')
      this.fetchDashboardEvents();
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
          // console.log(response.data)
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
          // console.log("data.calendar", data.calendar)
          this.calendarEvents = events.map(curr => {
            return {
              start: curr.due_date,
              title: curr.to_do_type,
              data: curr
            };
          });

          this.todayFollowUpEvents = events.filter(curr => {
            if (curr.status === "pending") {
              if (curr.due_date === todayDateStr) {
                return true;
              }
            }
          });

          this.prevFollowUpEvents = events.filter(curr => {
            if (curr.status === "pending") {
              if (curr.due_date < todayDateStr) {
                return true;
              }
            }
          });
          this.$refs._slider.$refs._slider.init()
        })
        .catch(error => {
          console.error(error);
        });
    },

    fetchDashboardSectionStatistics() {
      fetchDashboardSectionStatistics(
        window.auth_user.id,
        this.dateFrom,
        this.dateTo
      )
        .then(response => {
          this.dashboardSectionStats = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },

    fetchDashboardProjectSection() {
      fetchDashboardProjectSection(this.dateFrom, this.dateTo)
        .then(({ data: { projects } }) => {
          this.tchartOptions.xaxis.categories = projects.map(p => p.en_name);
          this.tabledata = projects.map(p => ({
            Project: p.en_name,
            Leads: p["leads"]
          }));
          this.tseries = [
            {
              data: projects.map(p => p["leads"])
            }
          ];
          this.tchartOptions = {
            ...this.tchartOptions
          };
        })
        .catch(err => {
          console.log(err);
        });
    },

    getStatus() {
      var data = {
        user_id: window.auth_user.id,
        token: window.auth_user.token,
        date_from: this.dateFrom,
        date_to: this.dateTo,
        ids: [],
        team_user_id: []
      };
      dashgetstatus(data)
        .then(response => {
          this.stat = response.data.data;

          var i;
          this.stat.forEach(function(element) {
            this.series = element.percent;
          });
        })
        .catch(error => {});
    },

    getSource() {
      var data = {
        user_id: window.auth_user.id,
        token: window.auth_user.token,
        date_from: this.dateFrom,
        date_to: this.dateTo,
        ids: [],
        team_user_id: []
      };
      dashgetsource(data)
        .then(response => {
          let labels = [];
          let precents = [];
          this.source = response.data.data;

          this.source.forEach(function(element) {
            labels.push(element.name);
            precents.push(element.percent);
          });

          this.foptions = {
            ...this.foptions,
            labels
          };

          this.fseries = precents;
        })
        .catch(error => {});
    },

    getDashboard() {
      var data = {
        user_id: window.auth_user.id,
        token: window.auth_user.token,
        date_from: this.dateFrom,
        date_to: this.dateTo,
        ids: [],
        team_user_id: []
      };
      dashdashboard(data)
        .then(response => {
          this.dash = response.data.data;

          var i;
          this.dash.forEach(function(element) {
            this.info.title = element.title;
          });
        })
        .catch(error => {});
    },
    enableEdit() {
      // console.log('fjkd')
      this.isActive = !this.isActive;
      if(this.flag === 1)
        this.edit_dashboard();
    },

    achievementsSectionDashboard() {
      var data = {
        user_id: window.auth_user.id,
        date_from: this.dateFrom,
        date_to: this.dateTo,
        ids: [],
        team_user_id: []
      };
      achievementsSectionDashboard(data)
        .then(response => {
          let yesterdayPercent = [];
          let todayPercent = [];
          let monthPercent = [];
          // console.log("achievements test", response)
          yesterdayPercent.push(response.data.yesterday);
            this.yesterdayAchievementsseries = [
              ...this.yesterdayAchievementsseries,
              yesterdayPercent
            ];
            todayPercent.push(response.data.today);
            this.todayAchievementsseries = [
              ...this.todayAchievementsseries,
              todayPercent
            ];

            monthPercent.push(response.data.month);
            this.monthAchievementsseries = [
              ...this.monthAchievementsseries,
              monthPercent
            ];

        })
        .catch(err => {
          console.log(err);
        });
    },

    dashActivity() {
      var data = {
        user_id: window.auth_user.id,
        token: window.auth_user.token,
        date_from: this.dateFrom,
        date_to: this.dateTo,
        ids: this.agentID,
        team_user_id: this.teamID
      };
      dashActivity(data)
        .then(response => {
          // console.log("activity ", response)
          this.activityData = response.data;
          console.log("loooogs",this.activityData)
        })
        .catch(error => {
          console.log(error);
        });
    },

    getTeams() {
      var data = {
        user_id: window.auth_user.id,
        token: window.auth_user.token
      };
      getTeams(data)
        .then(response => {
          // console.log("get teams is", response.data)
          this.teams = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    getAgents() {
      getAgents()
        .then(response => {
          let agents = response.data;
          // console.log("get agents", response.data)
          for (let i = 0; i < agents.commercialAgents.length; i++) {
            this.agents.push(agents.commercialAgents[i]);
          }
          for (let i = 0; i < agents.residentialAgents.length; i++) {
            this.agents.push(agents.residentialAgents[i]);
          }
        })
        .catch(error => {
          console.log(error);
        });
    },

    edit_dashboard() {
      edit_dashboard(this.dashboardOrder)
      .then(response => {
        console.log(response)
      })
      .catch(error => {
        console.log(error)
      })
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

    getOrder() {
      getOrder()
        .then(response => {
          // console.log("this.order", response.data)
          for(let i=0; i<this.dashboardSectionsComponents.length; i++) {
            this.dashboardSectionsComponents[i].order = response.data[i]

            if(response.data[i] == 1)
              this.dashboardSectionsComponents[i].name = "DashboardSection"
            else if(response.data[i] == 2)
              this.dashboardSectionsComponents[i].name = "LeadsSection"
            else if(response.data[i] == 3)
              this.dashboardSectionsComponents[i].name = "ProjectSection"
            else if(response.data[i] == 4)
              this.dashboardSectionsComponents[i].name = "CallByCallSection"
            else if(response.data[i] == 5)
              this.dashboardSectionsComponents[i].name = "AchievementsSection"
            else if(response.data[i] == 6)
              this.dashboardSectionsComponents[i].name = "TeamAchievementsSection"
          }
        })
        .catch(error => {
          console.log(error);
        });
    },

    broadcastEventSend() {},

    teamAchievements() {
      var data = {
        date_from: this.dateFrom,
        date_to: this.dateTo,
      };
      teamAchievements(data)
        .then(response => {
          this.teamAchievement = response.data
          // console.log("team achievements ", this.teamAchievement)
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  beforeCreate: function(){
    this.isLoading = true
  },
  mounted: function() {
    this.getOrder();
    this.getStatus();
    this.getSource();
    this.getDashboard();
    this.fetchDashboardEvents();
    this.fetchDashboardSectionStatistics();
    this.fetchDashboardProjectSection();
    this.achievementsSectionDashboard();
    this.dashActivity();
    this.getTeams();
    this.getAgents();
    this.getAgentNames();
    this.getLeadName();
    this.getPublic();
    this.teamAchievements();
    window.addEventListener('load', () => {   
         this.isLoading = false
    })
  },
  updated(){
    document.getElementById("loadd").style.display = "none";
  }
};


  //   $( document ).ready(function() {
  //      this.loading = false
  // });

  // $( window ).load(function() {
  //    (".sk-circle ").fadeOut(1000);
  // });

  

  // window.addEventListener('load', () => {
  //        this.loading = false
  //   })
  // setTimeout(function () {
  //     this.loading = false
  // }.bind(this), 2000);

  
</script>
  

<style src="./dashboard.css" scoped></style>
<style>
   #loading{
  margin-left: 35%;
  margin-top: 10%;
}
.overlaySec{
  background-color: #fff;
  height: 100%;
  width: 100%;
  z-index: 99999;
  position: fixed;
  top: 0;
} 

.lds-ring {
  margin-left: 40%;
  margin-top: 20%;
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 210px;
  height: 210px;
  margin: 6px;
  border: 20px solid red;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #cc0000 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>