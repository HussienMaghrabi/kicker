<template>
    <section class="container style">
       
        <b-field label=" English Name">
            <b-input v-model="en_name"></b-input>
        </b-field>
        <b-field label="Arabic Name">
            <b-input v-model="ar_name"></b-input>
        </b-field>
        <b-field label="Campaign Type">
            <b-select placeholder="  Campaign Type" expanded v-model="campaign_type_id">
                <option  v-for="campaign in campaignTypes" :value="campaign.id"> {{campaign.en_name}}</option>
            </b-select>

              
        </b-field>
        <b-field label=" Project">
            <b-select placeholder="Project" v-model="project_id" expanded>
                <option v-for="project in projects" :value="project.id"> {{project.en_name}}</option>
            </b-select>
              
        </b-field>
        <b-field label="Start Date">
            <b-datepicker 
            v-model="start_date"
            placeholder="Start Date"
            :min-date="minDate"
            :max-date="maxDate">
            </b-datepicker>
        </b-field>
         <b-field label="End date">
            <b-datepicker
            v-model="end_date"
            placeholder="End date"
            :min-date="minDate"
            :max-date="maxDate">
            </b-datepicker>
        </b-field>
         
        <b-field label="Budget">
            <b-input v-model="budget" type="number"></b-input>
        </b-field>
        <b-field label="Description">
            <b-input v-model="description" maxlength="200" type="textarea"></b-input>
        </b-field>
           <button class="button is-primary" @click="AddCampaign">submit</button>
   </section>

    
</template>
<script>
import { Storecampaign ,getCampaignInputs} from '../../calls';
    export default {
        data() {
            return {
                projects:[],
                campaignTypes:[],
                campaigns:[],
                en_name:null,
                ar_name:null,
                type:null,
                project:null,
                start_date:null,
                end_date:null,
                budget:null,
                description:null,
                campaign_type_id:null,
                campaign:null,
                project_id: null
            }
        },
        mounted() {
           this.getData()
        },
        methods: {
            getData(){
            this.isLoading = true
            getCampaignInputs().then(response=>{
                console.log("typeeeees",response)
                this.projects = response.data.projects
                this.campaignTypes = response.data.campaignTypes
                  
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
  
    AddCampaign(){
        var data ={
            '_token':this.token,
            'ar_name':this.ar_name,
            'en_name':this.en_name,
            'budget':this.budget,
             'start_date':this.start_date,
            'end_date':this.end_date,
            'description':this.description,
             'project_id':this.project_id,
            'campaign_type_id':this.campaign_type_id

        };
        Storecampaign(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/Allcampaigns')
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
            message: 'Campaign '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
    }
</script>
<style>
.style
{
    background-color: white;
    padding: 20px;
} 
</style>

