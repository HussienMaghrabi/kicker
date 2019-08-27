<template>
  <div>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous"
    >
    <div style="position: fixed; cursor: pointer; top: 30%; left: 6%; z-index: 10;" v-drag>
      <div v-if="user.assistant == 0" class="help" id="help">
        <p class="help-title">How can i help ?</p>
        <i class="fas fa-times close-icon" @click="closeHelp" style="top: 5%; right: 5%;"></i>
        <ul class="help-list">
          <li @click="showAddLead = true">Add New Lead</li>
          <li @click="openFollowUpModel">View follow up</li>
          <li>Add New Broadcast request</li>
        </ul>
        <div class="triangle"></div>
      </div>
      <div v-else style="display:none" class="help" id="help">
        <p class="help-title">How can i help ?</p>
        <i class="fas fa-times close-icon" @click="closeHelp" style="top: 5%; right: 5%;"></i>
        <ul class="help-list">
          <li @click="showAddLead = true">Add New Lead</li>
          <li @click="openFollowUpModel">View follow up</li>
          <li>Add New Broadcast request</li>
        </ul>
        <div class="triangle"></div>
      </div>

      <div v-if="user.assistant == 0" id="b" class="reminder">
        <i @click="closeReminder" class="fas fa-times close-icon-reminder"></i>
        <carousel :per-page="1" :autoplay="true" :loop="true">
          <slide v-for="todo in reminderTodos" :key="todo.id" :style="todo">
            <div
              id="scroll"
              class="columns"
              style="margin-left: 1%;
              margin-top: 0%;
              padding-left: 8%;
              height: 100%; overflow: auto;"
              >
              <div class="column is-9">
                <p class="help-title" style="margin-bottom: 0px">Reminder</p>
                <i class="fas fa-trash" @click="confirmDelete(todo.id)"></i>
                <p class="reminderTitle">
                  Lead:
                  <span class="reminderSpan">{{ todo.name }}</span>
                </p>
                <p class="reminderTitle">
                  Phone number:
                  <span class="reminderSpan">{{ todo.phone }}</span>
                </p>
                <p class="reminderTitle">
                  Due Date:
                  <span class="reminderSpan">{{ todo.due_date }} {{ todo.dateTime12Formatted }}</span>
                </p>
                <p class="reminderTitle">Description</p>
                <p style="color: black; ">{{ todo.description }}</p>
              </div>
              <div class="column is-3">
                <!-- <img
                  style="margin-top: 75%;"
                  src="../../../../../../public/images/Group22.png"
                  alt
                  width="80"
                  height="80"
                >-->
                <p>{{todo.datetime24Formatted | momentFromNow}}</p>

                <img
                  :src="reminderImagesPath(todo)"
                  style="margin-top: 20%; margin-left: -27%; width: 70%;"
                  alt
                  @click="reminderOpenModels(todo)"
                >
              </div>
            </div>
          </slide>
        </carousel>
        <!-- old slider -->
        <!--
        <slider
          ref="_slider"
          v-model="sliderIndex"
          @change="updateSlider"
          :autoplay="true"
          :interval="30000"
          animation="fade"
          style="height: unset">
          <slider-item v-for="todo in reminderTodos" :key="todo.id" :style="i">
            <div
              id="scroll"
              class="columns"
              style="margin-left: 1%;
              margin-top: 0%;
              padding-left: 8%;
              height: 100%; overflow: auto;"
              >
              <div class="column is-9">
                <p class="help-title" style="margin-bottom: 0px">Reminder</p>
                <i class="fas fa-trash" @click="confirmDelete(todo.id)"></i>
                <p class="reminderTitle">
                  Lead:
                  <span class="reminderSpan">{{ todo.name }}</span>
                </p>
                <p class="reminderTitle">
                  Phone number:
                  <span class="reminderSpan">{{ todo.phone }}</span>
                </p>
                <p class="reminderTitle">
                  Due Date:
                  <span class="reminderSpan">{{ todo.due_date }} {{ todo.dateTime12Formatted }}</span>
                </p>
                <p class="reminderTitle">Description</p>
                <p style="color: black; ">{{ todo.description }}</p>
              </div>
              <div class="column is-3">
             <img
                  style="margin-top: 75%;"
                  src="../../../../../../public/images/Group22.png"
                  alt
                  width="80"
                  height="80"
                >
                <p>{{todo.datetime24Formatted | momentFromNow}}</p>

                <img
                  :src="reminderImagesPath(todo)"
                  style="margin-top: 20%; margin-left: -27%; width: 70%;"
                  alt
                  @click="reminderOpenModels(todo)"
                >
              </div>
            </div>
          </slider-item>
        </slider>
        -->
        <!-- end old slider -->
      </div>

      <vue-context ref="menu">
        <ul slot-scope="child">
          <li @click="rightClickAssistantHide($event.target.innerText, child.data)">Hide</li>
          <li @click="rightClickAssistantShow($event.target.innerText, child.data)">Show</li>
        </ul>
      </vue-context>

      <div
      v-if="user.assistant == 0"
        id="planet"
        class="planet"
        v-on:dblclick="openHelp"
        @contextmenu.prevent="$refs.menu.open($event, { foo: 'bar' })"
        style="width:180px;height:180px;display:block"
      ></div>
      <div v-else
        id="planet"
        class="planet"
        v-on:dblclick="openHelp"
        @contextmenu.prevent="$refs.menu.open($event, { foo: 'bar' })"
        style="width:50px;height:50px;display:block"
        >
      </div>
      <div class="gravity">
        <div v-if="user.assistant == 0" id="satellite" class="satellite" @click="openReminder"></div>
        <div v-else style="display:none" id="satellite" class="satellite" @click="openReminder"></div>
      </div>
    </div>

    <!-- add lead model -->
    <b-modal :active.sync="showAddLead">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Add Lead</p>
        </header>
        <section class="modal-card-body">
          <div class="columns is-multiline is-mobile">
            <div class="column is-6">
              <b-field label="First Name">
                <b-input v-model="newLeadData.leadFirstName"></b-input>
              </b-field>
            </div>
            <div class="column is-6">
              <b-field label="Last Name">
                <b-input v-model="newLeadData.leadLastName"></b-input>
              </b-field>
            </div>
            <div class="column is-6">
              <b-field label="phone">
                <b-input v-model="newLeadData.phone"></b-input>
              </b-field>
            </div>
            <div class="column is-6">
              <label class="label">Lead source</label>
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newLeadData.sourceId">
                    <option
                      v-for="source in leadSources"
                      :key="source.id"
                      :value="source.id"
                    >{{source.name}}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="column is-6">
              <b-field label="Reference">
                <b-input v-model="newLeadData.reference"></b-input>
              </b-field>
            </div>

            <!-- <input type="hidden" v-model="newLeadData.r_agent" value=""> -->
            <div class="column is-6" v-if="residentialAgents.length != 0">
              <label class="label">Residencial Agent</label>
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newLeadData.r_agent">
                    <option
                      v-for="agent in residentialAgents"
                      :key="agent.id"
                      :value="agent.id"
                    >{{agent.name}}</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="column is-6" v-if="residentialAgents.length != 0">
              <label class="label">Commercial Agent</label>
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="newLeadData.c_agent">
                    <option
                      v-for="agent in commercialAgents"
                      :key="agent.id"
                      :value="agent.id"
                    >{{agent.name}}</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot" style="justify-content: flex-end;">
          <button class="button is-primary" @click="addLead">Add Lead</button>
        </footer>
      </div>
    </b-modal>

    <!-- follow up section -->
    <b-modal :active.sync="showFollowUp">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Follow Up</p>
        </header>
        <section class="modal-card-body">
          <FollowUp
            :todayFollowUpEvents="todayFollowUpEvents"
            :prevFollowUpEvents="prevFollowUpEvents"
            @newFollow="updateFromFollow"
          />
        </section>
        <footer class="modal-card-foot" style="justify-content: flex-end;">
          <button class="button is-info" @click="showFollowUp = false">Close</button>
        </footer>
      </div>
    </b-modal>

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
                    <option value="highest">Highest</option>
                    <option value="high">High</option>
                    <option value="normal">Normal</option>
                    <option value="low">Low</option>
                    <option value="lowest">Lowest</option>
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
                    <option value="highest">Highest</option>
                    <option value="high">High</option>
                    <option value="normal">Normal</option>
                    <option value="low">Low</option>
                    <option value="lowest">Lowest</option>
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
                <textarea class="textarea" placeholder v-model="newMeetingDataFollowUp.description"></textarea>
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
            {{ leadName }}
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
            {{ desc }}
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
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {
  getLeadSources,
  getAgents,
  leadShortAdding,
  fetchDashboardEvents,
  yourCalendarEventsNotf,
  getDevProjects,
  addCall,
  getPublicData,
  getLeadData,
  addMeeting,
  getLeadsByAgentId,
  confirmTodo,
  deleteTodo,
  assistantChangeStatus,
  getUserById
} from "./../../../calls.js";
import drag from "@branu-jp/v-drag";
import moment from "moment";
import { Slider, SliderItem } from "vue-easy-slider";
import { Carousel, Slide } from "vue-carousel"

