<template>
    <section class="container style">
       
        <b-field label=" English Name">
            <b-input v-model="en_name"></b-input>
        </b-field>
        <b-field label="Arabic Name">
            <b-input v-model="ar_name"></b-input>
        </b-field>
        <b-field label="Notes">
            <b-input v-model="notes" maxlength="200" type="textarea"></b-input>
        </b-field>
        <button class="button is-primary" @click="addType">submit</button>
    </section>

    
</template>
<script>
import {addType} from './../../calls'
export default {
    data() {
            return {
                en_name:null,
                ar_name:null,
                notes:null,
                token: window.auth_user.csrf
            }},
 methods: {
  
    addType(){
        var data ={
            '_token':this.token,
            'en_name':this.en_name,
            'ar_name':this.ar_name
        };
        addType(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/Campaign_type')
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
            message: 'Campiagn Type '+action+' Successfully',
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