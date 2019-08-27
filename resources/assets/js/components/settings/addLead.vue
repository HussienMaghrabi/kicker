<template>
    <div>
        <form action="" class="container">
                <p class="modal-card-title">Add a Lead Source</p><br>
                <section>
                    <b-field label="Name" class="column is-6" >
                        <b-input
                            v-model="LeadSourceName"
                            type="text"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="Description" class="column is-6">
                        <b-input type="textarea" v-model="Description"></b-input>
                    </b-field>
                    <b-button @click="addLeadSource" type="is-info">Submit</b-button>
                </section>
        </form>
    </div>
</template>

<script>
import {addLeadSource} from './../../calls'
export default {
    data() {
            return {
                LeadSourceName:null,
                Description:null,
                token: window.auth_user.csrf
            }},
 methods: {
    addLeadSource(){
        var data ={
            '_token':this.token,
            'name':this.LeadSourceName,
            'description':this.Description
        };
        addLeadSource(data).then(response=>{
            this.success("Added")
            $(location).attr('href', '/admin/vue/leadSource')
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
            message: 'Lead Source '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>

