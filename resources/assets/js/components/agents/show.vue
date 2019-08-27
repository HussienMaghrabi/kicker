<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Agent
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
                                <b><label>Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="agent.name" v-model="agent.name" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>Email: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="agent.email" v-model="agent.email" :disabled="disabled" />
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>Phone: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" :value="agent.phone" v-model="agent.phone" :disabled="disabled"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>Password: </label></b>
                                <div class="column is-6">
                                    <b-input type="password" :value="agent.password" v-model="agent.password" :disabled="disabled"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <b><label>Email Password: </label></b>
                                <div class="column is-6">
                                    <b-input type="password" :value="agent.email_password" v-model="agent.email_password" :disabled="disabled"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-12">
                                <div class="column is-6">
                                <b-field label="Source">
                                <b-select v-model="selectedAgentType" expanded :disabled="disabled">
                                    <option v-for="agent_type in agent_types" :key="agent_type.id" :value="agent_type.id">{{agent_type.name}}</option>                      
                                </b-select>
                                </b-field>
                            </div>
                            </div>
                            <div class="column is-12">
                                <b-field label="Residential/Commercial" class="column is-6">
                                    <b-select v-model="selectedRC" expanded :disabled="disabled">
                                        <option value="residential">Residential</option>
                                        <option value="commercial">Commercial</option>
                                    </b-select>
                            </b-field>
                            </div>
                            <hr>
                            <div class="column is-6">
                                <div class="field">
                                <b><label style="display:block">Is Admin: </label></b>
                                <b-switch v-model="isSwitched" :disabled="disabled">
                                </b-switch>
                            </div>
                            </div>
                            <hr>
                            <div class="column is-6">
                                <b-field label="Role" class="column is-6">
                                    <b-select placeholder="Select an agent role" v-model="selectedRole" expanded :disabled="disabled">
                                        <option v-for="role in roles"
                                        :key="role.id"
                                        :value="role.id">{{role.name}}</option>
                                    </b-select>
                            </b-field>
                            </div>
                            <hr>
                            <div class="column is-6">
                                <b><label style="display:block">Image: </label></b>
                                <div class="column is-6">
                                    <img :src="'/uploads/'+agent.image" style="width:150px;height:150px"/>
                                </div>
                            </div>
                            <hr>
                            <div class="column is-6" style="display: flex;justify-content: center;align-items: center;">
                                <b-field class="file" v-if="disabled==false">
                                    <b-upload v-model="file"
                                    @input="handleFile">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="file">
                                        {{ file.name }}
                                    </span>
                                </b-field>
                            </div>
                            <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateAgent">Edit</button>

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
import {getAgent,updateAgent,getAgentTypes,getRoles} from './../../calls'
export default {
    data() {
            return {
                agent: null,
                isLoading: true,
                token: window.auth_user.csrf,
                agentSource: window.auth_user.agentType,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                file: null,
                uploadedFile: '',
                agent_types: [],
                selectedAgentType: '',
                selectedRC: '',
                isSwitched: false,
                roles: [],
                selectedRole: ''
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getAgentTypes()
            this.getRoles()
            this.getData()
        },
        components: {
            
        },
        methods: {
            handleFile(event) {
                const file = event
                console.log(file)
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedFile = reader.result
                })
            },
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    getAgent(this.id).then(response=>{
                        console.log(response)
                        this.agent = response.data
                        this.selectedAgentType = response.data.source_id
                        this.selectedRC = response.data.residential_commercial
                        this.selectedRole = response.data.role_id
                        if(response.data.type == "admin"){
                            this.isSwitched = true
                        }else{
                            this.isSwitched = false
                        }
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
            updateAgent(){
                const data = new FormData();
                data.append("name",this.agent.name);
                data.append("email",this.agent.email);
                data.append("phone",this.agent.phone);
                data.append("agent_source",this.selectedAgentType);
                data.append("password",this.agent.password);
                data.append("email_password",this.agent.email_password);
                data.append("residential_commercial",this.selectedRC);
                data.append("role_id",this.selectedRole);
                data.append("image",this.file);
                data.append("_token",this.token);
                if(this.isSwitched == true){
                    data.append("type",'admin');
                }else{
                    data.append("type",'agent');
                }
                updateAgent(data,this.id).then(response=>{
                    console.log(response)
                    this.getData()
                    this.success("Updated")
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
            },
            getAgentTypes(){
                getAgentTypes().then(response=>{
                    this.agent_types = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getRoles(){
                getRoles().then(response=>{
                    this.roles = response.data
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
                    message: 'Agent '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
            
        }
}
</script>