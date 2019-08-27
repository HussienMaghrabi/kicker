<template>
    <section class="container style">
     
       <b-field label=" English Name">
            <b-input v-model="en_name"></b-input>
        </b-field>
        <b-field label="Arabic Name">
            <b-input v-model="ar_name"></b-input>
        </b-field>
         <b-field label=" English Description">
            <b-input v-model="en_description"></b-input>
        </b-field>
        <b-field label="Arabic Description">
            <b-input v-model="ar_description"></b-input>
        </b-field>
         <b-field label="Icon">
            <b-input v-model="icon"></b-input>
        </b-field>
        
         <button class="button is-primary" @click="addFacility">submit</button>
   </section>
</template>


<script>
import {addFacility} from './../../calls'
export default {
    data() {
            return {
                en_name:null,
                ar_name:null,
                en_description:null,
                ar_description:null,
                icon:null,
                token: window.auth_user.csrf
            }},
    // mounted() {
    //     this.getData()
    // },
 methods: {
    // getData(){
    //         this.isLoading = true
    //         getJobTitleInputs().then(response=>{
    //             console.log(response)
    //             this.departments = response.data
    //         })
    //         .catch(error => {
    //             console.log(error)
    //         })
    //         this.isLoading = false
    // },
    addFacility(){
        var data ={
            '_token':this.token,
            'en_name':this.en_name,
            'ar_name':this.ar_name,
            'en_description':this.en_description,
            'ar_description':this.ar_description,
            'icon':this.icon

        };
        addFacility(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/facilities')
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
            message: 'facility '+action+' Successfully',
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

