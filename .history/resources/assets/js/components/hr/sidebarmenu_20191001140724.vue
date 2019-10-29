<template>
<div>
        <div id="mySidebar" class="sidebar"> 
            <a href="javascript:void(0)" class="closebtn" @click="closeNav">×</a>
            <router-link :to="'/admin/vue/jobCategories'"><i class="fas fa-briefcase"></i>    Job Category</router-link>
            <router-link :to="'/admin/vue/jobTitle'"><i class="fas fa-briefcase"></i>    Job Title</router-link>
            <router-link :to="'/admin/vue/vacancy'"><i class="fas fa-cogs"></i>    Vacancies</router-link>
            <router-link :to="'/admin/vue/application'"><i class="fas fa-id-badge"></i>     Applications</router-link>
            <router-link :to="'/admin/vue/employees'"><i class="fas fa-users"></i>    Employees</router-link>
            <router-link :to="'/admin/vue/assignRating'"><i class="far fa-gem"></i>    Assign Rate</router-link>
            <router-link :to="'#'"><i class="fas fa-briefcase"></i>    Custodies</router-link>
            <router-link :to="'/admin/vue/HrSettings'"><i class="fas fa-cogs"></i>    Settings</router-link>
            <router-link :to="'/admin/vue/request_type'"><i class="fas fa-cogs"></i>     Requests Type</router-link>
            <router-link :to="'/admin/vue/request_status'"><i class="fas fa-cogs"></i>     Requests Status</router-link>
            <router-link :to="'/admin/vue/employee_request'"><i class="fas fa-cogs"></i>      Requests</router-link>
            <router-link :to="'/admin/vue/attendance'"><i class="fas fa-users"></i>     Attendances</router-link>
            <router-link :to="'/admin/vue/salaries'"><i class="fas fa-money-check-alt"></i>    Salaries</router-link>
            <router-link :to="'/admin/vue/salariesDetails'"><i class="fas fa-money-check-alt"></i>    Salaries details</router-link>
            <router-link :to="'/admin/vue/ruleOfProcedure'"><i class="fab fa-critical-role"></i>  RuleOfProcedure</router-link>

        </div>

        <div id="main">
           <button class="openbtn" @click="openNav">☰ HR</button>  
        </div>
</div>

</template>
<script>
export default {
    methods:{
     openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
     }, 
     closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
     }
 }
}
</script>

<style>
 .sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #FFF;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidebar a {
  padding: 28px 8px 8px 32px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.sidebar .closebtn {
  position: absolute;
  top: 3;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
  margin-right: -30px;
}

.openbtn {
  font-size: 30px;
  cursor: pointer;
  color: #000;
  padding: 10px 15px;
  border: none;
  background-color: #fff;
}
#main {
  transition: margin-left .5s;
  padding: 16px;
}
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
