<template>
    <div class="container is-fluid">
      <Assistant
      ref="_slider"/>
                <div class="card ">
                    <header class="card-header level header-content">
                        <div class="level">
                            <div class="level-item">
                                <p class="card-header-title">
                                    All Leads
                                </p>
                            </div>
                        </div>
                        <div class="level" v-if="this.$route.path != '/archive/1'">
                            <div class="level-item">
                                <router-link to="/admin/vue/uploadLeads" class="button is-success is-meduim mr-10 import-excel"
                                    v-if="permArray['export_excel'] == 1 || userType == 'admin'"
                                >
                                    Import From Excel
                                </router-link>
                                <!-- <a class="button is-success is-meduim mr-10" href="/admin/leads/create">Add</a> -->
                                <router-link :to="'/admin/vue/newLead'"  @click="showAddLead = true" class="button is-success is-meduim mr-10">
                                    <span> Add new... </span>
                                </router-link>
                            </div>
                        </div>

                    </header>
                    <div class="card-content">
                        <div class="content cardContentHeight">
                            <i class="fas fa-filter fa-2x" id="routerIcon" @click="toggleRouterLinks"></i>
                            <span v-if="this.$route.path != '/archive/1'" class="leads-menu" id="leads-menu">
                            <router-link to="/admin/vue/MyLeads#/1" :class="checkClass('MyLeads')">
                                <i class="fas fa-user-alt fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>My Leads</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/IndividualLeads#/1" :class="checkClass('IndividualLeads')" v-if="userType == 'admin'">
                                <i class="fas fa-download fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    Fresh Leads
                                    <span class="header-num" style="display: inline-block; background-color: red; padding: 3px 12px; border-radius: 50%; color: white">{{getLeadsByAgent[9] && getLeadsByAgent[9].count || 0}}</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/RotationalLeads#/1" :class="checkClass('RotationLeads')">
                                <i class="fas fa-download fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    Rotational Leads
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/TeamLeads#/1" :class="checkClass('TeamLeads')" v-if="userType == 'admin' || teamLeader == 1">
                                <i class="fas fa-user-friends fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>Team Leads</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/OwnedUnits#/1" :class="checkClass('OwnedUnits')">
                                <i class="fas fa-home fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>Unit Owners</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/HotLeads#/1" :class="checkClass('HotLeads')">
                                <i class="fas fa-fire fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>Hot Leads</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/FavoriteLeads#/1" :class="checkClass('FavoriteLeads')">
                                <i class="fas fa-star fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>Favorite Leads</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/todayleads#/1" :class="checkClass('')">
                                <i class="fas fa-plus fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>Today Lead</span>
                                    <span class="header-num" style="display: inline-block; background-color: red; padding: 3px 12px; border-radius: 50%; color: white">{{getLeadsByAgent[5] && getLeadsByAgent[5].count || 0}}</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/seen#/1" :class="checkClass('')">
                                <i class="fas fa-eye fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    <span>Seen</span>
                                    <span class="header-num" style="display: inline-block; background-color: red; padding: 3px 12px; border-radius: 50%; color: white">{{getLeadsByAgent[6] && getLeadsByAgent[6].count || 0}}</span>
                                </div>
                            </router-link>
                            <router-link to="/admin/vue/notseen#/1" :class="checkClass('')">
                                <i class="fas fa-eye-slash fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    Not Seen 
                                    <span class="header-num" style="display: inline-block; background-color: red; padding: 3px 12px; border-radius: 50%; color: white">{{getLeadsByAgent[7] && getLeadsByAgent[7].count || 0}}</span>
                                </div>                                
                            </router-link>
                            <router-link to="/admin/vue/todaycoldcalls#/1" :class="checkClass('')">
                                <i class="fas fa-phone-volume fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    Today Cold Calls 
                                    <span class="header-num" style="display: inline-block; background-color: red; padding: 3px 12px; border-radius: 50%; color: white">{{getLeadsByAgent[8] && getLeadsByAgent[8].count || 0}}</span>
                                </div>                                
                            </router-link>
                            <router-link to="/admin/vue/coldcalls#/1" :class="checkClass('')">
                                <i class="fas fa-thermometer-empty fa-lg menu_icons"></i>
                                <div id="menu_info">
                                    Cold Calls 
                                    <span class="header-num" style="display: inline-block; background-color: red; padding: 3px 12px; border-radius: 50%; color: white">{{getLeadsByAgent[3] && getLeadsByAgent[3].count || 0}}</span>
                                </div>                                
                            </router-link>
                            </span>
                            <transition name="fade">
                                <router-view></router-view>
                            </transition>
                        </div>

                    </div>
                </div>
            <b-modal :active.sync="showAddLead">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add Lead</p>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-6">
                                <b-field label="First Name">
                                    <b-input v-model="newLeadData.leadFirstName"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Last Name">
                                    <b-input v-model="newLeadData.leadLastName"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6" id="phoneInputWrapper">
                                <b-field label="phone" :type="phoneInputType" id="phoneInput">
                                    <b-input
                                     type="number"
                                     min="0"
                                     :validation-message="phone_validation_message"
                                     @input="search"
                                     v-model="newLeadData.phone"></b-input>
                                </b-field>
                                <p v-if="phone_validation_message !== 'Not Found'" class="help is-danger">{{phone_validation_message}}</p>
                                <p v-else class="help is-success">{{phone_validation_message}}</p>

                            </div>
                            <div class="column is-6">
                                <label class="label">Lead source</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.sourceId">
                                            <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-12">
                                <div class="field">
                                    <b-checkbox v-model="newLeadData.checkIndividual">
                                        Lead Is Individual
                                    </b-checkbox>
                                </div>
                            </div>
                            <!-- <input type="hidden" v-model="newLeadData.r_agent" value=""> -->
                            <div class="column is-6" v-if="residentialAgents.length != 0 && newLeadData.checkIndividual == false">
                                <label class="label">Residencial Agent</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.r_agent">
                                            <option v-for="agent in residentialAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6" v-if="residentialAgents.length != 0 && newLeadData.checkIndividual == false">
                                <label class="label">Commercial Agent</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.c_agent">
                                            <option v-for="agent in commercialAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-12">
                                <b-field label="Reference">
                                    <b-input v-model="newLeadData.reference"></b-input>
                                </b-field>
                            </div>

                            <div class="column is-12">
                                <b-field label="Notes">
                                    <b-input v-model="newLeadData.notes" maxlength="200" type="textarea"></b-input>
                                </b-field>
                            </div>

                            <div class="column is-12">
                                <div class="column is-12">
                                    <b-field label="Add Request"></b-field>
                                </div>
                            </div>
                            <div class="column is-6">
                                <label class="label">Buyer Or Seller</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.request.type" required="">
                                            <option value="buyer">Buyer</option>
                                            <option value="seller">Seller</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-6">
                                <label class="label">Request Type</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.request.request_type" required="">
                                            <option value="resale">Resale</option>
                                            <option value="rental">Rental</option>
                                            <option value="new_home">New Home</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-6">
                                <label class="label">Location On Map</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.request.location">
                                            <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-6">
                                <label class="label">Unit Type</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select v-model="newLeadData.request.unit_type" required="">
                                            <option value="residential">Residential</option>
                                            <option value="commercial">Commercial</option>
                                            <option value="land">Land</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-12">
                                <label class="label">Projects</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <multiselect v-if="phoneInputType=='is-danger'" :close-on-select="false" v-model="newLeadData.request.projects"  tag-placeholder="Add this as new tag" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="projects" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                                        <multiselect v-else :close-on-select="false" v-model="newLeadData.request.projects"  tag-placeholder="Add this as new tag" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="projects" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>                                                                    
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot" style="justify-content: flex-end;">
                        <button v-if="phoneInputType == 'is-danger'" class="button is-primary" @click="addLead">Update Lead</button>
                        <button v-else class="button is-primary" @click="addLead">Add Lead</button>
                    </footer>
                </div>
            </b-modal>

            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {checkUserGroupAndRoles, getLeadsByAgent, getBtns, getLeadSources, getAgents,leadShortAdding,getPublicData,searchForLeadPhone} from './../../calls'

