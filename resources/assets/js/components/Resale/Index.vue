<template>
    <div class="container is-fluid">
                <div class="card ">
                    <header class="card-header level ">
                        <div class="level">
                            <div class="level-item">
                                <p class="card-header-title">
                                    All Units
                                </p>
                            </div>
                        </div>

                        <div class="level">
                            <div class="level-item">
                                <!-- <a class="button is-success is-meduim mr-10" href="/admin/xlsrequest" v-if="permArray['export_excel'] == 1 || userType == 'admin'">Import From Excel</a>
                                <a class="button is-success is-meduim mr-10" href="/admin/leads/create">Add</a>
                                <a @click="showAddLead = true" class="button is-success is-meduim mr-10">
                                    <span> Add new... </span>
                                </a>  -->
                                <router-link to="/admin/vue/uploadResale" class="button is-success is-meduim mr-10">Upload Resale Excel</router-link>
                                <router-link to="/admin/vue/createUnit" class="button is-success is-meduim mr-10">Create</router-link>
                            </div>
                        </div>
                        
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <b-tabs v-model="activeTab" class="block" is-mobile>
                             <!--  <Mass></Mass> -->
                                <b-tab-item label="Resale">
                                    <Unit v-if="activeTab == 0"></Unit>
                                </b-tab-item>

                                <b-tab-item label="Rental">
                                    <Rental v-if="activeTab == 1"></Rental>
                                </b-tab-item>

                            </b-tabs>
                        </div>
                    </div>

                </div>

    </div>
</template>

<script>

import Unit from './Unit'
import Rental from './Rental'
//import Mass from './Mass'

    export default {
        data() {
            return {
                activeTab: 0,
                activeTabActions: 0,
            }
        },
        mounted() {
            
        },
        components: {
            Unit:Unit,
            Rental:Rental,
           // Mass:Mass,
            
        },
        created() {
        },
        methods: {
            
            
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
