<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Facility
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
                                <b><label>ID: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  disabled="disabled" v-model="facilities.id"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>English Name: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="facilities.en_name"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label>Arabic Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="facilities.ar_name"/>
                                </div>
                            </div>
                            <hr>
                                <div class="column is-12">
                                <b><label>English Description: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="facilities.en_description"/>
                                </div>
                            </div>
                            <hr>
                                <div class="column is-12">
                                <b><label>Arabic Description: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="facilities.ar_description"/>
                                </div>
                            </div>
                            <hr>
                                  <div class="column is-12">
                                <b><label>Icon: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="facilities.icon"/>
                                </div>
                            </div>
                            <hr>
                        
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateFacility">Edit</button>

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
import {ShowFacility,updateFacility} from './../../calls'
export default {
    data() {
            return {
                facilities:{},
                form: null,
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
            console.log(this.id)
                ShowFacility(this.id).then(response=>{
                    console.log("ssssssss",response)
                this.facilities = response.data
                console.log(this.facilities)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
        
             toggleInputsActive(){
                this.disabled = !this.disabled
        },
           
               updateFacility(){
            const bodyFormData = new FormData();
            for(let key in this.facilities){
                const value = this.facilities[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateFacility(bodyFormData,this.id).then(response=>{
              console.log("facilities update",response)
              $(location).attr('href', '/admin/vue/facilities')
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
                    message: 'Facility '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
    
    
            
        }
}
</script>