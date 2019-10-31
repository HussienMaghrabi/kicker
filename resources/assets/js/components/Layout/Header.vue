<template>
 <!-- hellow first change to push -->
  <!-- START NAV -->
  <nav class="navbar is-white is-fixed-top">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/all.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/v4-shims.css">



<menubar ></menubar>
 <sidebar-menu v-if="show_hide" class="hide_mobile vsm_collapsed " :menu="menu"  />
 <img style="height: 47px;width: 47px;padding: 5px;" v-on:click="show_hide=!show_hide" src="/images/download-icon.png" />
    <div style="padding:5px" class="container is-fluid header-container">
      <div class="navbar-brand">
        <div class="navbar-item">
          <router-link to="/admin/vue/dashboard">
            <img src="/uploads/logo.png" alt width="50" height="50">                    
          </router-link>
         
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

        <router-link to="/admin/vue/settings" v-if="userType == 'admin'" class="navbar-item setting-bg-screen ">
          <img src="/icon/header-settings.png" >
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
       show_hide:false,
        
      
          menu: [
          

                {
                    href: '',
                    title: 'Lead',
                     icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-lead.png"              
                         
                     }
                   },
                    child: [
                            {
                                href: '/admin/vue/Leads',
                                title: 'All Leads'
                            },
                             {
                                href: '/admin/vue/AllMeeting',
                                title: 'Meetings'
                            },
                             {
                                href: '/admin/vue/AllRequests',
                                title: 'Requests'
                            }
                        ]
                      
                },
           
                {
                   href:'',
                   title: 'Markiting',
                   icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-marketing.png"               
                         
                     }
                   },
                   child: [
                            {
                                href: '/admin/vue/AllCampaigns',
                                title: 'Campaigns'
                            },
                             {
                                href: '/admin/vue/Campaign_Type',
                                title: 'Campaigns Types'
                            },
                             {
                                href: '/admin/vue/forms',
                                title: 'Forms'
                            },
                            
                        ]


                },
                {
                   href:'/admin/vue/allProposals',
                   title: 'Proposals',
                   icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-proposals.png"               
                         
                     }
                   }


                },
                {
                   href:'/admin/vue/allContract',
                   title: 'Contracts',
                   icon: 
                   {
                     element :'img',
                      attributes: {
                     src : "/icon/header-proposals.png"              
                         
                     }              
                   }


                },
                 {
                   href:'/admin/vue/allInvoices',
                   title: 'Invoices',
                   icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-proposals.png"               
                         
                     }
                   }


                },
                 {
                   href:'/admin/vue/deals',
                   title: 'Closed Deals',
                  icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-closed-deals.png"               
                         
                     }
                   }


                },
                 {
                   href:'/admin/vue/FinalFinance',
                   title: 'Finances',
                    icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-finances.png"               
                         
                     }
                   }


                },
                 {
                   href:'',
                   title: 'HR',
                    icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-hr.png"               
                         
                     }
                   },
                   child: [
                            {
                                href: '/admin/vue/jobCategories',
                                title: 'Job Categories'
                            },
                             {
                                href: '/admin/vue/jobTitle',
                                title: 'Job Titles'
                            },
                             {
                                href: '/admin/vue/vacancy',
                                title: 'Vacancies'
                            },
                             {
                                href: '/admin/vue/application',
                                title: 'Applications'
                            },
                             {
                                href: '/admin/vue/employees',
                                title: 'Employees'
                            },
                             {
                                href: '/admin/vue/salaries',
                                title: 'Salaries'
                            },
                              {
                                href: '/admin/vue/salariesDetails',
                                title: 'Salaries Details'
                            },
                              {
                                href: '/admin/vue/ruleOfProcedure',
                                title: 'Rules Of Procedure'
                            },
                            
                        ]
                },
                 {
                   href:'/admin/vue/traffic',
                   title: 'Traffic',
                   icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-closed-deals.png"               
                         
                     }
                   }


                },
                 {
                   href:'/admin/vue/Reports',
                   title: 'Reports',
                    icon: 
                   {
                     element :'img',
                     attributes: {
                     src : "/icon/header-reports.png"               
                         
                     }
                   }

                },
                
              
          ],
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
.header-menu-icon, .header-menu-item, .fa-users, .fa-user, .menu-icon, .menu-div ul li a, .filter-title, .filter-title i, .unit-details-value, .unit-rooms-value, .footer-btns:hover
{
  color: #7e7286 !important;
}
nav.navbar
{
  border-bottom: 5px solid rgb(126, 114, 134);
}
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
    .hide_mobile
    {
      display: none
    }
  }

  .followUpDivs {
    display: none;
  }
.v-sidebar-menu
{
  top: 66px;
  height: 90vh;
}
.display_hide
{
  display: none
}
</style>

<style>
  @import url(/css/main-colors.css);
</style>