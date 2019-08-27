<template>
    <div>
         <form action="" class="container">
            <div class="modal-card" style="width: auto">
                    <b class="modal-card-title">Add Job Title</b><br>
                <section>
                    <b-field label="Name" class="column is-6">
                        <b-input v-model="name"
                            type="text"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="Description" class="column is-6">
                        <b-input type="textarea" v-model="Description"></b-input>
                    </b-field>

                    <b-button @click="addTitle" type="is-info">Submit</b-button>
          
                </section>

              
            </div>
        </form>
    </div>
</template>

<script>
import {addTitle} from './../../calls'
export default {
    data() {
            return {
                name:null,
                Description:null,
                token: window.auth_user.csrf
            }},
 methods: {
    addTitle(){
        var data ={
            '_token':this.token,
            'name':this.name,
            'description':this.Description
        };
        addTitle(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/titles')
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
            message: 'Title '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>

<style>
 .button.is-info{
     float: left;
     width: 6%;
 }
</style>
