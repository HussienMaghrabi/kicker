<template>
    <section class="container jobs">
       <b>Job Categories</b><hr>
       <div class="column is-mobile">
           <div class="column is-6">
               <b><label style="display:block">English Name: </label></b>
               <b-input type="text" v-model="en_name"></b-input>
           </div>

        <div class="column is-6">
            <b><label style="display:block">Arabic Name: </label></b>
            <b-input type="text" v-model="ar_name"></b-input>
        </div>

       </div>

        <div class="column is-mobile">
           <div class="column is-6">
                <b-field label="English Description:">
                    <b-input type="textarea" v-model="en_description"></b-input>
                </b-field>  
           </div>

            <div class="column is-6">
                <b-field label="Arabic Description:">
                        <b-input type="textarea" v-model="ar_description"></b-input>
                </b-field>      
            </div>
       </div>

         <b-button type="is-info"  @click="addJobCategory">Submit</b-button>    
 
    </section>
</template>
<style>
.jobs{
    background: #fff;
    padding-left: 2%;
    padding-bottom: 1%;
}
</style>
<script>
import {addJobCategory} from './../../calls'
export default {
    data() {
            return {
                en_name:null,
                ar_name:null,
                en_description:null,
                ar_description:null,
                token: window.auth_user.csrf
            }},
 methods: {
    addJobCategory(){
        var data ={
            '_token':this.token,
            'en_name':this.en_name,
            'ar_name':this.ar_name,
            'en_description':this.en_description,
            'ar_descraption':this.ar_description,
        };
        addJobCategory(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/jobCategories')
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
            message: 'Job Category'+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>
