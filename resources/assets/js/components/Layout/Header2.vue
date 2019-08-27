<template>
        <!-- START NAV -->
        <nav class="navbar is-white is-fixed-top">
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
            integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
          <div class="container is-fluid header-container">
            <div class="navbar-brand">
              <div class="navbar-item">
                <a href="/admin">
                  <img src="/uploads/logo.png" alt width="50" height="50">
                </a>
                <b-dropdown aria-role="menu" ref="_dropmenu">
                  <button class="button header-menu-icon" slot="trigger" style="border: unset;">
                    <i class="fas fa-bars" style="font-size: 1.25rem; margin-left: 1rem;"></i>
                  </button>
                  <b-dropdown-item :custom="true" aria-role="listitem" class="header-menu-item-hover m-2">
                    <div @mouseover="openLeadMenu" v-if="permArray.add_leads == 1
                              || permArray.switch_leads == 1
                              || permArray.edit_leads == 1
                              || permArray.show_all_leads == 1
                              || permArray.send_cil == 1
                              || permArray.calls == 1
                              || permArray.meetings == 1
                              || permArray.requests == 1
                              || userType == 'admin'">
                      <p>
                        <img src="/icon/header-lead.png">
                        <a class="header-menu-item">Lead</a>
                      </p>
                    </div>
                    <div id="lead-drop-menu" style="">
                      <a class="navbar-item" @click="redirectRoute(1)" v-if="permArray.add_leads == 1
                                  || permArray.switch_leads == 1
                                  || permArray.edit_leads == 1
                                  || permArray.show_all_leads == 1
                                  || permArray.send_cil == 1
                                  || userType == 'admin'">All Leads</a>
      
                      <!-- <a @click="redirectRoute(2)" class="navbar-item" v-if="permArray.calls == 1 || userType == 'admin'">Calls</a> -->
                      <a @click="redirectRoute(3)" class="navbar-item"
                        v-if="permArray.meetings == 1 || userType == 'admin'">Meetings</a>
                      <a @click="redirectRoute(4)" class="navbar-item"
                        v-if="permArray.requests == 1 || userType == 'admin'">Requests</a>
                      <a @click="redirectRoute(5)" class="navbar-item">Events</a>
                      <a @click="redirectRoute(6)" class="navbar-item">Requests Broadcast</a>
                    </div>
                  </b-dropdown-item>
      
                  <b-dropdown-item :custom="true" aria-role="listitem" class="header-menu-item-hover">
                    <div @mouseover="openInventoryMenu" v-if="permArray.add_developers == 1
                              || permArray.edit_developers == 1
                              || permArray.delete_developers == 1
                              || permArray.show_developers == 1
                              || permArray.add_projects == 1
                              || permArray.edit_projects == 1
                              || permArray.delete_projects == 1
                              || permArray.show_projects == 1
                              || permArray.add_phases == 1
                              || permArray.edit_phases == 1
                              || permArray.delete_phases == 1
                              || permArray.show_phases == 1
                              || permArray.add_properties == 1
                              || permArray.edit_properties == 1
                              || permArray.delete_properties == 1
                              || permArray.show_properties == 1
                              || permArray.add_resale_units == 1
                              || permArray.edit_resale_units == 1
                              || permArray.delete_resale_units == 1
                              || permArray.show_resale_units == 1
                              || permArray.add_rental_units == 1
                              || permArray.edit_rental_units == 1
                              || permArray.delete_rental_units == 1
                              || permArray.show_rental_units == 1
                              || permArray.add_lands == 1
                              || permArray.edit_lands == 1
                              || permArray.delete_lands == 1
                              || permArray.show_lands == 1
                              || userType == 'admin'">
                      <p>
                        <img src="/icon/header-inventory.png">
                        <a class="header-menu-item">Inventory</a>
                      </p>
                    </div>
                  </b-dropdown-item>
                  <div id="inventory-drop-menu">
                    <a @click="redirectRoute(7)" class="navbar-item" v-if="permArray.add_developers == 1
                                  || permArray.edit_developers == 1
                                  || permArray.delete_developers == 1
                                  || permArray.show_developers == 1
                                  || userType == 'admin'">Developers</a>
                    <a @click="redirectRoute(8)" class="navbar-item" v-if="permArray.add_lands == 1
                                  || permArray.edit_lands == 1
                                  || permArray.delete_lands == 1
                                  || permArray.show_lands == 1
                                  || userType == 'admin'">Lands</a>
                    <a @click="redirectRoute(9)" class="navbar-item" v-if="permArray.add_projects == 1
                                  || permArray.edit_projects == 1
                                  || permArray.delete_projects == 1
                                  || permArray.show_projects == 1
                                  || userType == 'admin'">Projects</a>
                    <a @click="redirectRoute(10)" class="navbar-item" v-if="permArray.add_resale_units == 1
                                  || permArray.edit_resale_units == 1
                                  || permArray.delete_resale_units == 1
                                  || permArray.show_resale_units == 1
                                  || userType == 'admin'">Resale Units</a>
                    <a @click="redirectRoute(11)" class="navbar-item" v-if="permArray.add_rental_units == 1
                                  || permArray.edit_rental_units == 1
                                  || permArray.delete_rental_units == 1
                                  || permArray.show_rental_units == 1
                                  || userType == 'admin'">Rental Units</a>
                  </div>
                  <b-dropdown-item :custom="true" aria-role="listitem">
                    <div @mouseover="openMarketingMenu" v-if="permArray.marketing == 1
                              || userType == 'admin'">
                      <p>
                        <img src="/icon/header-marketing.png">
                        <a class="header-menu-item">Marketing</a>
                      </p>
                    </div>
                  </b-dropdown-item>
                  <div id="marketing-drop-menu">
                    <a @click="redirectRoute(12)" class="navbar-item">Campaigns</a>
                    <a @click="redirectRoute(13)" class="navbar-item">Developers</a>
                    <a @click="redirectRoute(14)" class="navbar-item">Projects</a>
                    <a @click="redirectRoute(15)" class="navbar-item">Competitors</a>
                    <a @click="redirectRoute(16)" class="navbar-item">Forms</a>
                  </div>
                  <b-dropdown-item @click="redirectRoute(17)" aria-role="listitem">
                    <p>
                      <img src="/icon/header-proposals.png">
                      <a class="header-menu-item" v-if="permArray.marketing == 1
                              || userType == 'admin'">Proposals</a>
                    </p>
                  </b-dropdown-item>
                  <b-dropdown-item @click="redirectRoute(18)" aria-role="listitem">
                    <p>
                      <img src="/icon/header-closed-deals.png">
                      <a class="header-menu-item" v-if="permArray.deals == 1
                              || userType == 'admin'">Closed Deals</a>
                    </p>
                  </b-dropdown-item>
                  <b-dropdown-item @click="redirectRoute(19)" aria-role="listitem">
                    <p>
                      <img src="/icon/header-finances.png">
                      <a class="header-menu-item" v-if="permArray.finance == 1
                              || userType == 'admin'">Finances</a>
                    </p>
                  </b-dropdown-item>
                  <b-dropdown-item :custom="true" aria-role="listitem">
                    <div @mouseover="openHRMenu" v-if="userHr == 1
                              || userType == 'admin'">
                      <p>
                        <img src="/icon/header-hr.png">
                        <a class="header-menu-item">HR</a>
                      </p>
                    </div>
                  </b-dropdown-item>
                  <div id="hr-drop-menu">
                    <a @click="redirectRoute(20)" class="navbar-item">Job Categories</a>
                    <a @click="redirectRoute(21)" class="navbar-item">Job Titles</a>
                    <a @click="redirectRoute(22)" class="navbar-item">Vacancies</a>
                    <a @click="redirectRoute(23)" class="navbar-item">Applications</a>
                    <a @click="redirectRoute(24)" class="navbar-item">Employees</a>
                    <a @click="redirectRoute(25)" class="navbar-item">Salaries</a>
                    <a @click="redirectRoute(26)" class="navbar-item">Salaries Details</a>
                    <a @click="redirectRoute(27)" class="navbar-item">Rules Of Procedure</a>
                  </div>
                  <b-dropdown-item aria-role="listitem" @click="redirectRoute(28)">
                    <p>
                      <img src="/icon/header-reports.png">
                      <a class="header-menu-item" v-if="permArray.reports == 1
                              || userType == 'admin'">Reports</a>
                    </p>
                  </b-dropdown-item>
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
                </b-dropdown>
                <div class="navbar-item followUpDivs" id="followUpDiv" style="width: 6rem !important; font-weight: 700"
                  @click="redirectRoute(29)" v-if="userType == 'admin' || userType == 'agent'">
                  <i class="fas fa-user" style="font-size: 1.35rem; margin-right: 0.5rem"></i>
                  <div v-if="pendingTodayTodo > 0" style="cursor: pointer; position: relative; top: -0.5rem;">
                    <img class="follow-up-img" src="/icon/followupLoading.gif" style="width: 80%;">
                    <span class="follow-up-num"
                      style="position: absolute; top: 9%; right: 50%; font-size: 1.05rem; color: #8f9194;">{{ pendingTodayTodo }}</span>
                  </div>
                </div>
      
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
                <div class="navbar-item" id="followUpDiv" style="width: 9rem; font-weight: 700" @click="redirectRoute(29)"
                  v-if="userType == 'admin' || userType == 'agent'">
                  <a class="navbar-item" style="padding: 0px">Follow Up</a>
                  <div v-if="pendingTodayTodo > 0" style="cursor: pointer; position: relative; top: -0.5rem;">
                    <img class="follow-up-img" src="/icon/followupLoading.gif" style="width: 80%;">
                    <span class="follow-up-num"
                      style="position: absolute; top: 9%; right: 50%; font-size: 1.05rem; color: #8f9194;">{{ pendingTodayTodo }}</span>
                  </div>
                </div>
      
                <div class="navbar-item team-follow" @click="redirectRoute(35)"
                  v-if="userType == 'admin' || userAgentType == 'Team Leader'"
                  style="padding-left: 0px;padding-right: 0px; font-weight: 700">
                  <p style="display: flex;">
                    <i class="fas fa-users" style="font-size: 1.35rem; margin-right: 0.5rem"></i>
                    <a class="navbar-item" style="padding: 0px">Team Follow Up</a>
                  </p>
                  <!-- <a class="navbar-item" style="padding: 0px">Team Follow Up</a> -->
                  <!-- <div v-if="pendingTodayTodo > 0" style="cursor: pointer">
                                  <img src="/icon/followupLoading.gif" style="width: 100%;">
                                  <span style="position: absolute; top: 25%; right: 18%; font-size: 1.05rem; color: #8f9194;">{{ pendingTodayTodo }}</span>
                  </div>-->
                </div>
      
      
      
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
              <a v-if="userType == 'admin'" @click="redirectRoute(30)" class="navbar-item message-div">
                <img src="/icon/header-message.png">
                <span class="label label-danger msg-num" id="num">{{numOfCil}}</span>
              </a>
      
              <!-- <a v-if="locale == 'ar'" href="/admin/language/en" class="navbar-item">
                          <i class="fa fa-envelope"></i>
                          <span class="label label-danger"style="font-size: 0.5em">10</span>
              </a>-->
      
              <div class="navbar-item has-dropdown is-hoverable notification-div">
                <a class="navbar-link" @click="openNotification" style="padding-right: 0.5rem;">
                  <img src="/icon/header-bill.png">
                  <span class="label label-danger" id="num">{{ numOfNotifications }}</span>
                </a>
      
                <div class="navbar-dropdown notifications" id="notifications" style="height: 347px; overflow: scroll;">
                  <div v-for="notification in notifications" :key="notification.id">
                    <a v-if="notification.type == 'lead' " class="navbar-item notification"
                      v-bind:url="'/admin/leads/' + notification.id" v-bind:href="'/admin/leads/' + notification.id">
                      <img v-bind:src="'/images/'+ notification.icon">
                      {{notification.title}}
                      <br>
                      <span class="date">{{notification.diff}}</span>
                    </a>
                    <router-view v-if="notification.type == 'switch'" :to="admin/vue/showleadDetals/+notification.type_id "></router-view>
                    <hr class="navbar-divider">
                  </div>
                </div>
              </div>
      
              <a v-if="locale == 'ar'" @click="redirectRoute(31)" class="navbar-item lang-sm-screen"
                style="margin-right: 11rem;">
                <!-- <i class="fa fa-globe"></i>
                <span id="num" class="label label-danger" style="font-size: 0.5em">en</span> -->
                <img src="/icon/header-en.png">
              </a>
              <a v-else @click="redirectRoute(32)" style="margin-right: 11rem;" class="navbar-item lang-sm-screen">
                <!-- <i class="fa fa-globe"></i>
                <span id="num" class="label label-danger" style="font-size: 0.5em">ar</span> -->
                <img src="/icon/header-ar.png">
              </a>
      
              <div class="navbar-item has-dropdown is-hoverable profile-menu-bg-screen">
                <a class="navbar-link">
                  <!-- <img v-if="image == ''" v-bind:src="defaultImage" class="img-circle" alt="User Image">
                  <img else v-bind:src="'uploads/'+ image" class="img-circle" alt="User Image">-->
                  <img src="/icon/header-profile.png" style="margin-right: 0.5rem">
                  <span>{{name}}</span>
                </a>
      
                <div class="navbar-dropdown">
                  <a class="navbar-item" @click="redirectRoute(33)">Logout</a>
                  <hr class="navbar-divider">
                  <a class="navbar-item" v-bind:href="profileUrl">Profile</a>
                </div>
              </div>
      
              <a v-if="userType == 'admin'" @click="redirectRoute(34)" class="navbar-item setting-bg-screen">
                <!-- <i class="fa fa-gears"></i> -->
                <img src="/icon/header-settings.png">
              </a>
            </div>
          </div>
        </nav>
        <!-- END NAV -->
      </template>
      
      <script>
        import {
          checkUserGroupAndRoles,
          getNotifications,
          pendingTodayTodos
        } from "./../../calls";
      
        export default {
          data() {
            return {
              name: window.auth_user.name,
              id: window.auth_user.id,
              numOfCil: window.auth_user.numOfCil,
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
              pendingTodayTodo: ""
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
            this.pendingTodayTodos();
            setInterval(this.pendingTodayTodos, 120000);
            this.followUpAgentDesign();
          },
          methods: {
            pendingTodayTodos() {
              pendingTodayTodos()
                .then(response => {
                  this.pendingTodayTodo = response.data;
                })
                .catch(error => {
                  console.log(error);
                });
            },
            getNotificationsFun() {
              getNotifications({
                  token: this.token,
                  user_id: this.id,
                  lang: "en"
                })
                .then(response => {
                  this.notifications = response.data;
                })
                .catch(error => {
                  console.log(error);
                });
            },
            checkUserHasGroup() {
              checkUserGroupAndRoles()
                .then(response => {
                  this.permArray = response.data.permArray;
                })
                .catch(error => {
                  console.log(error);
                });
            },
            redirectRoute($id) {
              if ($id == 1) {
                window.location.href = "/admin/leads#/MyLeads/1";
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
                window.location.href = "/admin/resale_units";
              } else if ($id == 11) {
                window.location.href = "/admin/rental_units";
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
                window.location.href = "/admin/reports";
              } else if ($id == 29) {
                window.location.href = "/admin/followUp";
              } else if ($id == 30) {
                window.location.href = "/admin/cils#/1";
              } else if ($id == 31) {
                window.location.href = "/admin/language/en";
              } else if ($id == 32) {
                window.location.href = "/admin/language/ar";
              } else if ($id == 33) {
                window.location.href = "/admin/logout";
              } else if ($id == 34) {
                window.location.href = "/admin/settings_menu";
              } else if ($id == 35) {
                window.location.href = "/admin/teamFollowUp";
              }
            },
      
            followUpAgentDesign() {
              if (this.userType === "agent") {
                document.getElementById("followUpDiv").style.width = "15%";
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
          padding-right: 70px;
          white-space: normal;
        }
      
        .notifications img {
          width: 40px;
          margin-right: 10px;
        }
      
        .notifications span.date {
          font-size: 10px;
          position: absolute;
          bottom: 10px;
          right: 10px;
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
          color: #4a4a4a;
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
      
        .header-menu-item-hover:hover .header-menu-item,
        .header-menu-item:hover {
          color: black !important;
        }
      
        #lead-drop-menu,
        #inventory-drop-menu,
        #marketing-drop-menu,
        #hr-drop-menu {
          position: absolute;
          left: 12.5rem;
          background: white;
          padding: 1rem;
          width: fit-content;
          display: none
        }
      
        #lead-drop-menu {
          top: 0.5rem;
        }
      
        #inventory-drop-menu {
          top: 2rem;
        }
      
        #marketing-drop-menu {
          top: 4rem;
        }
      
        #hr-drop-menu {
          top: 12rem;
        }
      
        .navbar-item {
          font-size: 1rem;
          font-weight: unset;
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