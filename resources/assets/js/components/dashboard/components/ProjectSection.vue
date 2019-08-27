<template>
  <div class="row">
    <div class="sections">
      <label
        style="display: inline-block; max-width: 100%; margin-bottom: 25px; font-weight: 700;"
      >
        <div>
          <img
            src="/icon/project.png"
            style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
          >
          <h2
            style="float: right; margin-top: 8%; font-size: 25px; font-weight: bold;"
          >PROJECT</h2>
        </div>
      </label>
      <div class="columns">
        <div class="column is-1"></div>
        <div class="column is-3 table">
          <b-table
            :data="tabledata"
            :columns="tablecolumns"
            style="width: fit-content;margin-right: auto; margin-left: auto;"
          ></b-table>
        </div>
        <div class="column is-8">
          <apexcharts
            width="500"
            height="300"
            type="bar"
            :options="tchartOptions"
            :series="tseries"
            style="overflow: auto"
          ></apexcharts>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
export default {
  props: ["tabledata", "tablecolumns", "tchartOptions", "tseries"],
  components: {
    apexcharts: VueApexCharts,
  },
  data() {
    return {};
  }
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

@media screen and (max-width: 1087px) {
  .table{
    display: none !important;
  }
}
</style>
