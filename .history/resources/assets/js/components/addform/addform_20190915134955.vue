<template>
    <section class="container style">
       <b-field label=" Type">
            <b-select v-model="type" placeholder=" Type " expanded>
                <option value="project">Project</option>
                <option value="event">Event</option>
                <option value="campaign">Campaign</option>

            </b-select>
       </b-field>

        <!-- <b-field v-if="type==='event'" label="Event">
            <b-input  v-model="event_id"></b-input>
        </b-field> -->
         <b-field v-if="type==='event'" label=" event">
             <b-select v-model="event_id" placeholder="Select Event" expanded>
                 <option v-for="event in events" :value="event.id">{{event.title}}</option>
            </b-select> 
        </b-field>

         <b-field v-if="type==='project'" label=" Project">
             <b-select v-model="project_id" placeholder="Select Project" expanded>
                 <option v-for="project in projects" :value="project.id">{{project.name}}</option>
            </b-select> 
        </b-field>

        <b-field v-if="type==='campaign'" label=" campaign">
             <b-select v-model="campaign_id_id" placeholder="Select Campaign" expanded>
                 <option v-for="campaign in campaigns" :value="campaign.id">{{campaign.name}}</option>
            </b-select> 
        </b-field>
         <!-- <b-field v-if="type==='campaign'" label=" Campaign">
            <b-input  v-model="campaign_id"></b-input>
        </b-field> -->

       <b-field label=" English Title">
            <b-input v-model="en_title"></b-input>
        </b-field>

        <b-field label="Arabic Title">
            <b-input v-model="ar_title"></b-input>
        </b-field>
        <b-field label=" Lead source">
            <b-select v-model="lead_source_id" placeholder=" Lead source" expanded>
                 <option v-for="form in forms" :value="form.id">{{form.leadSourceName}}</option>
            </b-select> 
        </b-field>
         <b-field label=" Field">
            <b-input v-model="field"></b-input>
        </b-field>
                <!-- <div class="form-group">
                    <label for="exampleFormControlFile1" ><b> Background</b></label>
                    <b-input v-model="background" type="file" class="form-control-file" id="exampleFormControlFile1"> </b-input>
                </div> -->
        <b-field>
            <b-upload v-model="background"
                multiple
                drag-drop>
                <section class="section">
                    <div class="content has-text-centered">
                        <p>
                            <b-icon
                                icon="upload"
                                size="is-large">
                            </b-icon>
                        </p>
                        <p>Drop your files here or click to upload</p>
                    </div>
                </section>
            </b-upload>
        </b-field>

        <div class="tags">
            <span v-for="(file, index) in background"
                :key="index"
                class="tag is-primary" >
                {{file.name}}
                <button class="delete is-small"
                    type="button"
                    @click="deleteDropFile(index)">
                </button>
            </span>
        </div>

       
         <div class="field">
            <b-switch><b>Required</b></b-switch>
        </div>
         <button @click="Addform" class="button is-primary">submit</button>
   </section>
</template>
<script>
import { Addform ,getFormsInputs,getAllProjects,getAllevents,getAllcampaigns} from '../../calls';
    export default {
        data() {
            return {
                forms:{},
                en_title:null,
                ar_title:null,
                type:null,
                field:[],
                lead_source_id:null,
                leadSourceName:null,
                id:null,
                background:[],
                developer_id:null,
                token: window.auth_user.csrf,
                projects: [],
                events: [],
                campaigns: []


            }
        },
        mounted() {
           this.getData()
           this.getAllProjects()
           this.getAllevents()
           this.getAllcampaigns()

        },
        methods: {
            getAllProjects(){
                getAllProjects().then(response=>{
                    this.projects = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
                  getAllevents(){
                getAllevents().then(response=>{
                    this.events = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
                  getAllcampaigns(){
                getAllcampaigns().then(response=>{
                    this.campaigns = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getData(){
            this.isLoading = true
            getFormsInputs().then(response=>{
                console.log("fooooooooorms",response)
                this.forms = response.data
                   console.log("ssssss",this.forms)
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
  
    // Addform(){
    //     var data ={
    //         'lead_source_id':this.lead_source_id,
    //         '_token':this.token,
    //         'type':this.type,
    //         'ar_title':this.ar_title,
    //         'en_title':this.en_title,
    //         'field':this.field,
    //         'background':this.background,
    //         // 'developer_id':this.developer_id,
    //         // 'project_id':this.project_id,
    //         // 'event_id':this.event_id,
    //         // 'campaign_id':this.campaign_id
    //     };
    //     Addform(data).then(response=>{
    //         this.success("Added")
    //         // $(location).attr('href', '/admin/vue/forms')
    //     })
    //     .catch(error => {
    //             this.errorDialog()
    //     })
    // },

       Addform(){
                const bodyFormData = new FormData();
                bodyFormData.append('lead_source_id',this.lead_source_id)
                bodyFormData.append('_token',this.token)
                bodyFormData.append('type',this.type)
                bodyFormData.append('ar_title',this.ar_title)
                bodyFormData.append('en_title',this.en_title)
                bodyFormData.append('field',this.field)
                bodyFormData.append('background',this.background[0])


                Addform(bodyFormData,this.id).then(response=>{
                    console.log(response)
                  $(location).attr('href', '/admin/vue/forms')
                }).catch(error=>{
                    console.log(error)
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
            message: 'Form '+action+' Successfully',
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
