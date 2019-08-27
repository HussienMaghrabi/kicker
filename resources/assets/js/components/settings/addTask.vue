<template>
    <div class="container">
        <form action="" class="container style">
            <div class="modal-card" style="width: auto">
                    <b class="modal-card-title"> Add Task</b><br>
                <section>
                    <b-field label="Agent">
                        <b-select expanded v-model="selectedAgent">
                              <option v-for="agent in agents" :value="agent.id">
                                {{ agent.name}} 
                            </option>
                        </b-select>
                    </b-field>

                    <b-field label="Leads">
                        <b-select expanded v-model="selectedLead">
                            <option v-for="lead in leads" :value="lead.id">
                                {{ lead.first_name}} {{ lead.last_name }}
                            </option>
                        </b-select>
                    </b-field>

                    <b-field label="Select a date">
                        <b-datepicker
                            placeholder="Click to select..."
                            :date-formatter="dateFormatterFrom"
                            v-model="due_date"
                            icon="calendar-today"  style="width:100%;">
                        </b-datepicker>
                    </b-field>

                    <b-field label="Task Type">
                        <b-select expanded v-model="task_type">
                            <option value="call">call</option>
                            <option value="meeting">meeting</option>
                            <option value="others">others</option>
                        </b-select>
                    </b-field>
                
                    
                    <b-field label="Description">
                        <b-input type="textarea" v-model="description"></b-input>
                    </b-field>
                    
                </section>
                <b-button @click="addTask" type="is-info">Submit</b-button>
            </div>
        </form>
    </div>
</template>

<script>
import {addTask,getTaskInputs} from './../../calls'
export default {
    data() {
            return {
                due_date:null,
                task_type:null,
                description:null,
                agents:[],
                leads:[],
                token: window.auth_user.csrf,
                selectedAgent: null,
                selectedLead: null,
                isLoading: true,
            }},
    mounted() {
        this.getData()
    },
 methods: {
     getData(){
            this.isLoading = true
            getTaskInputs().then(response=>{
                console.log(response)
                this.agents = response.data.agents
                this.leads = response.data.leads
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    addTask(){
        var data ={
            '_token':this.token,
            'agent_id':this.selectedAgent,
            'leads':this.selectedLead,
            'due_date':this.due_date,
            'task_type':this.task_type,
            'description':this.description,
        };
        console.log('new add',data)
        addTask(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/task')
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
            message: 'Task'+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
    dateFormatterFrom(dt){
        var date = dt.toLocaleDateString();
        const [month, day, year] = date.split('/')
        this.due_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        return date
    },
 },
}
</script>
<style>
 .control{
     width: 50%;
 }
 .button.is-info{
     float: left;
     width: 6%;
 }
 
   .style
{
    background-color: white;
    padding: 20px;
} 
</style>


