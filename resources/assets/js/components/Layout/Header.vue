<template>
 <!-- hellow first change to push -->
  <!-- START NAV -->
  <nav class="navbar is-white is-fixed-top">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/all.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/v4-shims.css">



<menubar></menubar>

    <div class="container is-fluid header-container">
      <div class="navbar-brand">
        <div class="navbar-item">
          <router-link to="/admin/vue/dashboard">
            <img src="/uploads/logo.png" alt width="50" height="50">                    
          </router-link>
          <b-dropdown aria-role="menu" class="web_menu" ref="_dropmenu">
            <button class="button header-menu-icon" slot="trigger" style="border: unset;">
              <i class="fas fa-bars" style="font-size: 1.25rem; margin-left: 1rem;"></i>
            </button>
            <div>
                <b-dropdown-item :custom="true" aria-role="listitem" class="header-menu-item-hover m-2">
                  <div>
                    <p>
                      <img src="/icon/header-lead.png">
                      <a @mouseover="openLeadMenu" class="header-menu-item has-child">Lead</a>
                    </p>
                  </div>

                  <div id="lead-drop-menu" style="">
                    <router-link  class="navbar-item is-child" 
                                  to="/admin/vue/Leads"
                    >All Leads</router-link>
                    <hr style="padding: 0px; margin: 8px 0px;">
      
                    <!-- <a @click="redirectRoute(2)" class="navbar-item" v-if="permArray.calls == 1 || userType == 'admin'">Calls</a> -->

                  <router-link class="navbar-item is-child"
                                to="/admin/vue/AllMeeting"
                  > Meetings</router-link>

                    <!-- <a @click="redirectRoute(3)" class="navbar-item is-child"
                      v-if="permArray.meetings == 1 || userType == 'admin'">Meetings</a> -->


                    <hr style="padding: 0px; margin: 8px 0px;">

                    <router-link  class="navbar-item is-child"
                                    to="/admin/vue/AllRequests"
                    > Requests </router-link>
                    <!--                 
                    <a @click="redirectRoute(4)" class="navbar-item is-child"
                      v-if="permArray.requests == 1 || userType == 'admin'">Requests</a> -->

                    <hr style="padding: 0px; margin: 8px 0px;">

                  

                    <!-- <a @click="redirectRoute(5)" class="navbar-item is-child">Events</a> -->
                    <!-- <hr style="padding: 0px; margin: 8px 0px;"> -->
                    <!-- <a @click="redirectRoute(6)" class="navbar-item is-child">Requests Broadcast</a> -->
                  </div>
                </b-dropdown-item>

                <hr style="padding: 0px; margin: 8px 0px;">
                <div id="inventory-drop-menu">
                  <router-link class="navbar-item is-child"
                                    to="/admin/vue/developers">
                              Developers
                  </router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <router-link to="/admin/vue/projects" class="navbar-item is-child">
                      Projects
                  </router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <router-link  class="navbar-item is-child" 
                                  to="/admin/vue/resale_units"
                    >Resale Units</router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <router-link  class="navbar-item is-child" 
                                  to="/admin/vue/resale_units"
                                  >Rental Units</router-link>  
                </div>
                <div>
                    <b-dropdown-item :custom="true" aria-role="listitem">
                      <div>
                        <p>
                          <img src="/icon/header-marketing.png">
                          <a @mouseover="openMarketingMenu" class="header-menu-item has-child">Marketing</a>
                        </p>
                      </div>
                    </b-dropdown-item>
                  <hr style="padding: 0px; margin: 8px 0px;">
                </div>
                <div id="marketing-drop-menu">
                  <!-- <a @click="redirectRoute(12)" class="navbar-item is-child">Campaigns</a> -->
                  <router-link class="navbar-item is-child" 
                                to="/admin/vue/AllCampaigns"
                  > Campaigns </router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">

                  <router-link class="navbar-item is-child" 
                                to="/admin/vue/Campaign_Type"
                  > Campaigns Types</router-link>
                  
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <router-link class="navbar-item is-child"
                              to="/admin/vue/forms"
                      
                  > Forms</router-link>
                  <!-- <a @click="redirectRoute(16)" class="navbar-item is-child">Forms</a> -->
                </div>
                <div>
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-proposals.png">
                      <router-link to="/admin/vue/allProposals" @mouseover="resethover" class="header-menu-item">
                          Proposals
                      </router-link>
                    </p>
                  </b-dropdown-item>
                  <hr style="padding: 0px; margin: 8px 0px;">
                </div>
                  <div>
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-proposals.png">
                      <router-link to="/admin/vue/allContract" @mouseover="resethover" class="header-menu-item">
                          Contracts
                      </router-link>
                    </p>
                  </b-dropdown-item>
                  <hr style="padding: 0px; margin: 8px 0px;">
                </div>
                   <div>
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-proposals.png">
                      <router-link to="/admin/vue/allInvoices" @mouseover="resethover" class="header-menu-item">
                          Invoices
                      </router-link>
                    </p>
                  </b-dropdown-item>
                  <hr style="padding: 0px; margin: 8px 0px;">
                </div>
                <div>
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-closed-deals.png">
                      <router-link to="/admin/vue/deals" @mouseover="resethover" class="header-menu-item" >
                          Closed Deals
                      </router-link>
                    </p>
                  </b-dropdown-item>
                  <hr style="padding: 0px; margin: 8px 0px;">
                </div>
                <div>
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-finances.png">
                      <router-link class="header-menu-item" to="/admin/vue/FinalFinance">Finances</router-link>
                    </p>
                    <hr style="padding: 0px; margin: 8px 0px;">
                  </b-dropdown-item>
                </div>
                <div >
                  <b-dropdown-item :custom="true" aria-role="listitem">
                    <div>
                      <p>
                        <img src="/icon/header-hr.png">
                        <a @mouseover="openHRMenu" class="header-menu-item has-child">HR</a>
                      </p>
                    </div>
                  </b-dropdown-item>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-closed-deals.png">
                      <router-link to="/admin/vue/traffic" @mouseover="resethover" class="header-menu-item" >
                          Traffic
                      </router-link>
                    </p>
                  </b-dropdown-item>
                </div>
                <div id="hr-drop-menu">
              
                  <!-- <a @click="redirectRoute(20)" class="navbar-item is-child">Job Categories</a> -->
                  <router-link to="/admin/vue/jobCategories" class="navbar-item is-child">Job Categories</router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(21)" class="navbar-item is-child">Job Titles</a> -->
                  <router-link to="/admin/vue/jobTitle" class="navbar-item is-child">Job Titles</router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(22)" class="navbar-item is-child">Vacancies</a> -->
                  <router-link to="/admin/vue/vacancy" class="navbar-item is-child">Vacancies</router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(23)" class="navbar-item is-child">Applications</a> -->
                  <router-link to="/admin/vue/application" class="navbar-item is-child">Applications</router-link>
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(24)" class="navbar-item is-child">Employees</a> -->
                  <router-link to="/admin/vue/employees" class="navbar-item is-child">Employees</router-link>              
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(25)" class="navbar-item is-child">Salaries</a> -->
                  <router-link to="/admin/vue/salaries" class="navbar-item is-child">Salaries</router-link>              
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(26)" class="navbar-item is-child">Salaries Details</a> -->
                  <router-link to="/admin/vue/salariesDetails" class="navbar-item is-child">Salaries Details</router-link>              
                  <hr style="padding: 0px; margin: 8px 0px;">
                  <!-- <a @click="redirectRoute(27)" class="navbar-item is-child">Rules Of Procedure</a> -->
                  <router-link to="/admin/vue/ruleOfProcedure" class="navbar-item is-child">Rules Of Procedure</router-link>              
                </div>
                <div>
                  <b-dropdown-item aria-role="listitem">
                    <p>
                      <img src="/icon/header-reports.png">
                      <!-- <a @mouseover="resethover" class="header-menu-item" 
                      >Reports</a> -->
                                <router-link to="/admin/vue/Reports" class="header-menu-item">Reports </router-link>
                    </p>
                  </b-dropdown-item>
                </div>
                <b-dropdown-item aria-role="listitem">
                  <a v-if="locale == 'ar'" @click="redirectRoute(31)" class="navbar-item lang-bg-screen"
                    style="display: block !important; margin-right: 11rem;">
                    <!-- <i class="fa fa-globe"></i>
                <span id="num" class="label label-danger" style="font-size: 0.5em">en</span> -->
                    <img src="/icon/header-en.png">
                  </a>
                  <a v-else @click="redirectRoute(32)" style="display: block !important; margin-right: 11rem;"
                    class="navbar-item lang-bg-screen">
                    <!-- <i class="fa fa-globe"></i>
                <span id="num" class="label label-danger" style="font-size: 0.5em">ar</span> -->
                    <img src="/icon/header-ar.png">
                  </a>
                </b-dropdown-item>
            </div>
            <!-- End admin vue menu -->
            <!-- start custome role vue menu -->
          </b-dropdown>
          <router-link class="navbar-item followUpDivs" id="followUpDiv" style="width: 6rem !important; font-weight: 700"
            to="/admin/vue/followUp" v-if="userType == 'admin' || userType == 'agent'">
            <i class="fas fa-user" style="font-size: 1.35rem; margin-left: 0.9rem;margin-top:.5vw"></i>
            <!-- <div v-if="pendingTodayTodo > 0" style="cursor: pointer; position: relative; top: -0.5rem;">
              <img class="follow-up-img" src="/icon/followupLoading.gif" style="width: 80%;">
              <span class="follow-up-num"
                style="position: absolute; top: 9%; right: 50%; font-size: 1.05rem; color: #8f9194;">{{ pendingTodayTodo }}</span>
            </div> -->
          </router-link>
  
          <div class="navbar-item team-follow followUpDivs" @click="redirectRoute(35)"
            v-if="userType == 'admin' || userAgentType == 'Team Leader'"
            style="padding-left: 0px;padding-right: 0px; font-weight: 700">
            <p style="display: flex;">
              <i class="fas fa-users" style="font-size: 1.35rem; margin-right: 0.5rem"></i>
            </p>
          </div>
        </div>
      </div>

      <div id="navMenu" class="navbar-menu navbar-menu-content" :class="{ 'is-active': showNav }">
        <div class="navbar-start">
          <router-link to="/admin/vue/followUp" style="display:flex">
            <div class="navbar-item" id="followUpDiv" style="width: 9rem; font-weight: 700"
            v-if="userType == 'admin' || userType == 'agent'">
               <a class="navbar-item" style="padding: 0px">Follow Up</a>
               <!-- <div v-if="pendingTodayTodo > 0" style="cursor: pointer; position: relative; top: -0.5rem;">
                <img class="follow-up-img" src="/icon/followupLoading.gif" style="width: 80%;">
                <span class="follow-up-num"
                  style="position: absolute; top: 9%; right: 50%; font-size: 1.05rem; color: #8f9194;">{{ pendingTodayTodo }}</span>
               </div> -->
            </div>
          </router-link>

          <router-link to="/admin/vue/teamFollowUp" style="display:flex">
              <div class="navbar-item team-follow" v-if="userType == 'admin' || userAgentType == 'Team Leader'"
                style="padding-left: 0px;padding-right: 0px; font-weight: 700">
                <p style="display: flex;">
                  <i class="fas fa-users" style="font-size: 1.35rem; margin-right: 0.5rem"></i>
                  <a class="navbar-item" style="padding: 0px">Team Follow Up</a>
                </p>
              </div>
          </router-link>

          <div class="navbar-item has-dropdown is-hoverable profile-menu-sm-screen" @click="openProfileMenu">
            <a class="navbar-link">
              <!-- <img v-if="image == ''" v-bind:src="defaultImage" class="img-circle" alt="User Image">
                <img else v-bind:src="'uploads/'+ image" class="img-circle" alt="User Image">-->
              <span>{{name}}</span>
            </a>

            <div class="navbar-dropdown" id="profile-drop-menu">
              <a class="navbar-item" @click="redirectRoute(33)">Logout</a>
              <hr class="navbar-divider">
              <a class="navbar-item" v-bind:href="profileUrl">Profile</a>
            </div>
          </div>
          <!-- <div style="display: -webkit-inline-box;">
              <a v-if="locale == 'ar'" @click="redirectRoute(31)" class="navbar-item lang-sm-screen">
                <i class="fa fa-globe"></i>
                <span id="num" class="label label-danger" style="font-size: 0.5em">en</span>
              </a>
              <a v-else @click="redirectRoute(32)" class="navbar-item lang-sm-screen">
                <i class="fa fa-globe"></i>
                <span id="num" class="label label-danger" style="font-size: 0.5em">ar</span>
              </a>
  
              <a
                v-if="userType == 'admin'"
                @click="redirectRoute(34)"
                class="navbar-item setting-sm-screen"
              >
                <i class="fa fa-gears"></i>
              </a>
            </div> -->
        </div>
      </div>

      <div id="navMenu" class="navbar-end">
  
        <!-- <a v-if="locale == 'ar'" href="/admin/language/en" class="navbar-item">
                      <i class="fa fa-envelope"></i>
                      <span class="label label-danger"style="font-size: 0.5em">10</span>
          </a>-->
          <b-dropdown aria-role="menu" class="web_menu" ref="_dropmenu">
            <button @click="ChangeStatusNotification" class="button header-menu-icon" slot="trigger" style="border: unset;">
              <img src="/icon/header-bill.png">
              <!-- <span class="label label-danger" v-if="numOfNotifications > 0" id="num">{{ numOfNotifications }}</span> -->
            </button>
            <!-- <b-dropdown-item id="notifications" class="notifications" style="height: 347px; overflow: scroll;" >
              <div v-for="notification in notifications" :key="notification.id" v-if="notification.status == 0" style="background-color:#edf2fa">
                <a @click="changeStatus(notification.notiy_id)" v-if="notification.type == 'lead'" class="navbar-item notification"
                  v-bind:url="'/admin/vue/showleadDetals/' + notification.id" v-bind:href="'/admin/vue/showleadDetals/' + notification.id">
                  <img v-bind:src="'/images/'+ notification.icon">
                  {{notification.title}}
                  <br>
                  <span class="date">{{notification.diff}}</span>
                </a>
                <a @click="changeStatus(notification.notiy_id)" v-if="notification.type == 'lead'" class="navbar-item notification"
                  v-bind:url="'/admin/vue/showleadDetals/' + notification.id" v-bind:href="'/admin/vue/showleadDetals/' + notification.id">
                  <img v-bind:src="'/images/'+ notification.icon">
                  {{notification.title}}
                  <br>
                  <span class="date">{{notification.diff}}</span>
                </a>
                <a @click="changeStatus(notification.notiy_id)" v-if="notification.type == 'meeting' " class="navbar-item notification"
                  v-bind:url="'/admin/vue/Allmeetings/'" v-bind:href="'/admin/vue/Allmentngs/'">
                  <img v-bind:src="'/images/'+ notification.icon">
                  {{notification.title}}
                  <br>
                  <span class="date">{{notification.diff}}</span>
                </a>
                <a @click="changeStatus(notification.notiy_id)" v-if="notification.type == 'call' " class="navbar-item notification">
                  <img v-bind:src="'/images/'+ notification.icon">
                  {{notification.title}}
                  <br>
                  <span class="date">{{notification.diff}}</span>
                </a>
            </div>
            </b-dropdown-item> -->
          </b-dropdown>
        <a v-if="locale == 'ar'" @click="redirectRoute(31)" class="navbar-item lang-sm-screen"
          style="margin-right: 11rem;">
          <img src="/icon/header-en.png">
        </a>
        <a v-else @click="redirectRoute(32)" style="margin-right: 11rem;" class="navbar-item lang-sm-screen">
          <img src="/icon/header-ar.png">
        </a>

        <div class="navbar-item has-dropdown is-hoverable profile-menu-bg-screen">
          <a class="navbar-link">
            <img src="/icon/header-profile.png" style="margin-right: 0.5rem">
            <span>{{name}}</span>
          </a>

          <div class="navbar-dropdown">
            <a class="navbar-item" @click="redirectRoute(33)">Logout</a>
            <hr class="navbar-divider">
            <a class="navbar-item" v-bind:href="profileUrl">Profile</a>
          </div>
        </div>

        <router-link to="/admin/vue/settings" v-if="userType == 'admin'" class="navbar-item setting-bg-screen">
          <img src="/icon/header-settings.png">
        </router-link>
      </div>
    </div>
  </nav>
  <!-- END NAV -->