import Assistant from "../dashboard/components/Assistant.vue";
import Multiselect from 'vue-multiselect'

    export default {
        data() {
            return {
                allAgents: [],
                getLeadsByAgent: [],
                activeTab: 0,
                activeTabActions: 0,
                userType: window.auth_user.type,
                id: window.auth_user.id,
                teamLeader: 0,
                showTabs: false,
                isFullPage: true,
                isLoading: false,
                permArray: [],
                url: '',
                showAddLead: false,
                newLeadData: {
                    request:{},
                    checkIndividual:true
                },
                leadSources: [],
                residentialAgents: [],
                locations:[],
                projects:[],
                openOnFocus: false,
                selected: null,
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                phoneInputType: '',
                phone_validation_message: '',
                show_routers: false,
                checkIndividual: true
            }
        },
        components: {
            Assistant: Assistant,
            Multiselect

        },
        mounted () {
            this.toggleRouterLinks()
            this.checkUserHasGroup()
            // var test = $('body > div > div > div.modal.is-active > div.animation-content.modal-content');
        },
        created() {
            this.getPublic()
            this.getLeadsfilter()
            this.getSources()
            this.getCompanyAgents()
            this.newLeadData.r_agent = this.id
        },
        methods: {
            getPublic(){
                getPublicData().then(response=>{
                    this.locations = response.data.locations
                    this.projects = response.data.projects                    
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getCompanyAgents(){
                getAgents().then(response=>{
                    this.commercialAgents = response.data.commercialAgents
                    this.residentialAgents = response.data.residentialAgents
                    this.commercialAgents.forEach(element => {
                        this.allAgents.push(element)
                    });
                    this.residentialAgents.forEach(element => {
                        this.allAgents.push(element)
                    });
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getSources(){
                getLeadSources().then(response=>{
                    this.leadSources = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            addLead(){
                leadShortAdding(this.newLeadData).then(response=>{
                    this.showAddLead = false
                    location.reload();
                })
                .catch(error => {
                    console.log(error)
                })


            },

            checkLeads(btns)
            {
                    console.log(btns)
                switch(btns.title) {
                    case "Hot Leads":
                        this.url = '/HotLeads/1'
                        console.log(this.url)
                        break;
                    case "FavoriteLeadsrite Leads":
                        this.url = '/FavoriteLeads/1'
                        break;
                    case "Facebook":
                        this.url = '/HotLeads/1'
                        break;
                    case "Cold Calls":
                        this.url = '/HotLeads/1'
                        break;
                    case "Followup":
                        this.url = '/HotLeads/1'
                        break;
                    case "Switch":
                        this.url = '/HotLeads/1'
                        break;
                    case "Lowest":
                        this.url = '/HotLeads/1'
                        break;
                    default:
                        this.url = '/HotLeads/1'
                }
            },
             getLeadsfilter(){
                getBtns({
                  "user_id": window.auth_user.id,
                  "agent_id": " ",
                }).then(response=>{
                    this.getLeadsByAgent = response.data.btns
                })
                .catch(error => {
                    console.log(error)
                })
            },

            checkUserHasGroup(){
                checkUserGroupAndRoles().then(response=>{
                    //console.log(response)
                    this.teamLeader = response.data.leaderHasGroup
                    this.permArray = response.data.permArray

                })
                .catch(error => {
                    console.log(error)
                })
            },
            checkClass(r){
                var path = this.$route.path.split('/');
                if(path[1] == r) return 'tabLinkActive'
                else return 'tabLinkNotActive'
            },
            search(){
                if(this.newLeadData.phone){
                    var data ={
                        'searchInput':this.newLeadData.phone,
                        '_token':this.token,
                    };
                    searchForLeadPhone(data).then(response=>{
                        if(response.data !== 'Not Found'){
                            this.phoneInputType = 'is-danger'
                        }else{
                            this.phoneInputType = 'is-success'
                        }
                        this.phone_validation_message = response.data
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }  else if (this.searchInput.trim() === "") {
                    this.getData();
                }
            },
            toggleRouterLinks(){
                console.log("test1")
                if (this.show_routers === false){
                     console.log("test2")
                    document.getElementById("leads-menu").style.left = "-2000px";
                    document.getElementById("routerIcon").style.left = "0";
                    this.show_routers = true;
                }else{
                     console.log("test3")
                    var menu_width = document.getElementById("leads-menu").offsetWidth;
                    var icon_width = document.getElementById("routerIcon").offsetWidth;
                    document.getElementById("leads-menu").style.left = "0";
                    document.getElementById("routerIcon").style.left = menu_width;
                    this.show_routers = false;
                }
            }

        }
    }
</script>

<style scoped>
body > div > div > div.modal.is-active{
    z-index: 99999999;
}
.router-link-exact-active,.router-link-exact-active:hover{
  background-color:#b07d12;
}
#routerIcon{
    position: absolute;
    z-index: 999998;
    background-color: #b07d12;
    color: #000000;
    border-radius: 4px;
    padding: 5px;
    transition: all 0.7s;
    font-size: 1.6em !important;
    cursor: pointer;
}
#phoneInput{
    padding-right: 0;
}
#phoneInputWrapper .is-success{
    background-color: unset !important;
    border-color: #008d4c !important;
    border-radius: 4px !important;
}
.container.is-fluid {
    margin-left: 30px;
    margin-right: 30px;
}

.card-content {
    padding: 10px 10px 10px 10px;
}
.card-header {
    margin-bottom: 0 !important;
}
.modal-card-body {
    text-align: left;
}
.content figure:not(:last-child) {
    margin-bottom: .5em;
}

.navbar {
    margin-bottom: 0;
    border-bottom: 2px solid #f9d176;
}

.navbar .level{
    margin-bottom: 0;
}
html.has-navbar-fixed-top, body.has-navbar-fixed-top {
    padding-top: 6.25rem;
}
.content ul {
    margin-left: 0em;
    margin-top: 0em;
    border-bottom-width: 0px;
}
li.is-active {
    background: #b07d12;
}
li.is-active a {
    color : #ffff !important;
    border-bottom-color: #b07d12;
}

.tabs a {
    border-bottom-width: 0px;
}
#leads-menu{
    width: 400px;
    position: absolute;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    background-color: #FFFFFF;
    z-index: 9999;
    transition: all 0.7s;
    border: 1px solid #c5c2c2;
    border-radius: 3px;
}
#leads-menu a{
    width: 100%;
    position: relative;
}

#leads-menu a{
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
}

#menu_info{
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header-num{
    float: right;
}
.menu_icons{
    color: #000000;
    padding-right: 5%;
}


@media screen and (max-width: 767px) {
    .header-content {
        display: block;
        padding-bottom: 1%;
    }

    .import-excel{
        display: none;
    }

    .leads-menu {
        display: grid;
        width: 100%!important;
    }
    #routerIcon{
        top:19%;
    }
    /* body > div > div > div.modal.is-active:nth-child(2){
        max-width: 90%!important;
    } */
}

/* @media screen and (min-width: 767px) {
    .fa-filter{
        display: none !important;
    }

} */
/* 
@media screen and (max-width: 767px) {
    .leads-menu{
        display: none;
    }

    .fa-filter,
    .fa-times{
        font-size: 1.2rem;
        margin-right: 4%;
    }

    .header-num{
        position: absolute;
        right: 7%;
    }

    .tabLinkActive,
    .tabLinkNotActive{
        font-size: 13px !important;
    }
} */
</style>
