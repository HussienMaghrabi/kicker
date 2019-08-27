<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Add Agent
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="column first">
                        <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-12">
                                <b><label>Name: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" v-model="agent.name" />
                                </div>
                            </div>
                            <div id="preview" style="position:absolute;top:5%;right:18%">
                                <img v-if="imageUrl" :src="imageUrl" style="width:150px;height: 150px;" />
                            </div>
                            <div class="column is-12">
                                <b><label>Email: </label></b>
                                <div class="column is-6">
                                    <b-input type="text" v-model="agent.email" />
                                </div>
                            </div>
                            <div class="column is-12">
                                <b><label>Phone: </label></b>
                                <div class="column is-6">
                                    <b-input type="number" v-model="agent.phone"/>
                                </div>
                            </div>
                            <div class="column is-12">
                                <b><label>Password: </label></b>
                                <div class="column is-6">
                                    <b-input type="password" v-model="agent.password"/>
                                </div>
                            </div>
                            <div class="column is-12">
                                <b><label>Email Password: </label></b>
                                <div class="column is-6">
                                    <b-input type="password" v-model="agent.email_password"/>
                                </div>
                            </div>
                            <div class="column is-12">
                                <div class="column is-6">
                                    <b-field label="Source">
                                        <b-select v-model="selectedAgentType" expanded>
                                            <option v-for="agent_type in agent_types" :key="agent_type.id" :value="agent_type.id">{{agent_type.name}}</option>                      
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <div class="column is-12">
                                <b-field label="Residential/Commercial" class="column is-6">
                                    <b-select v-model="selectedRC" expanded>
                                        <option value="residential">Residential</option>
                                        <option value="commercial">Commercial</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <div class="field">
                                    <b><label style="display:block">Is Admin: </label></b>
                                    <b-switch v-model="isSwitched"></b-switch>
                                </div>
                            </div>
                            <div class="column is-6">
                                <b-field label="Role" class="column is-6">
                                    <b-select placeholder="Select an agent role" v-model="selectedRole" expanded>
                                        <option v-for="role in roles"
                                        :key="role.id"
                                        :value="role.id">{{role.name}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-12">
                                <b-field class="file">
                                    <b-upload v-model="image"
                                    @input="handleFile">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="image">
                                        {{ image.name }}
                                    </span>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <button type="button" class="button is-success is-meduim mr-10 import-excel" @click="storeAgent">Save</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import {getAgentTypes,getRoles,storeAgent} from './../../calls'
export default {
     data() {
            return {
                agent: {},
                isLoading: true,
                token: window.auth_user.csrf,
                agentSource: window.auth_user.agentType,
                userType: window.auth_user.type,
                id: null,
                image: null,
                uploadedFile: '',
                agent_types: [],
                selectedAgentType: '',
                selectedRC: '',
                isSwitched: false,
                roles: [],
                selectedRole: '',
                imageUrl: ''
            }
        },
        created() {
        },
        mounted() {
            this.getAgentTypes()
            this.getRoles()
        },
        components: {
            
        },
        methods: {
            handleFile(event) {
                const image = event
                console.log(image)
                this.imageUrl = URL.createObjectURL(image);
                if (!/\.(jpg|jpeg|png)$/i.test(image.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedFile = reader.result
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
            storeAgent(){
                const data = new FormData();
                data.append("name",this.agent.name);
                data.append("email",this.agent.email);
                data.append("phone",this.agent.phone);
                data.append("agent_source",this.selectedAgentType);
                data.append("password",this.agent.password);
                data.append("email_password",this.agent.email_password);
                data.append("residential_commercial",this.selectedRC);
                data.append("role_id",this.selectedRole);
                data.append("image",this.image);
                data.append("_token",this.token);
                if(this.isSwitched == true){
                    data.append("type",'admin');
                }else{
                    data.append("type",'agent');
                }
                storeAgent(data).then(response=>{
                    $(location).attr('href', '/admin/vue/agents')
                    this.success("Saved")
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
            },
        }
}
</script>

<style>

</style>
