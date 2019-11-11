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
  <div class="dashboard_calender">
     <v-calendar style="width:100%;height:100%" :attributes='attrs'></v-calendar>
  
  </div>
 
 
</div>
</template>
<style >
.vc-header[data-v-d137fa42]
{
  background-color: #7f7286;
}
.vc-title[data-v-d137fa42]
{
  color: white;
padding: 2px;
}
.dashboard_calender
{
  width: 21%;
    height: 300px;
    /* margin: 2% 1% 0% 0%; */
    display: inline-block;
    border: 1px solid #ccc;
    position: absolute;
    right: 2%;
    top: 2.5%;
}
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
@media (max-width:414px)
{
  .headerr span 
{
  margin: 5%;
  
}
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
   margin: 2% 2% 1%;
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
 @media screen and (max-width:414px)
 {
 .deals 
 {
   width: 81%;
    height: 259px;
    margin-left: 9%;
 }
 .dashboard_calender {
    width: 83%;
    height: 300px;
    margin-left: 31px;
    position: unset;
 }
 .activity
{
   width: 82%;
   height: 300px;
   background-color: white;
   position: unset;
    margin-left: 32px;
}
 }
</style>
<script>
import Vue from 'vue'
import VCalendar from 'v-calendar';
Vue.use(VCalendar, {
  firstDayOfWeek: 2,  
              
});
import { setupCalendar, Calendar} from 'v-calendar'
// import 'v-calendar/lib/v-calendar.min.css';
Vue.component('v-calendar', Calendar);
import FunctionalCalendar from 'vue-functional-calendar';
Vue.use(FunctionalCalendar, {
    dayNames: ['Moa', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su']
});
    export default {
        data() {
            return {
              selectedValue: new Date(),
                activeTab: 0,
                showBooks: false,
                 date: '2019-01-01',
                  attrs: [
                           {
                              key: 'today',
                              highlight: {
                                backgroundColor: 'red',
                              },
                              dates: new Date(2018, 0, 1)
                            }
                          ],

            }
        },
        components: {
        FunctionalCalendar,
        
    },
       
    }
    
</script>