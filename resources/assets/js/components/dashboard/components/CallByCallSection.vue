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
                >CALLS BY CALL STATUS</h2>
                </div>
            </label>
            </div>
            <div class="column">
            <b-dropdown hoverable style="margin-top: -7%;">
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
                <b-checkbox v-model="teamIDCallByCall" :native-value="team.id">{{team.name}}</b-checkbox>
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
                    <b-checkbox v-model="agentIDCallByCall" :native-value="agent.id">{{agent.name}}</b-checkbox>
                  </b-dropdown-item>
                </div>
              </b-dropdown>
            </div>
        </div>
        <div class="columns is-multiline is-mobile">
            <div class="column is-one-quarter" v-for="item in stat" :key="item.id">
            <apexchart
                type="radialBar"
                height="175"
                :options="{plotOptions: plotOptions , labels: [item.name]}"
                :series="[item.percent]"
            />
            </div>
        </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
export default {
  props: ["stat", "plotOptions", "teams", "agents"],
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
        agentIDCallByCall: [],
        teamIDCallByCall: [],
    };
  },
};
</script>
<style scoped>
.sections,
.right-side {
  background: #f2e8da;
  margin-bottom: 5%;
  padding-bottom: 3%;
  height: fit-content;
}

.sections h2 {
  font-size: 30px;
  margin-bottom: 3%;
}

.sections h2 img {
  width: 50px !important;
  margin-right: 15px;
  margin-left: 15px;
  margin-top: 15px;
}

.sections .div-title {
  background: #efefef;
  padding: 5px 10px 5px 10px;
  margin: 0;
  text-align: center;
}

.sections .div-value {
  font-size: 46px;
  font-weight: 600;
  margin: 0;
  background-color: white;
  text-align: center;
}

.sections .div-footer {
  background-color: white;
  text-align: center;
}


#scroll::-webkit-scrollbar {
  width: 5px;
}

#scroll::-webkit-scrollbar-track {
  background: #9e6800;
}

#scroll::-webkit-scrollbar-thumb {
  background: #333333;
}

#scroll::-webkit-scrollbar-thumb:hover {
  background: black;
}

@media screen and (max-width: 560px) {
  .is-one-quarter{
    margin-left: 3%;
  }
}

</style>
