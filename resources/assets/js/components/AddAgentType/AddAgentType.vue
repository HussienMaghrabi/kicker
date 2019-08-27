<template>
    <section class="container style">
       
        <b-field label="  Name">
            <b-input v-model="name"></b-input>
        </b-field>
     
        <b-field label="Description">
            <b-input v-model="description" maxlength="200" type="textarea"></b-input>
        </b-field>
        <button class="button is-primary" @click="addAgentType">submit</button>
    </section>

    
</template>
<script>
import {addAgentType} from './../../calls'
export default {
    data() {
            return {
                name:null,
                 description:null,
                token: window.auth_user.csrf
            }},
 methods: {
  
    addAgentType(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'description':this.description
        };
        addAgentType(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/agent_type')
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
            message: 'Agent Type '+action+' Successfully',
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