</template>

<script>
import menubar from './menu'
  import {
    checkUserGroupAndRoles,
    getNotifications,
    // pendingTodayTodos,
    notification_status,
    ChangeAllNotification,
    clearNumCil
  } from "./../../calls";

  export default {
    data() {
      return {
        name: window.auth_user.name,
        id: window.auth_user.id,
        agentType: window.auth_user.agentType,
        token: window.auth_user.token,
        locale: window.auth_user.locale,
        numOfNotifications: window.auth_user.numOfNotifications,
        profileUrl: window.auth_user.profileUrl,
        image: window.auth_user.image,
        defaultImage: window.auth_user.defaultImage,
        userType: window.auth_user.type,
        userAgentType: window.auth_user.agentType,
        userHr: window.auth_user.userHr,
        permArray: [],
        showNav: false,
        notifications: [],
        pendingTodayTodo: "",
        // time: new Date(),
      };
    },
    created() {
      this.getNotificationsFun();
      setInterval(this.getNotificationsFun, 120000);
    },
    // beforeUpdated(){
    //     this.getNotificationsFun()
    // },
    mounted() {
      this.checkUserHasGroup();
      // this.pendingTodayTodos();
      // setInterval(this.pendingTodayTodos, 120000);
      this.followUpAgentDesign();
    },
    components:{
      'menubar':menubar
    },
    methods: {
      changeStatus(id){
          notification_status(id).then(response=>{
            // console.log('return after change status',response)
              this.numOfNotifications = response.data
          }).catch(error=>{
            console.log(error)
          })
      },
      ChangeStatusNotification(){
        ChangeAllNotification().then(response=>{
          console.log(response)
          this.numOfNotifications = response.data
        }).catch(error=>{
          console.log(error)
        })
        console.log('status')
      },
      // pendingTodayTodos() {
      //   pendingTodayTodos()
      //     .then(response => {
      //       this.pendingTodayTodo = response.data;
      //     })
      //     .catch(error => {
      //       console.log(error);
      //     });
      // },
      getNotificationsFun() {
        // console.log('time',this.dateFormatter())
        getNotifications({
            token: this.token,
            user_id: this.id,
            lang: "en",
          })
          .then(response => {
            this.notifications = response.data;
            console.log('All Noti',this.notifications)
          })
          .catch(error => {
            console.log(error);
          });
      },
        dateFormatter(){
          // var data = new date();
            const [month, day, year] = date.split('/')
            this.parsedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return data
        },
      checkUserHasGroup() {
        checkUserGroupAndRoles()
          .then(response => {
            this.permArray = response.data.permArray;
            console.log('All roles',this.permArray)
          })
          .catch(error => {
            console.log(error);
          });
      },
      redirectRoute($id) {
        if ($id == 1) {
          window.location.href = "/admin/vue/leads";
        }
        // else if($id == 2){
        //     window.location.href = '/admin/calls'
        // }
        else if ($id == 3) {
          window.location.href = "/admin/meetings";
        } else if ($id == 4) {
          window.location.href = "/admin/requests";
        } else if ($id == 5) {
          window.location.href = "/admin/events_request";
        } else if ($id == 6) {
          window.location.href = "/admin/requests_broadcast";
        } else if ($id == 7) {
          window.location.href = "/admin/developers";
        } else if ($id == 8) {
          window.location.href = "/admin/lands";
        } else if ($id == 9) {
          window.location.href = "/admin/projects";
        } else if ($id == 10) {
          window.location.href = "/admin/vue/resale_units";
        } else if ($id == 11) {
          window.location.href = "/admin/vue/rental_units";
        } else if ($id == 12) {
          window.location.href = "/admin/campaigns";
        } else if ($id == 13) {
          window.location.href = "/admin/developers_facebook";
        } else if ($id == 14) {
          window.location.href = "/admin/projects_facebook";
        } else if ($id == 15) {
          window.location.href = "/admin/competitors_facebook";
        } else if ($id == 16) {
          window.location.href = "/admin/forms";
        } else if ($id == 17) {
          window.location.href = "/admin/proposals";
        } else if ($id == 18) {
          window.location.href = "/admin/deals";
        } else if ($id == 19) {
          window.location.href = "/admin/finances";
        } else if ($id == 20) {
          window.location.href = "/admin/job_categories";
        } else if ($id == 21) {
          window.location.href = "/admin/job_titles";
        } else if ($id == 22) {
          window.location.href = "/admin/vacancies";
        } else if ($id == 23) {
          window.location.href = "/admin/applications";
        } else if ($id == 24) {
          window.location.href = "/admin/employees";
        } else if ($id == 25) {
          window.location.href = "/admin/salaries";
        } else if ($id == 26) {
          window.location.href = "/admin/salaries-details";
        } else if ($id == 27) {
          window.location.href = "/admin/rules-procedure";
        } else if ($id == 28) {
          // <router-link to="/admin/vue/Reports"></router-link>
          window.location.href = "/admin/vue/Reports";
        } else if ($id == 29) {
          window.location.href = "/admin/vue/followUp";
        } else if ($id == 30) {
          window.location.href = "/admin/cils#/1";
        } else if ($id == 31) {
          window.location.href = "/admin/language/en";
        } else if ($id == 32) {
          window.location.href = "/admin/language/ar";
        } else if ($id == 33) {
          window.location.href = "/admin/logout";
        } else if ($id == 34) {
          window.location.href = "/admin/vue/settings";
        } else if ($id == 35) {
          window.location.href = "/admin/vue/teamFollowUp";
        }
      },

      followUpAgentDesign() {
        if (this.userType === "agent") {
          document.getElementById("followUpDiv").style.width = "15%";
        }
      },
      resethover() {
        if (window.matchMedia("(max-width: 767px)").matches === true) {
          if (document.getElementById("marketing-drop-menu").style.display === "contents")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "contents")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "contents")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (document.getElementById("lead-drop-menu").style.display === "contents")
            document.getElementById("lead-drop-menu").style.display = "none";

        } else {
          if (document.getElementById("marketing-drop-menu").style.display === "block")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "block")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "block")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (document.getElementById("lead-drop-menu").style.display === "block")
            document.getElementById("lead-drop-menu").style.display = "none";
        }
      },
      openLeadMenu() {
        if (window.matchMedia("(max-width: 767px)").matches === true) {
          if (document.getElementById("marketing-drop-menu").style.display === "contents")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "contents")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "contents")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (
            document.getElementById("lead-drop-menu").style.display === "none" ||
            document.getElementById("lead-drop-menu").style.display === ""
          )
            document.getElementById("lead-drop-menu").style.display = "contents";
          else document.getElementById("lead-drop-menu").style.display = "none";
        } else {
          if (document.getElementById("marketing-drop-menu").style.display === "block")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "block")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "block")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (
            document.getElementById("lead-drop-menu").style.display === "none" ||
            document.getElementById("lead-drop-menu").style.display === ""
          )
            document.getElementById("lead-drop-menu").style.display = "block";
          else document.getElementById("lead-drop-menu").style.display = "none";
        }
      },

      openInventoryMenu() {
        if (window.matchMedia("(max-width: 767px)").matches === true) {
          if (document.getElementById("marketing-drop-menu").style.display === "contents")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("lead-drop-menu").style.display === "contents")
            document.getElementById("lead-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "contents")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (
            document.getElementById("inventory-drop-menu").style.display ===
            "none" ||
            document.getElementById("inventory-drop-menu").style.display === ""
          )
            document.getElementById("inventory-drop-menu").style.display = "contents";
          else
            document.getElementById("inventory-drop-menu").style.display = "none";
        } else {
          if (document.getElementById("marketing-drop-menu").style.display === "block")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("lead-drop-menu").style.display === "block")
            document.getElementById("lead-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "block")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (
            document.getElementById("inventory-drop-menu").style.display ===
            "none" ||
            document.getElementById("inventory-drop-menu").style.display === ""
          )
            document.getElementById("inventory-drop-menu").style.display = "block";
          else
            document.getElementById("inventory-drop-menu").style.display = "none";
        }
      },

      openMarketingMenu() {
        if (window.matchMedia("(max-width: 767px)").matches === true) {
          if (document.getElementById("lead-drop-menu").style.display === "contents")
            document.getElementById("lead-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "contents")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "contents")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (
            document.getElementById("marketing-drop-menu").style.display ===
            "none" ||
            document.getElementById("marketing-drop-menu").style.display === ""
          )
            document.getElementById("marketing-drop-menu").style.display = "contents";
          else
            document.getElementById("marketing-drop-menu").style.display = "none";
        } else {
          if (document.getElementById("lead-drop-menu").style.display === "block")
            document.getElementById("lead-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "block")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (document.getElementById("hr-drop-menu").style.display === "block")
            document.getElementById("hr-drop-menu").style.display = "none";

          if (
            document.getElementById("marketing-drop-menu").style.display ===
            "none" ||
            document.getElementById("marketing-drop-menu").style.display === ""
          )
            document.getElementById("marketing-drop-menu").style.display = "block";
          else
            document.getElementById("marketing-drop-menu").style.display = "none";
        }
      },

      openHRMenu() {
        if (window.matchMedia("(max-width: 767px)").matches === true) {
          if (document.getElementById("marketing-drop-menu").style.display === "contents")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("lead-drop-menu").style.display === "contents")
            document.getElementById("lead-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "contents")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (
            document.getElementById("hr-drop-menu").style.display === "none" ||
            document.getElementById("hr-drop-menu").style.display === ""
          )
            document.getElementById("hr-drop-menu").style.display = "contents";
          else document.getElementById("hr-drop-menu").style.display = "none";
        } else {
          if (document.getElementById("marketing-drop-menu").style.display === "block")
            document.getElementById("marketing-drop-menu").style.display = "none";

          if (document.getElementById("lead-drop-menu").style.display === "block")
            document.getElementById("lead-drop-menu").style.display = "none";

          if (document.getElementById("inventory-drop-menu").style.display === "block")
            document.getElementById("inventory-drop-menu").style.display = "none";

          if (
            document.getElementById("hr-drop-menu").style.display === "none" ||
            document.getElementById("hr-drop-menu").style.display === ""
          )
            document.getElementById("hr-drop-menu").style.display = "block";
          else document.getElementById("hr-drop-menu").style.display = "none";
        }
      },

      // openLeadMenuMobile() {
      //   if(window.matchMedia("(max-width: 767px)").matches === true){
      //     if (
      //       document.getElementById("lead-drop-menu").style.display === "none" ||
      //       document.getElementById("lead-drop-menu").style.display === ""
      //     )
      //       document.getElementById("lead-drop-menu").style.display = "contents";
      //     else document.getElementById("lead-drop-menu").style.display = "none";
      //   }
      // },

      // openInventoryMenuMobile() {
      //   if (
      //     document.getElementById("inventory-drop-menu").style.display ===
      //       "none" ||
      //     document.getElementById("inventory-drop-menu").style.display === ""
      //   )
      //     document.getElementById("inventory-drop-menu").style.display = "block";
      //   else
      //     document.getElementById("inventory-drop-menu").style.display = "none";
      // },

      // openMarketingMenuMobile() {
      //   if (
      //     document.getElementById("marketing-drop-menu").style.display ===
      //       "none" ||
      //     document.getElementById("marketing-drop-menu").style.display === ""
      //   )
      //     document.getElementById("marketing-drop-menu").style.display = "block";
      //   else
      //     document.getElementById("marketing-drop-menu").style.display = "none";
      // },

      // openHRMenuMobile() {
      //   if (
      //     document.getElementById("hr-drop-menu").style.display === "none" ||
      //     document.getElementById("hr-drop-menu").style.display === ""
      //   )
      //     document.getElementById("hr-drop-menu").style.display = "block";
      //   else document.getElementById("hr-drop-menu").style.display = "none";
      // },

      openProfileMenu() {
        if (
          document.getElementById("profile-drop-menu").style.display === "none" ||
          document.getElementById("profile-drop-menu").style.display === ""
        )
          document.getElementById("profile-drop-menu").style.display = "block";
        else document.getElementById("profile-drop-menu").style.display = "none";
      },

      openNotification() {
        let x = window.matchMedia("(max-width: 1087px)").matches;
        if (x === true) {
          if (
            document.getElementById("notifications").style.display === "none" ||
            document.getElementById("notifications").style.display === ""
          )
            document.getElementById("notifications").style.display = "block";
          else document.getElementById("notifications").style.display = "none";
        }
      },
    }
  };
