<template>
<div class="sidebar-menu-responsev">
    <div class="wui-side-menu open pinned" style="background-color:#FFF !important">
        <div class="wui-side-menu-header">
            <a href="#" class="wui-side-menu-trigger"><i class="fa fa-bars"></i></a>
            <a href="#" class="wui-side-menu-pin-trigger">
            <i class="fa fa-thumb-tack"></i>
            </a>
        </div>
        <b-menu-list label="Menu">
            <b-menu-item v-if="permArray.add_leads == 1
                          || permArray.switch_leads == 1
                          || permArray.edit_leads == 1
                          || permArray.show_all_leads == 1
                          || permArray.send_cil == 1
                          || permArray.calls == 1
                          || permArray.meetings == 1
                          || permArray.requests == 1
                          || userType == 'admin'"
                           icon="settings">
                <template slot="label" slot-scope="props">
                    Leads
                    <b-icon
                        class="is-pulled-right"
                        :icon="props.expanded ? 'menu-down' : 'menu-up'">
                    </b-icon>
                </template>
                <router-link v-if="permArray.add_leads == 1
                            || permArray.switch_leads == 1
                            || permArray.edit_leads == 1
                            || permArray.show_all_leads == 1
                            || permArray.send_cil == 1
                            || permArray.calls == 1
                            || permArray.meetings == 1
                            || permArray.requests == 1
                            || userType == 'admin'"
                             to="/admin/vue/leads">
                    <b-menu-item icon="user" label="All leads"></b-menu-item>
                </router-link>
                <router-link to="/admin/vue/AllMeeting" v-if="permArray.meetings == 1 || userType == 'admin'">
                    <b-menu-item icon="users" label="Meetings"></b-menu-item>
                </router-link>
                <router-link to="/admin/vue/AllRequests" v-if="permArray.requests == 1 || userType == 'admin'">
                <b-menu-item icon="user" label="Requests" disabled></b-menu-item>
                </router-link>
            </b-menu-item>
            <b-menu-item v-if="permArray.add_developers == 1
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
                          || userType == 'admin'"
                           icon="settings">
                <template slot="label" slot-scope="props">
                    Inventory
                    <b-icon
                        class="is-pulled-right"
                        :icon="props.expanded ? 'menu-down' : 'menu-up'">
                    </b-icon>
                </template>
                <router-link v-if="permArray.add_developers == 1
                              || permArray.edit_developers == 1
                              || permArray.delete_developers == 1
                              || permArray.show_developers == 1
                              || userType == 'admin'"
                               to="/admin/vue/developers">
                    <b-menu-item icon="user" label="Developers"></b-menu-item>
                </router-link>
                <!-- <router-link v-if="permArray.add_lands == 1
                              || permArray.edit_lands == 1
                              || permArray.delete_lands == 1
                              || permArray.show_lands == 1
                              || userType == 'admin'"
                               to="admin/vue/">
                    <b-menu-item icon="users" label="Lands"></b-menu-item>
                </router-link> -->
                <router-link v-if="permArray.add_projects == 1
                              || permArray.edit_projects == 1
                              || permArray.delete_projects == 1
                              || permArray.show_projects == 1
                              || userType == 'admin'"
                               to="/admin/vue/projects">
                    <b-menu-item icon="user" label="Projects" disabled></b-menu-item>
                </router-link>
                <router-link v-if="permArray.add_resale_units == 1
                              || permArray.edit_resale_units == 1
                              || permArray.delete_resale_units == 1
                              || permArray.show_resale_units == 1
                              || userType == 'admin'"
                              to="/admin/vue/resale_units">
                    <b-menu-item icon="users" label="Units" disabled></b-menu-item>
                </router-link>
            </b-menu-item>
            <b-menu-item v-if="permArray.marketing == 1 || userType == 'admin'" icon="settings">
                <template slot="label" slot-scope="props">
                    Marketing
                    <b-icon
                        class="is-pulled-right"
                        :icon="props.expanded ? 'menu-down' : 'menu-up'">
                    </b-icon>
                </template>
                <router-link to="/admin/vue/AllCampaigns">
                    <b-menu-item icon="user" label="Campaigns"></b-menu-item>
                </router-link>
                <router-link to="/admin/vue/Campaign_Type">
                    <b-menu-item icon="users" label="Campaign Types"></b-menu-item>
                </router-link>
                <router-link to="/admin/vue/forms">
                    <b-menu-item icon="users" label="Forms" disabled></b-menu-item>
                </router-link>
            </b-menu-item>
            <router-link to="/admin/vue/proposals">
                <b-menu-item  v-if="permArray.marketing == 1 || userType == 'admin'" icon="information-outline" label="Proposals"></b-menu-item>
            </router-link>
            <router-link to="deals">
                <b-menu-item v-if="permArray.deals == 1 || userType == 'admin'" icon="information-outline" label="Closed Deals"></b-menu-item>
            </router-link>
            <router-link to="financeSettings">
                <b-menu-item v-if="permArray.finance == 1 || userType == 'admin'" icon="information-outline" label="Finances"></b-menu-item>
            </router-link>
            <b-menu-item v-if="userHr == 1 || userType == 'admin'" icon="settings">
                <template slot="label" slot-scope="props">
                    HR
                    <b-icon
                        class="is-pulled-right"
                        :icon="props.expanded ? 'menu-down' : 'menu-up'">
                    </b-icon>
                </template>
                <router-link to="admin/vue/jobCategories">
                    <b-menu-item icon="user" label="Job Categories"></b-menu-item>
                </router-link>
                <router-link to="admin/vue/jobTitle">
                    <b-menu-item icon="users" label="Job Titles"></b-menu-item>
                </router-link>
                <router-link to="admin/vue/vacancy">
                    <b-menu-item icon="user" label="Vacancies" disabled></b-menu-item>
                </router-link>
                <router-link to="admin/vue/application">
                    <b-menu-item icon="users" label="Applications" disabled></b-menu-item>
                </router-link>
                <router-link to="admin/vue/employees">
                    <b-menu-item icon="users" label="Employees" disabled></b-menu-item>
                </router-link>
                <router-link to="admin/vue/salaries">
                    <b-menu-item icon="users" label="Salaries" disabled></b-menu-item>
                </router-link>
                <router-link to="admin/vue/salariesDetails">
                    <b-menu-item icon="users" label="Salaries Details" disabled></b-menu-item>
                </router-link>
                <router-link to="admin/vue/ruleOfProcedure">
                    <b-menu-item icon="users" label="Rules Of Procedure" disabled></b-menu-item>
                </router-link>
            </b-menu-item>
        </b-menu-list>
        <router-link to="admin/vue/reports">
            <b-menu-item v-if="permArray.reports == 1 || userType == 'admin'" icon="information-outline" label="Reports"></b-menu-item>
        </router-link>
        </div>
        <div class="wui-content">
        <div class="wui-content-header">
            <a href="#" class="wui-side-menu-trigger"><i class="fa fa-bars"></i></a>
        </div> 
        </div>
        <div class="wui-overlay"></div>
    </div>
