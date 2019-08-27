<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit campaign
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
                                <b><label>English Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-model="campaigns.en_name" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Arabic Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-model="campaigns.ar_name" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Campaign Type : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-model="campaignType" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label> Project : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-model="project" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                               <div class="column is-12">
                                <b><label>Start Date  : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-model="campaigns.start_date" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                                  <div class="column is-12">
                                <b><label>End Date  : </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  v-model="campaigns.end_date" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                                     <div class="column is-12">
                                <b><label>Budget : </label></b>
                                <div class="column is-6">
                                    <b-input type="text" v-model="campaigns.budget" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                            
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateCampiagn">Edit</button>

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
import {ShowCampaign,updateCampiagn} from './../../calls'
export default {
    data() {
            return {
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                campaigns:{},
                project:'',
                campaignType:null,
                
                
               
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
           
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    ShowCampaign(this.id).then(response=>{
                        console.log('dddddddddddd',response)
                        this.campaigns = response.data.campaign
                        this.campaignType = response.data.all.data[0].campaignType
                        this.project = response.data.all.data[0].project

                        console.log(this.campaignType)
                        this.isLoading = false
                    })
                .catch(error => {
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
                    message: 'Campaign '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
            updateCampiagn(){
            const bodyFormData = new FormData();
            for(let key in this.campaigns){
                const value = this.campaigns[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateCampiagn(bodyFormData,this.id).then(response=>{
              console.log("Campaign update",response)
              $(location).attr('href', '/admin/vue/AllCampaigns')
            }).catch(error=>{
                console.log(error)
            })
        },
            
        }
}
</script>