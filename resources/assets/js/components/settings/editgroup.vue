<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit GROUP
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <i style="float:right;margin-right:2.5rem;margin-left:.5rem;color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-trash" @click="DeleteelmentById(group.id)"></i>
                    <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i>
                </section>
                <!-- begin data -->
                    <div class="card-content">
                        <section class="container tasks">
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="Group Parent">
                                    <b-select :disabled="disabled" v-model="group.parent_id" placeholder="Select a Perant of Group" expanded>
                                        <option v-for="p in perant" :key="p.id" :value="p.id">{{ p.name }}</option>
                                    </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="Name of Group">
                                        <b-input :disabled="disabled" placeholder="Group Parent" v-model="group.name" ></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="Team Leader">
                                        <b-select :disabled="disabled" v-model="group.team_leader_id" placeholder="Select Team Leader" expanded>
                                            <option v-for="agent in Agents" :key="agent.id" :value="agent.id">{{ agent.name }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="Team members">
                                        <multiselect :disabled="disabled" :close-on-select="false" v-model="group_members_ids"  tag-placeholder="Add this as new tag" placeholder="Select Groups members" label="name" track-by="id" value="id" :options="Agents" :multiple="true" :taggable="true"></multiselect>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns padding">
                                <div class="column is-12">
                                    <b-field label="Group note">
                                        <b-input :disabled="disabled" v-model="group.notes" maxlength="200" type="textarea" ></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns padding">
                                <div class="column is-12 text-center">
                                    <b-button type="is-info"
                                        :disabled="disabled"
                                        @click="editgroup"
                                        icon-left="send">
                                        Edit now
                                    </b-button>
                                </div>
                            </div>
                        </section>
                        <!-- begin data -->
                        <!-- end data -->
                    </div>
                <!-- end data -->
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {
    GroupDetils,
    editGrouByid,
    deleteGroupById
} from './../../calls'
import Multiselect from 'vue-multiselect'
export default {
    data() {
            return {
                disabled:true,
                id:null,
                group:[],
                perant:[],
                Agents:[],
                group_members_ids:[],
                isLoading:true,
                isFullPage:false,
            }
        },
        components:{
            Multiselect
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted(){
            this.getGroupDetils()
        },
        methods: {
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getGroupDetils(){
                GroupDetils(this.id).then(response=>{
                    this.perant = response.data.perants
                    this.Agents = response.data.agents
                    this.group = response.data.group
                    this.group_members_ids = response.data.group_members_ids
                    console.log('deails response',response)
                    this.isLoading = false
                }).catch(error=>{
                    console.log(error)
                })
            },
            editgroup(){
                this.isLoading = true
                const bodyFormData = new FormData();
                // console.log('ids',this.group_members_ids)
                for (let key in this.group) {
                    const value = this.group[key];
                    bodyFormData.set(key, value);
                }
                for (var i = 0; i < this.group_members_ids.length; i++) {
                    bodyFormData.append('members[]', this.group_members_ids[i].id);
                }
                bodyFormData.append('_method','put')
                editGrouByid(bodyFormData,this.id).then(response=>{
                    this.alertsuccess('Group is up to date')
                    this.isLoading = false
                    this.getGroupDetils()
                }).catch(error=>{
                    console.log(error)
                })
            },
            DeleteelmentById(id) {
                // console.log(id);
                this.$dialog.confirm({
                    title: 'Deleting',
                    message: 'Are you sure you want to <b>delete</b> this element?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteGroup(id)
                })
            },
            deleteGroup(id){
                this.isLoading = true
                deleteGroupById(id).then(response=>{
                    if(response.data.status == 200){
                        this.$router.go(-1)
                        this.alerterror('group is deleted')
                    }
                    console.log('deleting massege',response)
                    this.isLoading = false
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