</template>

<style>
@media only screen and (max-width: 600px){
    .sidebar-menu-responsev{
        display: block !important
    }
    .web_menu{
        display: none
    }
}
.sidebar-menu-responsev{
    display: none;
}
/* side menu */
.wui-side-menu {
  position:fixed;
  top:0;
  left:0;
  width:220px;
  height:100%;
  backface-visibility:hidden;
  z-index:3;
  -webkit-transform: translateX(-100%);
  transform: translateX(-100%);  
  -webkit-transition: webkit-transform 220ms ease-in-out;
  transition: transform 220ms ease-in-out;
  background-color:#FFF;
  color: #000
}
.wui-side-menu.open {-webkit-transform: translateX(0);transform: translateX(0);} 
.wui-side-menu.open ~ .content .side-menu-trigger {display:none;}
.wui-side-menu.open {box-shadow: 2px 0 16px 0 rgba(0,0,0,0.3);}
.wui-side-menu .header, 
.wui-content-header {width:10%;vertical-align:baseline;line-height:50px;}
.wui-side-menu-pin-trigger, 
.wui-side-menu-trigger {width:50px;height:50px;text-align:center;display: inline-block;font-size:18px;line-height: 50px;margin-left:6rem !important;margin-top:1.5vw !important}

.wui-side-menu .wui-side-menu-pin-trigger    {display:none;float: right;}
.wui-side-menu .wui-side-menu-pin-trigger i  {-webkit-transition:all 0.22s ease-out;-moz-transition:all 0.22s ease-out;
                                                      -o-transition:all 0.22s ease-out;     transition:all 0.22s ease-out;}
.wui-side-menu .wui-side-menu-items {overflow-y:auto;height: calc(100% - 50px);}
.wui-side-menu .wui-side-menu-item {
   display:block;
   width:100%;
   padding:15px 12px ;
   border-left:5px solid transparent;
}
.wui-side-menu .wui-side-menu-item {height:50px}
.wui-side-menu .wui-side-menu-item i.box-ico {margin-right:4px;}

/* overlay */
.wui-overlay {position:absolute;top:0;left:0;right:0;bottom:0;z-index:2;background-color: rgba(0, 0, 0, 0.1);opacity:0.5;display:none;}
.wui-side-menu.open ~ .wui-overlay, .wui-overlay.active {display:block;} 

/* content */
.wui-content {width:10%;z-index:1;position:absolute;top:0;right:0;bottom:0;left:0;
             -webkit-transition:all 0.22s ease-out;-moz-transition:all 0.22s ease-out;
             -o-transition:all 0.22s ease-out;transition:all 0.22s ease-out;padding:0 10px;}
