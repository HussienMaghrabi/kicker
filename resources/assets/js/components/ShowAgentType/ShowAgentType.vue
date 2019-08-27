<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Agent Type
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
                                <b><label> ID: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  disabled="disabled" v-model="AgentType.id"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label> Name: </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="AgentType.name"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label> Description: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="AgentType.description"/>
                                </div>
                            </div>
                            <hr>
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateForm" icon-right="is-pen">Edit</button>

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
import {ShowAgentType,updateAgentType} from './../../calls'
export default {
    data() {
            return {
                AgentType:{},
                form: null,
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                file: null,
                
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
                ShowAgentType(this.id).then(response=>{
                    console.log(response)
                this.AgentType = response.data
                console.log(this.AgentType)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
          toggleInputsActive(){
                this.disabled = !this.disabled
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
                message: 'Agent '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },
        updateForm(){
            const bodyFormData = new FormData();
            for(let key in this.AgentType){
                const value = this.AgentType[key];
                bodyFormData.set(key,value);
            }
            bodyFormData.append('_method','put')
            updateAgentType(bodyFormData,this.id).then(response=>{
              console.log("Agent type update",response)
              $(location).attr('href', '/admin/vue/agent_type')
            }).catch(error=>{
                console.log(error)
            })
        }
    
            
        }
}
</script>