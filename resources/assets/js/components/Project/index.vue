<template>

    <div class="container">
        <!-- <div class="control">
            <a class="button" :class="{ 'is-success': privacy == 'only_me' }"
                @click="privacy = 'only_me'; getData();">Me</a>
            <a class="button" :class="{ 'is-success': privacy == 'team_only' }"
                @click="privacy = 'team_only'; getData(); ">Team Only</a>
            <a class="button" :class="{ 'is-success': privacy == 'public' }"
                @click="privacy = 'public'; getData();">Public</a>
        </div> -->
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Projects
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <div class="columns is-multiline" style="margin: 1rem 0">
                    <div class="searchDiv column is-12" style="padding-top: 0; margin: 3px;" dir="rtl">

                        <b-autocomplete :open-on-focus="true" dir="ltr" rounded v-model="search" :data="searchData"
                            placeholder="Search By Name" icon="magnify">
                            <template slot="empty">No results found</template>
                        </b-autocomplete>

                    </div>
                    <div class="column is-3 filter-div">
                        <p class="filter-title"><i class="fas fa-filter"></i>filter</p>
                        <div class="columns is-multiline" style="margin: 0">
                            <div class="column is-12">
                                <b-field label="Developer">
                                    <b-select v-model="filter.developer">
                                        <option v-for="developer in allDevelopers" :key="developer.id" :value="developer.id">
                                            {{developer.name}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Min Price">
                                    <b-input v-model="filter.min_price" type="number" min="0"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Max Price">
                                    <b-input v-model="filter.max_price" type="number" min="0"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Min Area">
                                    <b-input v-model="filter.min_area" type="number" min="0"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Max Area">
                                    <b-input v-model="filter.max_area" type="number" min="0"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Min Down Payment">
                                    <b-input v-model="filter.min_down_payment" type="number" min="0"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Max Down Payment">
                                    <b-input v-model="filter.max_down_payment" type="number" min="0"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-12">
                                <b-field label="Installment Years">
                                    <b-select v-model="filter.installment_years">
                                        <option v-for="(year, index) in installment_yrs" :value="year">
                                            {{year}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-12">
                                <b-field label="Locations">
                                    <b-select v-model="filter.location">
                                        <option v-for="location in locations" :key="location.id" :value="location.id">
                                            {{location.en_name}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-12" style="text-align: center; margin: 1rem 0 0 0">
                                <b-button class="unit-filter-btn" @click='filterProjects'><i class="fas fa-filter"></i>
                                     filter
                                </b-button>
                            </div>
                        </div>
                    </div>
                    <div class="column is-9 unit-main-div">
                        <div class="columns is-multiline" style="margin: 0">
                            <div class="pro-card column is-4" v-for="project in filteredArray" :key="project.id">
                                <div class="columns is-multiline is-mobile" style="margin: 0">
                                    <div class="column is-12" style="padding-top: 0">
                                        <img class="resale-img" :src="'/uploads/' + project.cover">
                                    </div>
                                    <div class="column is-12">
                                        <div class="columns is-multiline is-mobile" style="margin: 0">
                                            <div class="column is-6">
                                                <img class="developer-logo-img" :src="'/uploads/'+ project.dev_logo">
                                            </div>
                                            <div class="column is-6" style="text-align: right; padding-right: 0.5rem">
                                                <img class="project-logo-img" :src="'/uploads/' + project.logo">
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-12" style="padding: 0 1rem 1rem 1rem;">
                                        <div class="columns is-multiline is-mobile unit-div-content" style="margin: 0">
                                            <div class="column is-3">
                                                <span class="unit-details">ID: <span
                                                        class="unit-details-value">{{ project.id }}</span></span>
                                            </div>
                                            <div class="column is-9">
                                                <span class="unit-details">Delivery Date: <span
                                                        class="unit-details-value">{{ project.delivery_date }}</span></span>
                                            </div>
                                            <div class="column is-12">
                                                <span class="unit-details">Number of phases: <span
                                                        class="unit-details-value">{{ project.phases }}</span></span>
                                            </div>
                                            
                                            <div class="column is-12">
                                                <span class="unit-details">Location: <span
                                                        class="unit-details-value">{{ project.locationName }}</span></span>
                                            </div>
                                            <!--<div class="column is-6">
                                                <span class="unit-details">Value Of Rent: <span
                                                        class="unit-details-value">{{ unit.value_of_rent }}EGP</span></span>
                                            </div>
                                            <div class="column is-6">
                                                <span class="unit-details">Delivery Date: <span
                                                        class="unit-details-value">{{ unit.delivery_date }}</span></span>
                                            </div>
                                            <div class="column is-12">
                                                <div class="columns is-multiline is-mobile unit-rooms" style="margin: 0">
                                                    <div class="column is-4">
                                                        <i class="fas fa-bed" style="font-size: 1.5rem"></i>
                                                        <br>
                                                        <span class="unit-rooms-value">{{ unit.rooms }}</span>
                                                    </div>
                                                    <div class="column is-4">
                                                        <i class="fas fa-bath" style="font-size: 1.5rem"></i>
                                                        <br>
                                                        <span class="unit-rooms-value">{{ unit.bathrooms }}</span>
                                                    </div>
                                                    <div class="column is-4">
                                                        <i class="fas fa-expand-arrows-alt" style="font-size: 1.5rem"></i>
                                                        <br>
                                                        <span class="unit-rooms-value">{{ unit.area }}m</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column is-12">
                                                <span class="unit-details">Entered By: <span
                                                        class="unit-details-value">{{ unit.user }}</span></span>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="column is-12 project-footer">
                                        <div class="columns is-multiline is-mobile" style="margin: 0">
                                            <div class="column is-6" style="display: grid">
                                                <router-link :to="'/admin/vue/showProject/' + project.id">
                                                    <b-button class="resale-btn" style="margin-bottom: 0.5rem">Read More</b-button>
                                                </router-link>
                                            </div>
                                            <div class="column is-6">
                                                <div class="columns is-multiline is-mobile footer-btns-div" style="margin: 0">
                                                    <div class="column is-4">
                                                        <router-link :to="'/admin/vue/showProject/' + project.id">
                                                            <b-button class="footer-btns"><i class="fas fa-eye"></i></b-button>
                                                        </router-link>
                                                    </div>
                                                    <div class="column is-4">
                                                        <router-link :to="'/admin/vue/editProject/' + project.id">
                                                            <b-button class="footer-btns"><i class="fas fa-edit"></i></b-button>
                                                        </router-link>
                                                    </div>
                                                    <div class="column is-4">
                                                        <b-button class="footer-btns" @click="ProjectActions('delete',project.id)"><i class="fas fa-trash"></i></b-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="column is-12 resale-footer">
                                        <div class="columns is-multiline is-mobile" style="margin: 0">
                                            <div class="column is-6" style="display: grid">
                                                <b-button class="resale-btn" style="margin-bottom: 0.5rem"
                                                    @click="showUnit(unit.id)">Read More</b-button>
                                                <b-button class="resale-btn">Request Ads</b-button>
                                            </div>
                                            <div class="column is-6">
                                                <div class="columns is-multiline is-mobile footer-btns-div" style="margin: 0">
                                                    <div class="column is-3">
                                                        <b-button class="footer-btns" @click="showUnit(unit.id)"><i
                                                                class="fas fa-eye"></i></b-button>
                                                    </div>
                                                    <div class="column is-3">
                                                        <b-button class="footer-btns" @click="editUnit(unit.id)"><i
                                                                class="fas fa-edit"></i></b-button>
                                                    </div>
                                                    <div class="column is-3">
                                                        <b-button class="footer-btns" @click="showUnit(unit.id)"><i
                                                                class="fab fa-think-peaks"></i></b-button>
                                                    </div>
                                                    <div class="column is-3">
                                                        <b-button class="footer-btns" @click="showUnit(unit.id)"><i
                                                                class="fas fa-home"></i></b-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <b-pagination style="margin-top: 1rem" @change="onPageChange" :total="total" :current.sync="current"
                            :order="order" :size="size" :simple="isSimple" :rounded="isRounded" :per-page="perPage"
                            aria-next-label="Next page" aria-previous-label="Previous page" aria-page-label="Page"
                            aria-current-label="Current page">
                        </b-pagination>
                        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<!--<template><div>{{ this.come }}</div></template>-->

<script>
    //export const myVar = 'This is my variable'
    import {
        getRental,
        getPublicData,
        newRentalFilter,
        getMyLeads,
        deleteRental,
        getAllDevelopers,
        getDevProjects,
        getDeveloperById,
        getAllProjectsWithPaginate,
        deleteProject,
        filterProjects
    } from './../../calls'

    export default {
        data() {
            return {
                installment_yrs: [],
                items: [],
                item: {
                    id: 0,
                    availability: '',
                    price: 0,
                    location: 0,
                    rooms: 0,
                    bathrooms: 0,
                    area: 0
                },

                ddisplay: true,
                unit_type: [],
                typee: '',
                locations: [],
                //project:{},
                page: parseInt(this.$route.params.page),
                newCallData: {
                    date: new Date()
                },
                leadsCurrentNumber: 0,
                leadsTotalNumber: 0,
                getLeadsByAgent: [],
                leadSources: [],
                units: [],
                isEmpty: false,
                isLoading: true,
                hasMobileCards: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                current: 1,
                order: '',
                size: '',
                isSimple: false,
                isRounded: false,
                page: 1,
                perPage: 10,
                isLoading: true,
                isFullPage: true,
                search: '',
                selectedLeads: [],
                ShowHint: false,
                hintId: '',
                callStatus: [],
                projects: [],
                meetingStatus: [],
                filter: {
                    developer: "",
                    min_price: null,
                    max_price: null,
                    min_area: null,
                    max_area: null,
                    min_down_payment: null,
                    max_down_payment: null,
                    installment_years: null,
                    location: ""
                },
                startFilter: false,
                switchLeadModel: false,
                bulkActionModel: false,
                switchLeadData: {},
                leadsIds: [],
                commercialAgents: [],
                residentialAgents: [],
                permArray: [],
                reloadData: false,
                types: ['personal', 'commercial'],
                privacy: 'only_me',
                allDevelopers: [],
                allProjects: [],
                developer: {},
                filter_projects: []

            }
        },
        created() {
            this.getPublic()
        },
        mounted() {
            if (this.ddisplay == false) {
                this.ddisplay = true
            } else {
                this.getData()
            }
            this.availableBgColor();
            this.getAllDevelopers();

        },
        computed: {
            filteredArray() {
                return this.allProjects.filter(option => {
                    return option.en_name
                        .toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            },
            searchData() {
                return this.filter_projects.filter(option => {
                    return option
                        .toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            }
        },        
        components: {
        },
        methods: {
            // getDevLogo(id){
            //     getDeveloperById(id)
            //         .then(response => {
            //             this.developer = response.data
            //             console.log(this.developer,'dev data');
            //         })
            //         .catch(error => {
            //             console.log(error);
            //         });
            //     return '/uploads/25912372851jpg';
            // },
            getAllDevelopers() {
                getAllDevelopers()
                    .then(response => {
                        this.allDevelopers = response.data;
                        console.log(this.allDevelopers, 'deve data');
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            availableBgColor(availability) {
                if (availability === 'available')
                    return 'green'
                else
                    return 'red'
            },
            getData(loading = true) {
                this.isLoading = loading;
                const filters = this.filter;
                var jsonDataFormat = {
                    "token": window.auth_user.token,
                    "user_id": window.auth_user.id,
                    "lang": "en",
                    "type": "personal",
                    "privacy": this.privacy,
                    "selection": "me",
                    filters,
                }
                getAllProjectsWithPaginate(this.page)
                    .then(response => {
                        this.allProjects = response.data.projects.data;
                        console.log("all proooojects",this.allProjects)
                        
                        this.installment_yrs = response.data.installment_years
                        this.filter_projects = [];
                        for (let project of this.allProjects) {
                            this.filter_projects.push(project.en_name);
                        }
                        this.perPage = response.data.per_page;
                        let currentTotal = response.data.total;
                        if (response.data.total / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000;
                        }
                        this.total = currentTotal;
                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            filterProjects() {
                this.isLoading = true
                //this.fitlerFlag = true
                var data = {
                    '_token': this.token,
                    'developer_id': this.filter.developer,
                    'min_price': this.filter.min_price,
                    'max_price': this.filter.max_price,
                    'min_area': this.filter.min_area,
                    'max_area': this.filter.max_area,
                    'min_down_payment': this.filter.min_down_payment,
                    'max_down_payment': this.filter.max_down_payment,
                    'installment_years': this.filter.installment_years,
                    'location': this.filter.location,
                };
                filterProjects(data).then(response => {
                    console.log(response)
                    this.allProjects = response.data.data;
                    this.perPage = response.data.per_page;
                    let currentTotal = response.data.total;
                    if (response.data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000;
                    }
                    this.total = currentTotal;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getPublic() {
                var data = {
                    'Unit': this.unit,
                };

                getPublicData(data).then(response => {

                        this.unit_type = response.data.unit_type
                        this.locations = response.data.locations
                        this.projects = response.data.projects
                        console.log("locaaaation",this.locations)
                        //this.types = response.data.types


                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            dateFormatterFrom(dt) {
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            showonlyme() {

            },
            dateFormatterTo(dt) {
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateTo = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            RentalActions(event, id) {
                var action = event.target.value
                if (action == 'show') {
                    window.location = "/admin/rental_units/" + id;
                } else if (action == 'edit') {
                    window.location = "/admin/rental_units/" + id + "/edit";
                } else if (action == 'delete') {
                    this.confirmDelete(id)
                }
            },
            confirmDelete(id) {
                this.$dialog.confirm({
                    title: 'Deleting Rental',
                    message: 'Are you sure you want to <b>delete</b> Rental Unit?',
                    confirmText: 'Delete Rental Unit',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteThisRental(id)
                })
            },
            deleteThisRental(id) {
                this.isLoading = true
                deleteRental(id).then(response => {
                        this.getData()
                        this.success('Deleted')
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            onPageChange(page) {
                this.page = page
                this.$router.replace({
                    name: "projects",
                    params: {
                        page: page
                    }
                })
                this.getData();
                // if (this.fitlerFlag) {
                //     this.filterLeads()
                // } else {
                //     this.getData()
                // }
            },
            setlocation(id) {
                let locationEnName = ''
                this.locations.forEach((item) => {
                    if (item.id == id) {
                        locationEnName = item.en_name
                    }
                })
                return locationEnName
            },
            setproject(id) {
                let proEnName = ''
                this.projects.forEach((item) => {
                    if (item.id == id) {
                        proEnName = item.en_name
                    }
                })
                return proEnName
            },
            ProjectActions(event, id){
                var action = event;
                if (action == "delete") {
                    this.confirmDelete(id);
                }
            },
            confirmDelete(id) {
                this.$dialog.confirm({
                    title: "Deleting Project",
                    message: "Are you sure you want to <b>delete</b> Project?",
                    confirmText: "Delete Project",
                    type: "is-danger",
                    hasIcon: true,
                    onConfirm: () => this.deleteThisProject(id)
                });
            },
            deleteThisProject(id) {
                this.isLoading = true;
                deleteProject(id)
                    .then(response => {
                        this.getData();
                        this.success("Deleted");
                    })
                    .catch(error => {
                    console.log(error);
                });
            },
        },
        filters: {
            jsontest($value) {
                return JSON.stringify($value);
            }
        }
    }
</script>

<style>
    .select,
    .select select {
        width: 100%;
    }
</style>

<style scoped>
    .pro-card {
        display: flex;
        flex-direction: column;
        /* width: 378.656px; */
        /* height: 638px; */
        justify-content: center;
        background: white;
        border: 1px solid #ddd;
        padding: 20px 20px;
        margin: 8px 0px 0px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .pro-card:hover {
        box-shadow: 0 8px 16px 0 rgba(5, 41, 158, 0.2);
        transform: scale(1.1);
        /* opacity: 0.5; */
    }

    .filter-title {
        font-size: 1.5rem;
        text-transform: uppercase;
    }

    .filter-div {
        border: 1.5px solid black;
        padding: 1rem;
        height: fit-content;
    }

    .unit-filter-btn i {
        margin-right: 0.5rem;
    }

    .unit-filter-btn {
        text-transform: uppercase;
        color: black;
        padding: 0.5rem 1rem;
    }

    .resale-img {
        width: 100%;
        height: 12rem;
    }

    .unit-details {
        font-weight: bold;
        text-transform: capitalize;
        font-size: 13px;
    }

    .unit-details:nth-child(even) {
        float: right;
        text-transform: capitalize;
    }

    .unit-details-value {
        font-weight: 500 !important;
        margin-left: 0.5rem;
        text-transform: capitalize;
    }

    .unit-div-content .is-6:nth-child(even) {
        padding-left: 0.5rem;
        margin-bottom: 0.5rem
    }

    .unit-rooms .column,
    .footer-btns-div {
        text-align: center
    }

    .resale-footer {
        border-top: 1px solid black;
        padding: 1rem 0.5rem;
    }

    .resale-btn {
        width: 7rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.25rem;
        text-align: center;
    }

    .footer-btns {
        border: unset !important;
        padding: unset !important;
    }

    .unit-main-div {
        padding: 0 2rem;
    }

    .project-logo-img {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        background: white;
        margin-top: -3rem;
        box-shadow: rgb(162, 154, 154) 5px 5px 20px 0px;
    }

    .developer-logo-img {
        width: 7rem;
        height: 7rem;
    }

    .unit-available {
        height: 1.5rem;
        width: 1.5rem;
        border-radius: 50%;
        float: right;
        margin: 1rem 2rem 0 0px;
    }

    .spinner {
        position: relative;
    }

    .double-bounce1,
    .double-bounce2 {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        opacity: 0.6;
        position: absolute;
        top: 0;
        left: 0;
        -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
        animation: sk-bounce 2.0s infinite ease-in-out;
    }

    .double-bounce2 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }
    .project-footer{
        border-top: 1px solid black;
        padding: 1rem 0.5rem;
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