.wui-content .wui-side-menu-trigger {margin-left:-10px;}
@media only screen and (min-width:768px){
    .wui-side-menu .wui-side-menu-pin-trigger {display:inline-block;} 
    .wui-side-menu.open {box-shadow: initial;}
    .wui-side-menu.open ~ .wui-overlay {display:none;} 
    .wui-side-menu.open ~ .wui-content .wui-side-menu-trigger {display:none;} 
    .wui-side-menu.open:not(.pinned) ~ .wui-overlay {display:block;}
    .wui-side-menu.open:not(.pinned) {box-shadow: 2px 0 16px 0 rgba(0,0,0,0.3);}
    .wui-side-menu.open.pinned ~ .wui-content {left:220px;}
}
ul.wui-side-menu-items {list-style: none;padding:0}

.wui-side-menu {background-color: #292e34;color:#ddd;}
.wui-side-menu .wui-side-menu-trigger:hover,
.wui-side-menu-item:hover,
.wui-side-menu-pin-trigger:hover
    {color: #fff;background-color: #383f45;}

.wui-side-menu a 
 {color:#000000;text-decoration:none}
.wui-side-menu .wui-side-menu-item.active
    {border-left-color: #158439; color:#158439}
.wui-content a {color:#000;}


/* demo */
body {margin:0; font-family:'arial';font-weight:100;}
*, *:after, *:before {-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}
#events {background-color:#ccc;}

</style>


<script>
  import {
    checkUserGroupAndRoles,
  } from "./../../calls";
export default {
    data() {
      return {
        userHr: window.auth_user.userHr,
        userType: window.auth_user.type,
        permArray: [],
      }
    },
    mounted() {
(function (window, undefined) {
    'use strict';
    // responsive pinnable sidemenu component
    var sideMenu = function (el) {
        var htmlSideMenu = el, htmlSideMenuPinTrigger = {}, htmlSideMenuPinTriggerImage = {}, htmlOverlay = {};
        var init = function () {
            htmlSideMenuPinTrigger = el.querySelector('.wui-side-menu-pin-trigger');
            htmlSideMenuPinTriggerImage = htmlSideMenuPinTrigger.querySelector('i.fa');
            htmlOverlay = document.querySelector('.wui-overlay');
            Array.prototype.forEach.call(document.querySelectorAll('.wui-side-menu-trigger'), function (elmt, i) {
                elmt.addEventListener('click', function (e) {
                    e.preventDefault();
                    toggleMenuState();
                }, false);
            });
            htmlSideMenuPinTrigger.addEventListener('click', function (e) {
                e.preventDefault();
                toggleMenuPinState();
            }, false);
            htmlOverlay.addEventListener("click", function (e) {
                htmlSideMenu.classList.remove('open');
            }, false);
            window.addEventListener("resize", checkIfNeedToCloseMenu, false);
            checkIfNeedToCloseMenu();
        };
        var toggleMenuState = function () {
            htmlSideMenu.classList.toggle('open');
            menuStateChanged(htmlSideMenu, htmlSideMenu.classList.contains('open'));
        };
        var toggleMenuPinState = function () {
            htmlSideMenu.classList.toggle('pinned');
            htmlSideMenuPinTriggerImage.classList.toggle('fa-rotate-90');
            if (htmlSideMenu.classList.contains('pinned') !== true) {
                htmlSideMenu.classList.remove('open');
            }
            menuPinStateChanged(htmlSideMenu, htmlSideMenu.classList.contains('pinned'));
        };
        var checkIfNeedToCloseMenu = function () {
            var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            if (width <= 767 && htmlSideMenu.classList.contains('open') === true) {
                htmlSideMenu.classList.remove('open');
                menuStateChanged(htmlSideMenu, htmlSideMenu.classList.contains('open'));
            }
            if (width > 767 && htmlSideMenu.classList.contains('pinned') === false) {
                htmlSideMenu.classList.remove('open');
                menuStateChanged(htmlSideMenu, htmlSideMenu.classList.contains('open'));
            }
        };
        var menuStateChanged = function (element, state) {
            var evt = new CustomEvent('menuStateChanged', { detail: { open: state} });
            element.dispatchEvent(evt);
        };
        var menuPinStateChanged = function (element, state) {
            var evt = new CustomEvent('menuPinStateChanged', { detail: { pinned: state} });
            element.dispatchEvent(evt);
        };
        init();
        return {
            htmlElement: htmlSideMenu,
            toggleMenuState: toggleMenuState,
            toggleMenuPinState: toggleMenuPinState
        };
    };
    
    window.SideMenu = sideMenu;
})(window);


var documentReady = function (fn) {
  if (document.readyState != 'loading') {
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
};

documentReady(function() {
  var sample = new SideMenu(document.querySelector('.wui-side-menu'))
  sample.htmlElement.addEventListener('menuPinStateChanged', function(e) {
    document.querySelector('#events').innerHTML += 'menuPinStateChanged , menu pinned? => ' 
      + e.detail.pinned + '<br>'; 
  }, false);
});
    },
    methods:{
      checkUserHasGroup() {
        checkUserGroupAndRoles()
          .then(response => {
            this.permArray = response.data.permArray;
          })
          .catch(error => {
            console.log(error);
          });
      },
    }
}
</script>
