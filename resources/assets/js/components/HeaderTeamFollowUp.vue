<template lang="html">
    <div>
         <div class="container is-fluid">
           <div class="card">
          <header class="card-header cardHeader">
            <p class="card-header-title">Team Follow Up</p>
          </header>
          <div class="card-content">
           <teamCalendarSection/>
          </div>
        </div>
             
         </div>
    </div>
</template>

<script>

import teamCalendarSection from "./teamCalendarSection";

export default {
  name: "HeaderTeamFollowUp",

  data() {
    return {
    };
  },

  components: {
    teamCalendarSection
  },

  mounted() {
  },

  computed: {
  },

  methods: {

  }
};
</script>

