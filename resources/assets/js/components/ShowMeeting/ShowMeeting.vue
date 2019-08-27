<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Meeting
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-12">
                                <b><label>Lead: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.leadName"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label> Agent: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.agent"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label> Duration: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.duration"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label> Date: </label></b>
                                <div class="column is-6">
                                    <b-input type="date"  :disabled="disabled" v-model="meetings.date"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label> Location On Map: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.location"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label> Projects: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.projects"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label> Probability: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.probability"/>
                                </div>
                            </div>
                            <hr>
                              <div class="column is-12">
                                <b><label> Description: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="meetings.description"/>
                                </div>
                            </div>
                            <hr>
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateMeeting">Edit</button>

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
import {ShowMeeting,updateMeeting} from './../../calls'
export default {
    data() {
            return {
                meetings:{},
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                file: null,
                uploadedFile: '',
                
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getData()
        },
        components: {
            
        },
        methods: {

            getData(){
            this.isLoading = true
                ShowMeeting(this.id).then(response=>{
                    console.log('sssssssssss',response)
                this.meetings = response.data
                console.log("somayaaa",this.meetings)
                console.log('ttttttttt',this.meetings)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
            toggleInputsActive(){
                this.disabled = !this.disabled
        },
               updateMeeting(){
            const bodyFormData = new FormData();
            for(let key in this.meetings){
                const value = this.meetings[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateMeeting(bodyFormData,this.id).then(response=>{
              console.log("Meeting update",response)
              $(location).attr('href', '/admin/vue/AllMeeting')
            }).catch(error=>{
                console.log(error)
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
                    message: 'Meeting '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
    
            
        }
}
</script>