import { VueContext } from "vue-context";
import Multiselect from "vue-multiselect";
import FollowUp from "./FollowUp";

export default {
  name: "Assistant",

  directives: {
    drag
  },

  computed: {
    format() {
      return this.formatAmPm ? "12" : "24";
    }
  },

  data() {
    return {
      userType: window.auth_user.type,
      id: window.auth_user.id,
      teamLeader: 0,
      showAddLead: false,
      showFollowUp: false,
      isCallModalActive: false,
      isMeetingModalActive: false,
      isCalenderModalActive: false,
      newLeadData: {},
      leadSources: [],
      residentialAgents: [],
      todayFollowUpEvents: [],
      prevFollowUpEvents: [],
      todoInfoLeads: "",
      todoInfoDuedate: "",
      todoInfoTodoType: "",
      todoInfoStatus: "",
      todoInfoPhone: "",
      todoInfoDescription: "",
      desc: "",
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
      leadName: "",
      reminderTodos: [],
      sliderIndex: 1,
      leadID: "",
      user:[],
    };
  },

  components: {
    FollowUp,
    Multiselect,
    Slider,
    SliderItem,
    VueContext,
    Carousel,
    Slide
  },

  filters: {
    momentFromNow(date) {
      return moment(date).fromNow();
    },
  },

  created() {
    this.getSources();
    this.getCompanyAgents();
    this.newLeadData.r_agent = this.id;
    this.yourCalendarEventsNotf();
    this.getUserdata()
    // this.getPublic();
    setInterval(this.checkBeforeOpenAssistant, 120000);
    setInterval(this.yourCalendarEventsNotf, 120000);
    // old setInterval = 120000
    // setInterval(this.testSetint, 400);
    this.openReminder();
  },

  methods: {
    checkBeforeOpenAssistant() {
        if(document.getElementById("planet").style.width !== "50px"){
          this.openReminder();
        }
    },
    getUserdata(){
      getUserById().then(response=>{
        this.user = response.data
        console.log('user data',response)
      }).catch(error=>{
        console.log(error)
      })
    },
    testSetint(){
      console.log('intrval')
    },
    rightClickAssistantHide(text, data) {
      var send = {
          'on_show':'hide'
      } 
      assistantChangeStatus(send).then(response=>{
        console.log('desActive assistant',response)
      }).catch(error=>{
        console.log(error)
      })
      document.getElementById("planet").style.width = "50px";
      document.getElementById("planet").style.height = "50px";
      document.getElementById("satellite").style.display = "none";
      document.getElementById("help").style.display = "none";
      document.getElementById("b").style.display = "none";
    },

    rightClickAssistantShow(text, data) {
      var send = {
          'on_show':'show'
      } 
      assistantChangeStatus(send).then(response=>{
        console.log('active assistant',response)
      }).catch(error=>{
        console.log(error)
      })
      console.log('show')
      document.getElementById("planet").style.width = "180px";
      document.getElementById("planet").style.height = "180px";
      document.getElementById("satellite").style.display = "block";
      // document.getElementById("help").style.display = "block";
      // document.getElementById("b").style.display = "block";
    },
    
    updateSlider($event) {
      // console.log("changed ", this.sliderIndex);
      if (this.reminderTodos[this.sliderIndex].to_do_type === "call") {
        document.getElementById("b").style.backgroundImage =
          "-webkit-radial-gradient(-23px 50%,circle closest-corner,rgba(0, 0, 0, 0) 0,rgba(0, 0, 0, 0) 100px,#3493d4 56px,#3493d4 57px)";
        document.getElementById("satellite").style.border =
          "10px solid #3493d4";
      } else if (
        this.reminderTodos[this.sliderIndex].to_do_type === "meeting"
      ) {
        document.getElementById("b").style.backgroundImage =
          "-webkit-radial-gradient(-23px 50%,circle closest-corner,rgba(0, 0, 0, 0) 0,rgba(0, 0, 0, 0) 100px,#55adac 56px,#55adac 57px)";
        document.getElementById("satellite").style.border =
          "10px solid #55adac";
      } else {
        document.getElementById("b").style.backgroundImage =
          "-webkit-radial-gradient(-23px 50%,circle closest-corner,rgba(0, 0, 0, 0) 0,rgba(0, 0, 0, 0) 100px,#f8c932 56px,#f8c932 57px)";
        document.getElementById("satellite").style.border =
          "10px solid #f8c932";
      }
    },
    reminderImagesPath(reminderTodo) {
      if (reminderTodo.to_do_type === "call") {
        return "/icon/Group 22.png";
      } else if (reminderTodo.to_do_type === "meeting") {
        return "/icon/remindermeeting.png";
      } else if (reminderTodo.to_do_type === "others") {
        return "/icon/remindertodo.png";
      }
    },

    reminderOpenModels(reminderTodo) {
      this.getData();
      this.getPublic();
      this.selectEvent();
      this.getLeadsByAgentId();
      this.leadName = reminderTodo.name;
      this.desc = reminderTodo.description;
      this.todoID = reminderTodo.id;
      this.leadID = reminderTodo.leads;
      // console.log("this.leadData.id", this.leadData.id);
      if (reminderTodo.to_do_type === "call") {
        this.phone = reminderTodo.phone;
        this.isCallModalActive = true;
      } else if (reminderTodo.to_do_type === "meeting") {
        this.meetingPhone = reminderTodo.phone;
        this.isMeetingModalActive = true;
      } else if (reminderTodo.to_do_type === "others") {
        this.todoInfoDuedate = reminderTodo.due_date;
        this.todoInfoTodoType = reminderTodo.to_do_type;
        this.todoInfoStatus = reminderTodo.status;
        this.todoInfoPhone = reminderTodo.phone;
        this.isCalenderModalActive = true;
      }
    },

    addNewCall() {
      this.isLoading = true;
      let data = {
        _token: this.token,
        user_id: this.userId,
        lead_id: this.leadID,
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
          console.log('public data',response)
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

    addNewMeeting() {
      this.isLoading = true;
      let h = this.newMeetingDataFollowUp.time.getHours();
      let m = this.newMeetingDataFollowUp.time.getMinutes();
      let time = h + ":" + m;
      var data = {
        _token: this.token,
        user_id: this.userId,
        lead_id: this.leadID,
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
          this.yourCalendarEventsNotf();
          this.$emit("newFollow", null);
          this.$emit('newAssistant', null)
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

    closeHelp() {
      document.getElementById("help").style.display = "none";
      document.getElementById("help").className += " close";
      document.getElementById("help").classList.remove("open");
      document.getElementById("b").style.top = "40px";
    },

    openHelp() {
      document.getElementById("help").style.display = "block";
      document.getElementById("help").className += " open";
      document.getElementById("help").classList.remove("close");
      if(document.getElementById("b").style.display === "block"){
        document.getElementById("b").style.top = "-60px";
        document.getElementById("help").style.top = "-108px";
        document.getElementById("help").style.left = "-17%";
      }
    },

    closeReminder() {
      document.getElementById("b").style.display = "none";
      document.getElementById("b").className += " close";
      document.getElementById("b").classList.remove("open");
      document.getElementById("help").style.top = "-180px";
      document.getElementById("help").style.left = "-31%";
    },

    openReminder() {
      this.yourCalendarEventsNotf();
      document.getElementById("b").style.display = "block";
      document.getElementById("b").className += " open";
      document.getElementById("b").classList.remove("close");
      this.rightClickAssistantShow();
      if(document.getElementById("help").style.display === "block"){
        document.getElementById("b").style.top = "-60px";
        document.getElementById("help").style.top = "-108px";
        document.getElementById("help").style.left = "-17%";
      }
    },

    getSources() {
      getLeadSources()
        .then(response => {
          this.leadSources = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    getCompanyAgents() {
      getAgents()
        .then(response => {
          this.commercialAgents = response.data.commercialAgents;
          this.residentialAgents = response.data.residentialAgents;
          for (let i = 0; i < this.commercialAgents.length; i++) {
            this.allAgents.push(this.commercialAgents[i]);
          }

          for (let i = 0; i < this.residentialAgents.length; i++) {
            this.allAgents.push(this.residentialAgents[i]);
          }
        })
        .catch(error => {
          console.log(error);
        });
    },

    addLead() {
      leadShortAdding(this.newLeadData)
        .then(response => {
          // console.log(response);
          this.showAddLead = false;
        })
        .catch(error => {
          console.log(error);
        });
    },

    fetchDashboardEvents() {
      // const todayDateStr = moment().format("YYYY-MM-DD");
      const todayDateStr = "2018-10-12";

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
              if (curr.due_date !== todayDateStr) {
                return true;
              }
            }
          });
        })
        .catch(error => {
          console.error(error);
        });
    },

    updateFromFollow(t) {
      // console.log(t , 'test update')
      this.fetchDashboardEvents();
    },

    openFollowUpModel() {
      this.fetchDashboardEvents();
      this.showFollowUp = true;
    },

    yourCalendarEventsNotf() {
      // console.log(this.$refs)
      fetchDashboardEvents()
        .then(response => {
          this.reminderTodos = []
          for (let i = 0; i < response.data.length; i++) {
            if (response.data[i].status === "pending") {
              this.reminderTodos.push(response.data[i]);
            }
          }
          this.$refs._slider.init()
          console.log("this reminderTodos", this.reminderTodos);
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
          this.yourCalendarEventsNotf();
          this.$emit("newFollow", null);
          this.$emit('newAssistant', null)
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

<style>
.VueCarousel-pagination{
  display: none !important
}
.slider-indicator-icon{
display: none !important;
}
</style>

<style scoped>
.reminder {
  display: inline-block;
  position: relative;
  height: 200px;
  top: 40px;
  right: -15%;
  color: white;
  position: relative;
  padding: 3%;
}

#b {
  /* visibility: hidden; */
  display: none;
  width: 575px;
  /* need to play with margin/padding adjustment
       based on your desired "gap" */
  padding-left: 80px;
  margin-left: 6px;
  /* real borders */
  border-left: none;
  -webkit-border-top-right-radius: 20px;
  -webkit-border-bottom-right-radius: 20px;
  -moz-border-radius-topright: 20px;
  -moz-border-radius-bottomright: 20px;
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
  /* the inverse circle "cut" */
  background-image: -webkit-radial-gradient(
    -23px 50%,
    circle closest-corner,
    rgba(0, 0, 0, 0) 0,
    rgba(0, 0, 0, 0) 100px,
    #3493d4 56px,
    #3493d4 57px
  );
}

.navigation-slider {
  top: -210%;
  position: relative;
  margin: 38%;
  right: -42%;
}

.hooper {
  height: 154px !important;
}

@-webkit-keyframes openAnimation {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@-moz-keyframes openAnimation {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@-o-keyframes openAnimation {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes openAnimation {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

@-webkit-keyframes closeAnimation {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
@-moz-keyframes closeAnimation {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
@-o-keyframes closeAnimation {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
@keyframes closeAnimation {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

.hooper-slide {
  width: 100% !important;
}

.open {
  animation: openAnimation 1.5s;
}

.close {
  animation: closeAnimation 2s;
}

.help {
  background: #3493d4;
  position: relative;
  top: -180px;
  left: -31%;
  width: 312px;
  padding: 15px;
  border-radius: 10px;
  /* visibility: hidden; */
  display: none;
}

.help-title {
  font-size: 1.5rem;
  font-weight: bold;
  color: black;
  border-bottom: 2.5px solid black;
  width: fit-content;
}

.reminderTitle {
  font-weight: bold;
  margin-bottom: 0px !important;
}

.reminderSpan {
  font-weight: 500;
  color: white;
  margin-left: 3%;
}

.help-list {
  margin-top: 5%;
  color: white;
  font-size: 1.25rem;
}

.close-icon {
  font-size: 1.5rem;
  color: white;
  position: absolute;
  top: -7%;
  right: 10%;
}

.close-icon-reminder {
  font-size: 1.5rem;
  color: white;
  margin-left: 95%;
  margin-top: -4%;
}

.triangle {
  width: 0;
  height: 0;
  border: 0 solid transparent;
  border-left-width: 21px;
  border-right-width: 22px;
  border-top: 30px solid #3493d4;
  position: absolute;
  bottom: -13%;
  left: 41%;
}

.planet {
  width: 180px;
  height: 180px;
  border-radius: 50%;
  position: absolute;
  top: 44%;
  /* left: 49%; */
  margin-top: -40px;
  margin-left: -40px;
  border: 20px solid #da224a;
}

.gravity {
  width: 10px;
  height: 10px;
  animation: sideToSide 3s infinite ease-in-out alternate;
  position: absolute;
  top: 50%;
  /* left: 50%; */
  margin-left: 0;
}

.satellite {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: white;
  border: 10px solid #3493d4;
  animation: circle 6s infinite linear;
  position: absolute;
  top: 28px; /*10%*/
  /*left: 42%; /*50%*/
  margin-left: -55px;
  transform-origin: 100px center;
}

#scroll::-webkit-scrollbar {
  width: 5px;
}

#scroll::-webkit-scrollbar-track {
  background: unset;
}

#scroll::-webkit-scrollbar-thumb {
  background: unset;
}

#scroll::-webkit-scrollbar-thumb:hover {
  background: unset;
}

.fa-trash:hover {
  color: #cd3c3c;
  cursor: pointer;
}

.fa-trash {
  font-size: 1.25rem;
  position: absolute;
  top: 7%;
  left: 37%;
}

@keyframes circle {
  to {
    transform: rotate(1turn);
  }
}

@media screen and (max-width: 767px) {
  #planet,
  #satellite,
  #help,
  #b,
  .gravity{
    display: none;
  }
}
/* @keyframes sideToSide { to { transform: translateX(400px); } } */
</style>