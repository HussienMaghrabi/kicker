<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Meeting Status
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                             <div class="columns is-12">
                                 <div class="column is-6">
                                    <b-field label="ID">
                                        <b-input v-model="meetingStatus.id" disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                                <div class="column is-6">
                                    <b-field label="Name">
                                        <b-input v-model="meetingStatus.name" :disabled="disabled"></b-input>
                                    </b-field>
                                </div>
                            </div>

                                 <div class="column is-12">
                                    <b-field label="Has Next Action">
                                        <b-switch v-model="meetingStatus.has_next_action"
                                            :disabled="disabled"
                                            true-value="1"
                                            false-value="0">
                                        </b-switch>
                                    </b-field>
                                </div>
                        
                            <div class="columns is-12 text-center" style="margin:auto">
                                <b-button :disabled="disabled" @click="updateForm" type="is-success" icon-right="pen"> Edit </b-button>
                            </div>
                    </div>
                </div> 
                </section>
            </div>
        </div>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
}
</style>
<script>
import {showMeetingStatus , updateMeetingstatus} from './../../calls'

export default {
    data() {
        return {
                meetingStatus: {},
                id: null,
                isLoading: true,
                disabled: true,
                token: window.auth_user.csrf,                
            }},
    mounted() {
        this.getData()
    },
    created() {
        this.id = this.$route.params.id
    },
    methods: {
      getData(){
            this.isLoading = true
                showMeetingStatus(this.id).then(response=>{
                    console.log("Meeting Status",response)
                this.meetingStatus = response.data
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
        toggleInputsActive(){
            this.disabled = !this.disabled
        },
        updateForm(){
                const bodyFormData = new FormData();
                for (let key in this.meetingStatus) {
                    const value = this.meetingStatus[key];
                    bodyFormData.set(key, value);
                    console.log(key,value);
                }
                bodyFormData.append('_token',this.token)
                bodyFormData.append('_method','PUT')
                updateMeetingstatus(bodyFormData,this.id).then(response=>{
                    console.log(response)
                  $(location).attr('href', '/admin/vue/meeting_status')
                }).catch(error=>{
                    console.log(error)
                })
            }
    },
           
}
</script>