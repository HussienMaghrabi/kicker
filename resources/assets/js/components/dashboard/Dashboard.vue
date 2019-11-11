<template>
  <div>
     <button style="margin-left:9%" class="button is-primary is-medium">  
            <router-link style="color:white" to="/admin/vue/dashboard_hr"> Dashboard HR  </router-link>
      </button>
      <button style="margin-left:9%" class="button is-primary is-medium">  
            <router-link style="color:white" to="/admin/vue/dashboard_pmanager"> Dashboard Project Manger  </router-link>
      </button>


    <div class="dashboard container">
      <div class="columns">
        <div class="column left-side-dash-col" style="width: 65%;">
          

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
      
      </div>
    </div>
  </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="./dashboard.css" scoped></style>
<style>
.dashboard
{
  overflow: hidden;
}
</style>

<script>
$(window).load(function() {
  // Animate loader off screen
  document.getElementById("loadd").style.display = "none";
  
});

import teamCalendarSection from "../teamCalendarSection";
import yourCalendarSection from "../yourCalendarSection";

import DashboardSection from "./components/DashboardSection";
import LeadsSection from "./components/LeadsSection";
import ProjectSection from "./components/ProjectSection";
import CallByCallSection from "./components/CallByCallSection";
import AchievementsSection from "./components/AchievementsSection";
import TeamAchievementsSection from "./components/TeamAchievementsSection";
import FollowUp from "./components/FollowUp";
import Assistant from "./components/Assistant";
import VueApexCharts from "vue-apexcharts";
import "fullcalendar/dist/fullcalendar.css";
import { FullCalendar } from "vue-full-calendar";
import Vue from 'vue';
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
Vue.use(VueSidebarMenu)
export default {
  name: "dashboard",
  data() {
    return {
      dashboardSectionsComponents: [
        { id: 1, order: 1, name: "DashboardSection" },
        { id: 2, order: 2, name: "LeadsSection" },
        { id: 3, order: 3, name: "ProjectSection" },
        { id: 4, order: 4, name: "CallByCallSection" },
        { id: 5, order: 5, name: "AchievementsSection" },
        { id: 6, order: 6, name: "TeamAchievementsSection" }
      ],
     
    };
  },
  components: {
    FollowUp,
   
    FullCalendar,
    DashboardSection,
    LeadsSection,
    ProjectSection,
    CallByCallSection,
    AchievementsSection,
    TeamAchievementsSection,
    Assistant,
    
  },
  computed: {
    format() {
      return this.formatAmPm ? "12" : "24";
    }
  },
 
  beforeCreate: function(){
    this.isLoading = true
  },

  updated(){
    document.getElementById("loadd").style.display = "none";
  }
};

</script>
 