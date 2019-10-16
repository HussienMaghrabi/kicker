<template>
<div> 
    <section class="container style">
     
      <b-field label="Lead">
            <select class="form-control lead" v-on:change="LeadInfo($event.target.value)" v-model="lead_id" >
                <option v-for="lead in leads" :key="lead.id" :value="lead.id">{{ lead.first_name +' '+lead.last_name}}</option>
            </select>    
      </b-field>


      <b-field :active.sync="labelContact" label="Contact">
                <b-select v-model="contact_id" expanded>
                    <option v-for="contact in lead_contact" :key="contact.id" :value="contact.id">{{ contact.name }}</option>
                </b-select>
      </b-field>


      <b-field label="Meeting Status">
            <b-select class="form-control lead" v-model="meeting_status_id" expanded v-on:change="nextAction">
                <option v-for="meeting_status in meeting_statuses" :key="meeting_status.id" :value="meeting_status.id">
                    {{ meeting_status.name }}
                </option>
            </b-select>  
      </b-field>

  <!-- next action -->

      <b-field :active.sync="action" label="To-Do-Type">
                <b-select v-model="to_do_type" expanded>
                    <option value="call">Call</option>
                    <option value="meeting">Meeting</option>
                    <option value="other">Other</option>
                </b-select>    
      </b-field>

    <b-field label="Due Date"  :active.sync="action">
        <b-datepicker 
            icon="calendar-today">
        </b-datepicker>
    </b-field>

    <b-field  :active.sync="action" label="Description">
            <b-input  type="textarea" required></b-input>
    </b-field>

<b-field label="Projects">
     <div class="is-fullwidth">
        <multiselect :close-on-select="false" v-model="select_projects" tag-placeholder="Add this as new project" placeholder=" Select Projects" label="en_name" track-by="id" value="id" :options="projects" :multiple="true" :taggable="true" style="z-index:100000000" ></multiselect>
     </div>
    </b-field>
<!-- end next action -->
 
      <b-field label="Duraiton">
            <b-input type="number" v-model="duration" required></b-input>
      </b-field>

       <b-field label="Date">
        <b-datepicker
            v-model="date"
            icon="calendar-today">
        </b-datepicker>
    </b-field>

     <b-field label="Time">
        <b-timepicker v-model="time"></b-timepicker>
    </b-field>

      
    <b-field label="Location On Map">
        <b-select v-model="location" expanded>
            <option v-for="locationn in locations" :key="locationn.id" :value="locationn.id">
                {{ locationn.name }}
            </option>
        </b-select>  
    </b-field> 

    <b-field label=" Probability">
        <b-select expanded v-model="probability">
            <option value="followup">Follow Up</option>
            <option value="ongoing">On going</option>
            <option value="expected_closing">Expected Closing</option>
            <option value="closed">Closed</option>
            <option value="routation">Routation</option>
        </b-select>    
    </b-field>

    <!-- <b-field label=" Projects">
        <b-select v-model="project" expanded>
            <option v-for="project in projects" :key="project.id" :value="project.id">
                {{ project.en_name }}
            </option>
        </b-select>    
    </b-field> -->
    
    

    <b-field label="Description">
        <b-input type="textarea" v-model="description" required></b-input>
    </b-field>
        
        
         <button class="button is-primary" @click="AddMeeting">submit</button>
   </section>
           <!-- <div class="container " style="text-align:center"> 
                <button class="button actionn btnNextAction" v-on:click="action = !action">Next Aciton</button> 
           </div>

 <div class="container remove" style="text-align:center"> 
     <button class="button is-primary" >Remove Next Action</button> 
</div> -->
   <!-- <section class="NextAction container">
     
           

   </section> -->
</div>

</template>

<script>
// $(document).ready(function(){
//         $('.NextAction').hide();

//         $('.btnNextAction').on('click', function(){
//             $('.NextAction').toggle();
//         });
// });
 </script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {AddMeeting,getMeetingsInputs,getcontactLead,getAllLocations, replaceDuplicateLead} from './../../calls'
import Multiselect from 'vue-multiselect'

export default {
    data() {
            return {
                action:false,
                leads:[],
                meeting_statuses:[],
                projects:[],
                meetingStatus:null,
                project:null,
                lead_id:'',
                contact_id:'',
                date:null,
                time:null,
                location:null,
                probability:null,
                description:null,
                duration:null,
                meeting_status_id:null,
                to_do_type:null,
                token: window.auth_user.csrf,
                labelContact:false,
                lead_contact:[],
                locations:[],
                select_projects:[],
                // lead_contact_id:'',
            }},
    mounted() {
        this.getData()
        this.getLocations()
    },
    components: {
        Multiselect
    },
    created() {
      this.$router.replace({hash: '#/1'});
    },
 methods: {
    LeadInfo(value){
        var lead_id = value
        getcontactLead(lead_id).then(response=>{
            console.log(' lead response',response)
            this.lead_contact = response.data
            console.log(this.contacts)
        }).catch(error=>{contact
            console.log(error)
        })
        // console.log(value)
        this.labelContact = true
    },
    nextAction(){
        this.action = true
    },
    // Toggle(action)
    // {
    //     this.action=!this.action ;
    // },
    getData(){
        this.isLoading = true
        getMeetingsInputs().then(response=>{
            console.log("meetings",response)
            this.leads = response.data.leads
            this.meeting_statuses = response.data.meeting_statuses
            console.log("meeting status",this.meeting_statuses)
            this.projects = response.data.projects
        })
        .catch(error => {
            console.log(error)
        })
        this.isLoading = false
    },
    getLocations(){
        this.isLoading = true
        getAllLocations().then(response=>{
            this.locations = response.data
          console.log('locations',response)
        }).catch(error=>{
            console.log(error)
        })
    },
    AddMeeting(){
        var data ={
            '_token':this.token,
            'lead_id':this.lead_id,
            'contact_id':this.contact_id,
            'date':this.date,
            'time':this.time,
            'location':this.location,
            'probability':this.probability,
            'description':this.description,
            'duration':this.duration,
            'meeting_status_id':this.meeting_status_id,
            'to_do_type':this.to_do_type
        };
        AddMeeting(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/AllMeeting')
        })
        .catch(error => {
                this.errorDialog()
        })
    },
    errorDialog() {
        this.$dialog.alert({
            title: 'Error',
            message: 'Please Fill required inputs',
            type: 'is-danger',
        })
    },
    success(action) {
        this.$toast.open({
            message: 'Meeting '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>

<style>
  
   .NextAction
   {
       display: none;
   }
   .remove
   {
       background-color: red;
       display: none;
   }
   .actionn{
       background-color: #00a65a;
       color: white;
   }
   .lead{
    width: 100%;
    height: 35px;
    background-color: #fff;
    border: 1px solid seagreen;
    border-radius: 6px;
   }

.style
{
    background-color: white;
    padding: 20px;
} 
</style>

