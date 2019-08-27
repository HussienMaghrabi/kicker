<template lang="html">
    <div>
         <div class="container is-fluid">
           <div class="card">
          <header class="card-header cardHeader">
            <p class="card-header-title">Follow Up</p>
          </header>
          <div class="card-content">
           <yourCalendarSection/>
          </div>
        </div>
             
         </div>
    </div>
</template>

<script>

import yourCalendarSection from "./yourCalendarSection";

export default {
  name: "HeaderFollowUp",

  data() {
    return {
      
    };
  },

  components: {
    yourCalendarSection
   
  },

  mounted() {
  },

  computed: {
  },

  methods: {
  }
};
</script>

<style lang="css" scoped>
</style>
