<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Show Action Logs
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <!-- <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                 -->
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-12">
                                <b><label>Agent : </label></b> 
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="user_name"/>
                                </div>
                            </div>
                            <hr>
                             <div class="column is-12">
                                <b><label> Title: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="ActionLogs.en_title"/>
                                </div>
                            </div>
                            <hr>
                               <div class="column is-12">
                                <b><label> Type: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="ActionLogs.type"/>
                                </div>
                            </div>
                            <hr>
                                    <div class="column is-12">
                                <b><label> Route: </label></b>
                                <div class="column is-6">
                                    <b-input type="text"  :disabled="disabled" v-model="ActionLogs.route"/>
                                </div>
                            </div>
                            <hr>
                        
                     
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateForm">Edit</button>

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
import {ShowActionLogs} from './../../calls'
export default {
    data() {
            return {
                user_name:null,
                ActionLogs:{},
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
                ShowActionLogs(this.id).then(response=>{
                    console.log(";;pp",response)
                this.ActionLogs = response.data.logs
                this.user_name = response.data.user_name
                console.log(this.ActionLogs)
                this.isLoading = false
                })
            .catch(error => {
                console.log(error)
            })
        },
            // handleFile(event) {
            //     const file = event
            //     console.log(file)
            //     if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
            //         alert('Your choice is not an image')
            //         return prevent()
            //     }
            //     var reader = new FileReader
            //     reader.addEventListener('load', () => {
            //         this.uploadedFile = reader.result
            //     })
            // },
            // toggleInputsActive(){
            //     this.disabled = !this.disabled
            // },
            // getData(){
            //     this.isLoading = true
            //         showform(this.id).then(response=>{
            //             console.log(response)
            //             this.form = response.data
            //             this.formUrl = this.form.en_title+'-'+this.form.id
            //             this.isLoading = false
            //         })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // },
            // updateAgent(){
            //     const data = new FormData();
            //     data.append("name",this.agent.name);
            //     data.append("email",this.agent.email);
            //     data.append("phone",this.agent.phone);
            //     data.append("agent_source",this.selectedAgentType);
            //     data.append("password",this.agent.password);
            //     data.append("email_password",this.agent.email_password);
            //     data.append("residential_commercial",this.selectedRC);
            //     data.append("role_id",this.selectedRole);
            //     data.append("image",this.file);
            //     data.append("_token",this.token);
            //     if(this.isSwitched == true){
            //         data.append("type",'admin');
            //     }else{
            //         data.append("type",'agent');
            //     }
            //     updateAgent(data,this.id).then(response=>{
            //         console.log(response)
            //         this.getData()
            //         this.success("Updated")
            //     })
            //     .catch(error => {
            //         this.errorDialog()
            //         console.log(error)
            //     })
            // },
            
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
    
            
        }
}
</script>