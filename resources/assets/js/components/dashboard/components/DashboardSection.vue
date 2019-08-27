<template>
  <div class="row">
    <div class="sections">
      <label style="display: inline-block; max-width: 100%; margin-bottom: 25px; font-weight: 700;">
        <div>
          <img
            src="/icon/dashboard.png"
            style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
          >
          <h2 style="float: right; margin-top: 8%; font-size: 25px; font-weight: bold;">DASHBOARD</h2>
        </div>
      </label>

      <div class="columns is-12 is-multiline is-mobile" style="margin-left: 0%;">
        <div
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Sales this Day</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #FBC525">{{ dashboardSectionStats.todaySales }}</h3>
          </div>
          <div>
            <p class="div-footer">EGP</p>
          </div>
        </div>

         <div
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Sales this Month</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #69BBBC">{{ dashboardSectionStats.monthSales }}</h3>
          </div>
          <div>
            <p class="div-footer">EGP</p>
          </div>
        </div>

        <div
          v-if="authUserType == 'admin'"
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Customer this Day</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #317492">{{ dashboardSectionStats.agentTodayLeads }}</h3>
          </div>
          <div>
            <p class="div-footer">Customers</p>
          </div>
        </div>

        <div
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Number Of Customer</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #E12F4F">{{ dashboardSectionStats.agentLeads }}</h3>
          </div>
          <div>
            <p class="div-footer">Customers</p>
          </div>
        </div>

        <div
          v-if="authUserType == 'admin'"
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Inventory Value</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #454545">{{ inventory }}</h3>
          </div>
          <div>
            <p class="div-footer">EGP</p>
          </div>
        </div>

        <div
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Today Leads</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #454545">{{ dashboardSectionStats.todayLeads }}</h3>
          </div>
          <div>
            <p class="div-footer">Today Leads</p>
          </div>
        </div>

        <div
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Seen.</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #454545">{{ dashboardSectionStats.seen }}</h3>
          </div>
          <div>
            <p class="div-footer">Seen</p>
          </div>
        </div>

        <div
          class="column is-six-quarters-mobile is-4"
          style="margin-left: 20px; margin-bottom: 1%"
        >
          <div>
            <p class="div-title">Not Seen</p>
          </div>
          <div>
            <h3 class="div-value" style="color: #454545">{{ dashboardSectionStats.notSeen }}</h3>
          </div>
          <div>
            <p class="div-footer">Not Seen</p>
          </div>
        </div>

      </div>


    </div>
  </div>
</template>

<script>
export default {
  props: ["dashboardSectionStats"],
    data() {
      return {
        authUserType: window.auth_user.type
        // inventory: "0"
      };
  },

  computed: {
    inventory() {
      const trillion = 1e12;
      const billion = 1e9;
      const million = 1e6;
      const thousand = 1e3;

      const amountOfMoney = this.dashboardSectionStats.inventory;
      if (amountOfMoney > trillion) {
        return "+" + (amountOfMoney / trillion).toFixed(1) + "T";
      }

      if (amountOfMoney > billion) {
        return "+" + (amountOfMoney / billion).toFixed(1) + "B";
      }

      if (amountOfMoney > million) {
        return "+" + (amountOfMoney / million).toFixed(1) + "M";
      }

      if (amountOfMoney > thousand) {
        return "+" + (amountOfMoney / thousand).toFixed(1) + "K";
      }

      return amountOfMoney;
    }
  },

  methods: {
  },

  mounted(){
    // console.log('dashborad test', this.$props)
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
</style>
