<template>
    <div class="container is-fluid">
        <Header />
                <div class="card ">
                    <header class="card-header level ">
                        <div class="level">
                            <div class="level-item">
                                <p class="card-header-title">
                                    All Leads
                                </p>
                            </div>
                        </div>

                    </header>
                    <div class="card-content">
                        <div class="content">
                            <b-tabs v-model="activeTab" class="block" is-mobile>
                                <b-tab-item label="My Leads">
                                    <MyLeads v-if="activeTab == 0"></MyLeads>
                                </b-tab-item>

                                <b-tab-item label="Individual Leads">
                                <MyLeads v-if="activeTab == 1"></MyLeads>
                                </b-tab-item>

                                <b-tab-item label="Team Leads">
                                Team Leads
                                </b-tab-item>

                                <b-tab-item label="Hot Leads">
                                Hot Leads
                                </b-tab-item>

                                <b-tab-item label="Favorite Leads">
                                Favorite Leads
                                </b-tab-item>

                            </b-tabs>
                        </div>
                    </div>
                </div>
            <Footer />
    </div>
</template>

<script>
import MyLeads from './MyLeads'
import Header from './../layout/Header'
import Footer from './../layout/Footer'

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
            Header: Header,
            Footer: Footer,
            MyLeads
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
