<template>
        <div class="container" style="text-align:center">
            <div class="column is-12 dev-main-div" style="justify-content: center;">
                <div class="columns is-multiline" style="justify-content: center;">
                    <div class="searchDiv column is-12" style="padding-top: 0; margin: 3px;" dir="rtl">

                        <b-autocomplete :open-on-focus="true" dir="ltr" rounded v-model="search"
                            placeholder="Search By Name" icon="magnify">
                            <!-- @select="option => selected = option" -->
                            <!-- <template slot="empty">No results found</template> -->
                        </b-autocomplete>
                    </div>
                    <!-- begin card -->
                    <div v-for="i in filteredList" :key="i.name">
                            <div class="deve-card column is-3" style="padding-top: 0;">
                                <ul class="deve-icon">
                                    <li><a><router-link :to="i.url" class="far fa-eye"></router-link></a></li>
                                </ul>
                                <div class="columns is-multiline is-mobile" style="margin: 0">
                                    <div class="column is-12" style="padding-top: 0">
                                        <p><span :class="i.classFont"></span></p>
                                    </div>
                                    <div class="column is-12 dev-footer">
                                        <div class="columns is-multiline is-mobile" style="margin: 0">
                                            <div class="column is-12" style="display: grid">
                                                <b-button class="dev-btn">{{ i.show }}</b-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
            return {
                all_items:[
                    {name:'icons',show:'Icons',classFont:'fa fa-icons',url:'/admin/vue/Icons'},
                    {name:'groups',show:'Groups',classFont:'fa fa-users',url:'/admin/vue/groups'},
                    {name:'unit_type',show:'Unit type',classFont:'fa fa-city',url:'/admin/vue/Unit_type'},
                    {name:'role',show:'Roles',classFont:'fa fa-award',url:'/admin/vue/Roles'},
                    {name:'website',show:'Website',classFont:'fa fa-at',url:'/admin/vue/websiteView'},
                    {name:'lead source',show:'Lead Source',classFont:'fa fa-user',url:'/admin/vue/leadSource'},
                    {name:'agents',show:'Agents',classFont:'fa fa-users',url:'/admin/vue/agents'},
                    {name:'reports',show:'Reports',classFont:'fa fa-id-card',url:'/admin/vue/dailyReport'},
                    {name:'agent types',show:'Agent Types',classFont:'fa fa-id-card',url:'/admin/vue/agent_type'},
                    {name:'tasks',show:'Tasks',classFont:'fa fa-tasks',url:'/admin/vue/task'},
                    {name:'facilities',show:'Facilities',classFont:'fa fa-bars',url:'/admin/vue/facilities'},
                    {name:'competitors',show:'competitors',classFont:'fa fa-handshake',url:'/admin/vue/competitors'},
                    {name:'tags',show:'Tags',classFont:'fa fa-tags',url:'/admin/vue/tags'},
                    {name:'titles',show:'Titles',classFont:'fa fa-address-book',url:'/admin/vue/titles'},
                    {name:'outcome category',show:'Outcome Category',classFont:'fa fa-money',url:'/admin/vue/outcome_category'},
                    {name:'Outcome Sub-Category',show:'Outcome Sub-Category',classFont:'fa fa-money',url:'/admin/vue/sub_categories'},
                    {name:'action logs',show:'Action Logs',classFont:'fa fa-exchange',url:'/admin/vue/action_logs'},
                    {name:'meeting status',show:'Meeting Status',classFont:'fa fa-handshake-o',url:'/admin/vue/meeting_status'},
                    {name:'Target',show:'Target',classFont:'fa fa-line-chart',url:'/admin/vue/target'},
                    {name:'call status',show:'call status',classFont:'fa fa-phone',url:'/admin/vue/callstatus'},
                    {name:'pusher',show:'pusher',classFont:'fa fa-upload',url:'/admin/vue/pusher'},
                    {name:'Lead Summaries',show:'Lead Summaries',classFont:'fa fa-list-alt',url:'/admin/vue/LeadSummaries'},
                    {name:'Duplicated Leads',show:'Duplicated Leads',classFont:'fa fa-list-alt',url:'/admin/vue/DuplicatedLeads'},
                    {name:'Locations',show:'Locations',classFont:'fa fa-map-marker',url:'/admin/vue/Locations'},
                    {name:'Filter And Delete Leads',show:'Filter And Delete Leads',classFont:'fa fa-trash',url:'/admin/vue/filterLeadsToDelete'},
                    {name:'Cil Mail Settings',show:'Cil Mail Settings',classFont:'fa fa-tasks',url:'/admin/vue/cils_mail_settings'},
                    {name:'onesignal settings',show:'onesignal settings',classFont:'fa fa-bell',url:'/admin/vue/onesignal'},
                    {name:'archive',show:'archive',classFont:'fa fa-archive',url:'/admin/archive#/show/1'},
                ],
                search: '',
                filter_deve: [],
                searchInput: "",
            }
    },
        computed: {
            filteredList() {
                    if(this.search === '') return this.all_items
                return this.all_items.filter(entry => {
                    return entry.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
            Auto_Complete() {
                return this.all_items.filter(option => {
                    return option.name
                        .toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            }
        },
}
</script>


<style>
    .select,
    .select select {
        width: 100%;
    }
</style>

<style scoped>
    .deve-card {
        display: flex;
        flex-direction: column;
        width: 280px;
        height: 320px;
        justify-content: center;
        background: white;
        border: 1px solid #ddd;
        padding: 20px 20px;
        margin: 3px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        z-index: 2;
    }
    .icon-style{
        font-size:30px;
    }

    .deve-card:hover {
        box-shadow: 0 8px 16px 0 rgba(5, 41, 158, 0.2);
        transform: scale(1.1);
        opacity: 0.5;
    }

    .deve-icon {
        display: flex;
        justify-content: center;
        position: relative;
        top: 40%;
        z-index: 3;
        opacity: 0;
    }

    .deve-card:hover .deve-icon {
        opacity: 2;
    }

    .deve-icon li a {
        position: relative;
        display: block;
        width: 50px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        background: #fff;
        color: #262626;
        margin: 0 5px;
        border-radius: 50%;
        z-index: 3;
    }

    .deve-icon li a:hover {
        color: blue;
    }

    .deve-icon li a i {
        transition: 0.5s;
        font-size: 24px;
        line-height: 50px;
    }

    .deve-icon li a:hover i {
        transform: rotateY(360deg);
    }

    .searchDiv {
        display: flex;
        justify-content: center;
        padding: 20px 20px;
        margin: 3px;
    }

    .pagination-dev {
        margin-left: 2rem;
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }



    .dev-img {
        height: 12rem;
        margin: 10px;
        align-self: center;
    }



    .dev-footer {
        border-top: 1px solid black;
        padding: 1rem 0.5rem;
    }

    .dev-btn {
        /* width: 7rem; */
        text-transform: uppercase;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.25rem;
        text-align: center;
        border: 1px solid #9e6900 !important;
    }


    .dev-main-div {
        padding: 0 3rem;
    }
    .fas{
        font-size: 30px;
    }


    @-webkit-keyframes sk-bounce {

        0%,
        100% {
            -webkit-transform: scale(0.0)
        }

        50% {
            -webkit-transform: scale(1.0)
        }
    }

    @keyframes sk-bounce {

        0%,
        100% {
            transform: scale(0.0);
            -webkit-transform: scale(0.0);
        }

        50% {
            transform: scale(1.0);
            -webkit-transform: scale(1.0);
        }
    }
</style>