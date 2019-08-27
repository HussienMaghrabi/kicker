<template>
    <div class="container is-fluid">
        <Header />
                <div class="card " v-if="showTabs">
                    <header class="card-header level ">
                        <div class="level">
                            <div class="level-item">
                                <p class="card-header-title">
                                    All Leads
                                </p>
                            </div>
                        </div>

                        <div class="level">
                            <div class="level-item">
                                <a class="button is-success is-meduim mr-10" href="/admin/xlsrequest" v-if="permArray['export_excel'] == 1 || userType == 'admin'">Export</a>
                                <a class="button is-success is-meduim mr-10" href="/admin/leads/create">Add</a>
                            </div>
                        </div>
                        
                    </header>
                    <div class="card-content">
                        <div class="content cardContentHeight">
                            <b-tabs v-model="activeTab" class="block" v-if="showTabs && userType == 'admin'">
                                <b-tab-item label="My Leads">
                                    <MyLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 0"></MyLeads>
                                </b-tab-item>

                                <b-tab-item label="Individual Leads">
                                    <IndividualLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 1"></IndividualLeads>
                                </b-tab-item>

                                <b-tab-item label="Team Leads">
                                    <TeamLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 2"></TeamLeads>
                                </b-tab-item>

                                <b-tab-item label="Hot Leads">
                                    <HotLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 3"></HotLeads>
                                </b-tab-item>

                                <b-tab-item label="Favorite Leads">
                                    <FavoriteLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 4"></FavoriteLeads>
                                </b-tab-item>

                            </b-tabs>
                            <b-tabs v-model="activeTab" class="block" v-if="showTabs && teamLeader == 1">
                                <b-tab-item label="My Leads">
                                    <MyLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 0"></MyLeads>
                                </b-tab-item>

                                <b-tab-item label="Team Leads">
                                    <TeamLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 1"></TeamLeads>
                                </b-tab-item>

                                <b-tab-item label="Hot Leads">
                                    <HotLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 2"></HotLeads>
                                </b-tab-item>

                                <b-tab-item label="Favorite Leads">
                                    <FavoriteLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 3"></FavoriteLeads>
                                </b-tab-item>

                            </b-tabs>
                            <b-tabs v-model="activeTab" class="block" v-if="showTabs && userType != 'admin' && teamLeader != 1">
                                <b-tab-item label="My Leads">
                                    <MyLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 0"></MyLeads>
                                </b-tab-item>

                                <b-tab-item label="Hot Leads">
                                    <HotLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 1"></HotLeads>
                                </b-tab-item>

                                <b-tab-item label="Favorite Leads">
                                    <FavoriteLeads :residentialAgents='residentialAgents' :commercialAgents='commercialAgents' :permArray="permArray" v-if="activeTab == 2"></FavoriteLeads>
                                </b-tab-item>

                            </b-tabs>
                        </div>
                    </div>
                </div>
            <Footer />
            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </div>
</template>

<script>
import {getAgents,checkUserGroupAndRoles} from './../../calls'
import MyLeads from './MyLeads'
import IndividualLeads from './IndividualLeads'
import TeamLeads from './TeamLeads'
import HotLeads from './HotLeads'
import FavoriteLeads from './FavoriteLeads'

import Header from './../layout/Header'
import Footer from './../layout/Footer'

    export default {
        data() {
            return {
                activeTab: 0,
                activeTabActions: 0,
                commercialAgents: [],
                residentialAgents: [],
                userType: window.auth_user.type,
                id: window.auth_user.id,
                teamLeader: 0,
                showTabs: false,
                isFullPage: true,
                isLoading: true,
                permArray: [],
            }
        },
        components: {
            Header: Header,
            Footer: Footer,
            MyLeads,
            IndividualLeads,
            TeamLeads,
            HotLeads,
            FavoriteLeads
        },
        mounted () {
            this.checkUserHasGroup()
            this.getCompanyAgents()
        },
        methods: {
            getCompanyAgents(){
                getAgents().then(response=>{
                    console.log(response)
                    this.commercialAgents = response.data.commercialAgents
                    this.residentialAgents = response.data.residentialAgents
                })
                .catch(error => {
                    console.log(error)
                })
            },
            checkUserHasGroup(){
                checkUserGroupAndRoles().then(response=>{
                    console.log(response)
                    this.teamLeader = response.data.leaderHasGroup
                    this.permArray = response.data.permArray
                    this.isLoading = false
                    this.showTabs = true
    
                })
                .catch(error => {
                    console.log(error)
                })
            },

        }
    }
</script>

<style>
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
</style>