</script>

<style type="text/css" scoped="">
  #num {
    background-color: red;
    padding: 4px 7px;
    color: white;
    border-radius: 50%;
    font-size: 12px;
  }

  .fa {
    font-size: 25px;
  }

  .notifications {
    right: 0px;
    left: auto;
    width: 426px;
  }

  .notifications a.notification {
    /* padding-right: 70px; */
    white-space: normal;
    /* background-color:white; */
  }

  .notifications img {
    width: 30px;
    margin-right: 10px;
    margin-top:10px;
  }

  .notifications span.date {
    font-size: 10px;
    position: absolute;
    bottom: -17px;
    left: 60px;
  }

  /* ------------------- */
  .navbar-end>a.navbar-item,
  .navbar-end .has-dropdown {
    display: inline-flex;
  }

  .navbar-end .navbar-dropdown {
    display: none;
  }

  .navbar-item:hover {
    color: #9e6900 !important;
  }

  /* ------------------------------------------------------------------------------------------------------------------------------ */
  /* header vue js responsive*/
  @media screen and (max-width: 1087px) {
    .navbar-brand {
      width: fit-content !important;
    }

    .header-container {
      position: relative !important;
      height: 1 !important;
    }

    .navbar-end {
      width: fit-content !important;
      position: absolute;
      margin: auto;
      right: 0;
      bottom: 0;
      left: 0;
    }

    #num {
      display: -webkit-inline-box;
    }

    .navbar-menu-content {
      top: 121% !important;
      width: 100% !important;
    }

    #lead-drop-menu,
    #inventory-drop-menu,
    #marketing-drop-menu,
    #hr-drop-menu,
    #profile-drop-menu {
      display: none;
    }

    .profile-menu-bg-screen {
      display: none !important;
    }

    .team-follow {
      padding: 0.5rem 0.75rem !important;
    }

    .menu-icon {
      position: absolute !important;
      right: 10% !important;
    }

    .navbar-brand {
      margin-left: 3% !important;
    }

    .navbar-menu {
      margin-left: unset !important;
    }

    #followUpDiv {
      width: 100% !important;
    }

    .msg-num {
      margin-top: 10%;
    }

    .follow-up-img {
      width: 15% !important;
      margin-top: -2% !important;
    }

    #followUpDiv {
      display: -webkit-inline-box !important;
    }

    .follow-up-num {
      top: -7% !important;
      left: 5% !important;
      font-size: 1rem !important;
      right: unset !important;
    }

    .notifications {
      position: absolute !important;
      top: 92% !important;
      width: 260% !important;
      background: white !important;
    }
  }

  @media screen and (min-width: 1087px) {

    .profile-menu-sm-screen,
    .setting-sm-screen {
      display: none !important;
    }

    /* #followUpDiv {
    width: 12% !important;
  } */
  }

  .header-menu-item {
    vertical-align: bottom;
    font-size: 1.05rem;
    margin: 0 0 0 1rem;
  }

  .header-menu-item.has-child::after {
    content: '\f105';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    margin-left: 10px;
  }

  .header-menu-item-hover:hover .header-menu-item,
  .header-menu-item:hover {
    color: black !important;
  }



  #lead-drop-menu,
  #inventory-drop-menu,
  #marketing-drop-menu,
  #hr-drop-menu {
    position: absolute;
    /* left: 12.5rem; */
    left: 15rem;
    background: white;
    padding: 1rem;
    width: fit-content;
    display: none;
    border-radius: 4px;
    box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
  }


  #lead-drop-menu {
    /* top: 0.5rem; */
    top: -4px;
    width: 180px;
  }

  #inventory-drop-menu {
    /* top: 2rem; */
    top: 4rem;
    width: 180px;
  }

  #marketing-drop-menu {
    /* top: 4rem; */
    top: 7.5rem;
    width: 180px;
  }

  #hr-drop-menu {
    /* top: 12rem; */
    top: 22rem;
    width: 180px;
  }

  @media screen and (max-width:1087px) {
    #inventory-drop-menu .navbar-item {
      padding-left: 29px;
    }

    #marketing-drop-menu .navbar-item {
      padding-left: 29px;
    }

    #hr-drop-menu .navbar-item {
      padding-left: 29px;
    }
  }

  .navbar-item {
    font-size: 1rem;
    font-weight: unset;
  }

  .navbar-item.is-child {
    line-height: 2;
  }


  .navbar-link:not(.is-arrowless)::after {
    display: none;
  }

  #num {
    margin-top: -1rem;
    margin-left: -0.5rem;
  }

  #navMenu {
    margin-right: 4rem;
  }

  .lang-bg-screen {
    margin-right: 10rem;
  }

  @media screen and (max-width: 767px) {
    .lang-sm-screen {
      margin-right: unset !important;
    }

    .lang-bg-screen,
    .lang-sm-screen,
    .notification-div,
    .message-div {
      display: none !important;
    }

    .followUpDivs {
      display: block !important;
    }

    .followUpDivs .follow-up-img {
      width: 45% !important;
    }

    .followUpDivs .follow-up-num {
      top: 17% !important;
      left: 18% !important;
    }
  }

  .followUpDivs {
    display: none;
  }
</style>

<style>
  @import url(/css/main-colors.css);
</style>