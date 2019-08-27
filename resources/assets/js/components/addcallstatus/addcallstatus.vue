<template>
    <section class="container style">
      
       <b-field label=" Name">
            <b-input v-model="name"></b-input>
        </b-field>
     
      
       
         <div class="field">
            <b-switch v-model="has_next_action"><b>Has Next Action</b></b-switch>
        </div>
         <button class="button is-primary" @click="addCallStatus">submit</button>
   </section>
</template>
<script>
   import {addCallStatus} from './../../calls'
export default {
    data() {
            return {
                file: null,
                name:null,
                has_next_action:null,
                token: window.auth_user.csrf
            }},
 methods: {
    addCallStatus(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'has_next_action':this.has_next_action
        };
        addCallStatus(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/callstatus')
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
            message: 'Call Status '+action+' Successfully',
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
