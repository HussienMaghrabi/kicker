<template>
  <div class="row">
        <div class="sections">
      <div class="columns">
        <div class="column">
          <label
            style="display: inline-block; max-width: 100%; margin-bottom: 25px; font-weight: 700;"
          >
            <div>
              <img
                src="/icon/call.png"
                style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
              >
              <h2
                style="float: right; margin-top: 8%; font-size: 25px; font-weight: bold;"
              >TEAM ACHIEVEMENTS</h2>
            </div>
          </label>
        </div>
        <div class="column">
          <b-dropdown hoverable style="margin-top: -7%;">
            <button
              v-if="userType == 'admin'"
              class="button is-info"
              slot="trigger"
              style="background-color: unset; color: black; margin-top: 45%;"
            >
              <span>Teams</span>
              <b-icon icon="menu-down"></b-icon>
            </button>
            <div id="scroll" style="overflow-y: auto; height: 350px">
              <b-dropdown-item v-for="team in teams" :key="team.id">
                <b-checkbox v-model="teamIds" :native-value="team.id">{{team.name}}</b-checkbox>
              </b-dropdown-item>
            </div>
          </b-dropdown>
        </div>
      </div>
      <div class="rows">
        <div class="row">
          <carousel :per-page="3" :navigationEnabled="true" :paginationEnabled="false" :autoplay="false">
          <slide style="padding-top: 1%;" v-for="team in teamAchievement" :key="team.id">
            <div class="columns is-multiline" style="padding: 2%">
              <div class="column is-4">
                <img class="profile-img" :src="profileImg(team)">
                <span class="profile-name">{{ team.name }}</span>
              </div>
              <div class="column is-8 img-content">
                <img
                  class="content-img"
                  src="../../../../../../public/icon/DASHBOARD-achievement.png"
                >
                <p class="content-span total-calls-val">{{ team.totalCalls }}</p>
                <p class="content-span total-calls-txt">Total Calls</p>
                <p class="content-span total-meeting-val">{{ team.totalMeetings }}</p>
                <p class="content-span total-meeting-txt">Total Meeting</p>
                <p class="content-span converted-lead-val">{{ team.convertedLeads }}</p>
                <p class="content-span converted-lead-txt">Converted Leads</p>
                <p class="content-span total-leads-val">{{ team.totalLeads }}</p>
                <p class="content-span total-leads-txt">Total Leads</p>
              </div>
            </div>
          </slide>
        </carousel>
        </div>
      </div>
    </div>
  </div>
</template>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<script>
import { Carousel, Slide } from 'vue-carousel';
import { teamAchievements } from './../../../calls';

export default {
  props: ["teams", "teamAchievement"],
  components: {
    Carousel,
    Slide
  },
  mounted() {
  },
  data() {
    return {
      teamIds: [],
      userType: window.auth_user.type,
    };
  },
  watch: {
    'teamIds': function(){
      this.teamAchievements();
    },
  },
  methods: {
    profileImg(team){
      if(team.image === "")
      return "/icon/profile.png";
      else
      return team.image;
    },
    teamAchievements() {
      var data = {
        teamIds: this.teamIds,
      };
      if(data['teamIds'].length > 0){
        teamAchievements(data)
        .then(response => {
          this.teamAchievement = response.data
          // console.log("team achievements ", this.teamAchievement)
        })
        .catch(error => {
          console.log(error);
        });
      }
    }
  }
};
</script>
<style>
.VueCarousel-navigation-button{
  color: #333 !important;
  font-size: 1.5rem !important;
}

@media screen and (max-width: 767px) {
  .VueCarousel-navigation-button {
    top: -10% !important;
  }
  .VueCarousel-navigation-prev{
    left: 90% !important;
  }

  .VueCarousel-navigation-next{
    right: 9% !important;
  }
}
</style>
<style scoped>
.sections {
  background: #f2e8da;
  margin-bottom: 5%;
  padding-bottom: 3%;
  height: fit-content;
}

.sections h2 {
  font-size: 30px;
  margin-bottom: 3%;
  margin-top: 4% !important;
}

.sections h2 img {
  width: 50px !important;
  margin-right: 15px;
  margin-left: 15px;
  margin-top: 15px;
}

.profile-img {
  width: 50%;
  display: table;
  margin-right: auto;
  margin-left: auto;
}

.content-img {
  /* width: 70%;
  height: 95%; */
}

.profile-name {
  display: table;
  margin-right: auto;
  margin-left: auto;
  font-weight: bold;
  text-align: center;
}

.content-span {
  position: relative;
  color: black;
  font-size: 11px;
}

.total-calls-val{
  top: -53%; 
  left: 48%;
}

.total-calls-txt{
  top: -55%; 
  left: 48%;
}

.total-meeting-val{
  top: -49%; 
  left: 3%;
}

.total-meeting-txt{
  top: -51%; 
  left: 3%;
}

.converted-lead-val{
  top: -47%; 
  left: 49%;
}

.converted-lead-txt{
  top: -49%; 
  left: 48%;
}

.total-leads-val{
  top: -46%; 
  left: 3%;
}

.total-leads-txt{
  top: -48%; 
  left: 3%;
}

@media screen and (max-width: 767px) {
  .total-calls-val{
    top: 6%; 
  }

  .total-calls-txt{
    top: 13%; 
  }

  .total-meeting-val{
    top: 33%;
    left: 5%; 
  }

  .total-meeting-txt{
    top: 40%;
    left: 5%; 
  }

  .converted-lead-val{
    top: 56%; 
  }

  .converted-lead-txt{
    top: 63%; 
  }

  .total-leads-val{
    top: 78%; 
  }

  .total-leads-txt{
    top: 85%; 
  }

  .content-span {
    position: absolute;
  }

  .img-content{
    position: relative;
  }
}
</style>