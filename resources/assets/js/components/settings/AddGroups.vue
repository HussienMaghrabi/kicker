<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            
                            ADD GROUP
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-field label="Group Parent">
                            <b-select v-model="group.parent_id" placeholder="Select a Perant of Group" expanded>
                                <option v-for="p in perant" :key="p.id" :value="p.id">{{ p.name }}</option>
                            </b-select>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-field label="Name of Group">
                                <b-input placeholder="Group Parent" v-model="group.name" ></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-field label="Team Leader">
                                <b-select v-model="group.team_leader_id" placeholder="Select Team Leader" expanded>
                                    <option v-for="agent in Agents" :key="agent.id" :value="agent.id">{{ agent.name }}</option>
                                </b-select>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-field label="Team Leader">
                                <multiselect :close-on-select="false" v-model="group_members_ids"  tag-placeholder="Add this as new tag" placeholder="Select Groups members" label="name" track-by="id" value="id" :options="Agents" :multiple="true" :taggable="true"></multiselect>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12">
                            <b-field label="Group note">
                                <b-input v-model="group.note" maxlength="200" type="textarea" ></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12 text-center">
                            <b-button type="is-info"
                                @click="savegroup"
                                icon-left="send">
                                save now
                            </b-button>
                        </div>
                    </div>
                </section>
                <!-- begin data -->
                <!-- end data -->
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
    margin-bottom: 3rem
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {
    getGroups,
    getAgents,
    storegroup,
} from './../../calls'
import Multiselect from 'vue-multiselect'
export default {
    data() {
            return {
                perant:[],
                NewEvent:[],
                groupdata:[],
                group:[],
                Agents:[],
                group_members_ids:[],
                isFullPage:false,
                isLoading:false,
            }
        },
        components:{
            Multiselect
        },
        created() {
            this.getGroupsData()
        },
        mounted(){
        },
        methods: {
            getGroupsData(){
                getGroups().then(response=>{
                    console.log('this response',response)
                    this.perant = response.data.perants
                    this.Agents = response.data.agents
                    console.log('perants',this.perant)
                }).catch(error=>{
                    console.log(error)
                })
            },
            savegroup(){
                this.isLoading = true;
                const bodyFormData = new FormData();
                // console.log('ids',this.group_members_ids)
                for (let key in this.group) {
                    const value = this.group[key];
                    bodyFormData.set(key, value);
                }
                for (var i = 0; i < this.group_members_ids.length; i++) {
                    bodyFormData.append('members[]', this.group_members_ids[i].id);
                }
                storegroup(bodyFormData).then(response=>{
                    this.isLoading = false
                    this.alertsuccess('Success added new group')
                    this.group = []
                    this.group_members_ids = []
                }).catch(error=>{
                    console.log(error)
                })
            },
            alertsuccess(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-success'
                })
            },
            alerterror(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
            }
        }
}
</script>