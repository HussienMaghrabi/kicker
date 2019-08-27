<template>
    <div>
        <form action="" class="container">
                <p class="modal-card-title">Add Target</p><br>
                
                    <section class="modal-card-body">
                         <b-field label="Agent Type">
                            <b-select expanded v-model="selectedAgent">
                                 <option v-for="agent_type in agents_type" :value="agent_type.id" >
                                     {{ agent_type.name }} 
                                </option>
                            </b-select>
                        </b-field>

                        <b-field label="Calls">
                            <b-input type="number" v-model="calls"></b-input>
                        </b-field>

                        <b-field label="Meetings">
                            <b-input type="number" v-model="meetings"></b-input>
                        </b-field>
                        
                        <b-field label="Money">
                            <b-input type="number" v-model="money"></b-input>
                        </b-field>

                        <b-field label="Month">
                            <b-input type="number" v-model="month"></b-input>
                        </b-field>

                        <b-field label="Notes">
                            <b-input type="textarea" v-model="notes"></b-input>
                        </b-field>
                        

                          <b-button type="is-info" @click="addTarget">Submit</b-button>
                    </section>
            
                   
  
        </form>
    </div>
</template>

<script>
import {addTarget,getTargetInputs} from './../../calls'
export default {
    data() {
            return {
                selectedAgent: null,
                agents_type:[],
                calls:null,
                meetings:null,
                money:null,
                month:null,
                notes:null,
                token: window.auth_user.csrf
            }},
    mounted() {
        this.getData()
    },
 methods: {
    getData(){
            this.isLoading = true
            getTargetInputs().then(response=>{
                console.log(response)
                this.agents_type = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
    },
    addTarget(){
        var data ={
            '_token':this.token,
            'agent_type_id':this.selectedAgent,
            'calls':this.calls,
            'meetings':this.meetings,
            'money':this.money,
            'month':this.month,
            'notes':this.notes
        };
        addTarget(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/target')
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
            message: 'Target '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>

