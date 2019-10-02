<template>
<div>
  <div class="deals">
    <b-tabs v-model="activeTab">
            <b-tab-item label="Deals this month |">
                <div style="color:green" class="month-deals">2</div>
                <div style="color:red" class="month-deals">0</div>
                <div style="color:blue" class="month-deals">10%</div>
                <div class="month-rate"><p>Won Deals</p></div>
                <div class="month-rate"><p>Lost Deals</p></div>
                <div class="month-rate"><p>Rate</p></div>
            </b-tab-item>

            <b-tab-item label="Deals this year">
               <div style="color:green" class="year-deals">3</div>
               <div style="color:red" class="year-deals">0</div>
               <div style="color:blue" class="year-deals">200%</div>
              <div class="month-rate"><p>Won Deals</p></div>
                <div class="month-rate"><p>Lost Deals</p></div>
                <div class="month-rate"><p>Rate</p></div>
            </b-tab-item>
     </b-tabs>
  </div>
  <div class="activity">
    <div class="headerr">
      <span>Open Activity </span>
      <span>Date</span>
      <span>Company</span>

    </div>
      
  </div>
  <!-- <date-pick v-model="date"></date-pick> -->
  <!-- <functional-calendar v-model="calendarData" :configs="calendarConfigs"></functional-calendar> -->
  <!-- <datetime  v-model="date"></datetime> -->
 
</div>
</template>
<style >
.headerr
{
  background-color: #ECECEC;
    height: 40px;
    font-size: 16;
    width: 100%;
    cursor: pointer;
}
.headerr span 
{
  margin: 7%;
  
}
.activity
{
   width: 30%;
   height: 300px;
   background-color: white;
   margin: 2% 1% 0% 0%;
   display: inline-block;
   position: absolute;
   border: 1px solid #ccc;
}
 .deals
 {
   width: 42%;
   height: 300px;
   background-color: white;
   margin: 2%;
   display: inline-block;
   border: 1px solid #ccc;

 }
 .month-deals
 {
   width: 30%;
   display: inline-block;
   margin:1%;
   font-size: 23px;


 }
 .year-deals
 {
     
   width: 30%;
   display: inline-block;
   margin: 1%;
   font-size: 23px;


 }
 .b-tabs .tab-content .tab-item
 {
   padding-left: 10%;
    padding-top: 6%;
 }
 .b-tabs .tabs
 {
  background-color: #ECECEC;
    
 }
 .month-rate
 {
   width: 30%;
   display: inline-block;
   margin:1%;
   padding-top: 14%;
 }
</style>
<script>
import Vue from 'vue'
import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css' 
import DatePick from 'vue-date-pick';
import 'vue-date-pick/dist/vueDatePick.css';
Vue.component('datetime', Datetime);
 Vue.use(Datetime)
//  Vue.use()
// Introduced in vue file
import FunctionalCalendar from 'vue-functional-calendar';
Vue.use(FunctionalCalendar, {
    dayNames: ['Moa', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su']
});
    export default {
        data() {
            return {
                activeTab: 0,
                showBooks: false,
                 date: '2019-01-01'

            }
        },
        components: {
        FunctionalCalendar,
        DatePick
    },
       
    }
    Vue.extend({
  
  components: {
    datetime: Datetime
  }
});
</script>