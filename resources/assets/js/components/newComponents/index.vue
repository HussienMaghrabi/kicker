<template>
    <div>
        <Header />
        hello
        <Footer />
    </div>
</template>

<script>
    import {
        getPublicData,
        newResaleFilter,
        getResales,
        deleteResale,
        getAllDevelopers
    } from "./../../calls";
    import Header from '../Layout/Header'
    import Footer from '../Layout/Footer'
    export default {
        data() {
            return {
                filter_deve:[],
                search: '',
                selected: null,
                isImageModalActive: false,
                isCardModalActive: false,
                unit_type: [],
                typee: "",
                locations: [],
                //location:{},
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
                defaultSortDirection: "desc",
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
                searchInput: "",
                selectedLeads: [],
                ShowHint: false,
                hintId: "",
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
                    location: "",
                    typee: "",
                    project: "",
                    unit_typee: "",
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
                privacy: "only_me",
                area: 0,
                allDevelopers: []
            };
        },
        computed: {
            filteredArray() {
                return this.filter_deve.filter((option) => {
                    return option
                        .toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            }
        },
        mounted() {
            this.getPublic();
            this.getData();
            this.availableBgColor();
            // this.getAllDevelopers();
        },
        components: {
            Header: Header,
            Footer: Footer,
        },
        methods: {
            availableBgColor(availability) {
                if (availability === 'available')
                    return 'green'
                else
                    return 'red'
            },
            find_dev(option){
                console.log('hello',option);
            },
            filteredDataArray() {

            },
            filtersChanged() {
                this.getData();
            },
            getData(loading = true) {
                this.isLoading = loading;
                getAllDevelopers(this.page)
                    .then(response => {
                        this.allDevelopers = response.data.data;
                        for(let dev of this.allDevelopers){
                            this.filter_deve.push(dev.en_name);
                        }
                        console.log('deve', response.data.data)
                        this.perPage = response.data.per_page;
                        this.leadsCurrentNumber = this.units.length;
                        this.leadsTotalNumber = response.data.total;
                        if (this.units.length == 0) {
                            this.isEmpty = true;
                        }
                        let currentTotal = response.data.total;
                        if (response.data.total / this.perPage > 1000) {
                            currentTotal = this.perPage * 1000;
                        }
                        this.total = currentTotal;
                        this.isLoading = false;
                        this.getPublic();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getPublic() {
                getPublicData()
                    .then(response => {
                        //console.log(this.projects)
                        this.unit_type = response.data.unit_type;
                        this.locations = response.data.locations;
                        this.projects = response.data.projects;
                        //this.types = response.data.types
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            dateFormatterFrom(dt) {
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split("/");
                this.parsedDateFrom = `${year}-${month.padStart(2, "0")}-${day.padStart(
                2,
                "0"
              )}`;
                return date;
            },
            dateFormatterTo(dt) {
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split("/");
                this.parsedDateTo = `${year}-${month.padStart(2, "0")}-${day.padStart(
                2,
                "0"
              )}`;
                return date;
            },
            ResaleActions(event, id) {
                var action = event.target.value;
                if (action == "show") {
                    window.location = "/admin/resale_units/" + id;
                } else if (action == "edit") {
                    window.location = "/admin/resale_units/" + id + "/edit";
                } else if (action == "delete") {
                    this.confirmDelete(id);
                }
            },
            showUnit(id) {
                window.location = "/admin/resale_units/" + id;
            },
            editUnit(id) {
                window.location = "/admin/resale_units/" + id + "/edit";
            },
            confirmDelete(id) {
                this.$dialog.confirm({
                    title: "Deleting Resale",
                    message: "Are you sure you want to <b>delete</b> Resale Unit?",
                    confirmText: "Delete Resale Unit",
                    type: "is-danger",
                    hasIcon: true,
                    onConfirm: () => this.deleteThisResale(id)
                });
            },
            deleteThisResale(id) {
                this.isLoading = true;
                deleteResale(id)
                    .then(response => {
                        this.getData();
                        this.success("Deleted");
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            // getAllDevelopers() {
            //     getAllDevelopers()
            //         .then(response => {
            //             this.allDevelopers = response.data;
            //             console.log(this.allDevelopers);
            //         })
            //         .catch(error => {
            //             console.log(error);
            //         });
            // },
            onPageChange(page) {
                this.page = page;
                this.$router.replace({
                    name: "developers",
                    params: {
                        page: page
                    }
                });
                this.getData();
            },
            setlocation(id) {
                let locationEnName = "";
                this.locations.forEach(item => {
                    if (item.id == id.id) {
                        locationEnName = item.en_name;
                    }
                });
                return locationEnName;
            },
            setproject(id) {
                let proEnName = "";
                this.projects.forEach(item => {
                    if (item.id == id) {
                        proEnName = item.en_name;
                    }
                });
                return proEnName;
            }
        },
        watch: {
            "filter.from": function () {
                this.filtersChanged();
            },
            "filter.to": function () {
                this.filtersChanged();
            }
        },
    };
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
        z-index: 2;
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
        height: 12rem;
        margin: 10px;
        align-self: center;
    }

    .unit-details {
        font-weight: bold;
        text-transform: capitalize;
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
        /* width: 7rem; */
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
        padding: 0 3rem;
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

<style>
    .mydivouter {
        position: relative;
        background: #f90;
        width: 200px;
        height: 120px;
        margin: 0 auto;
    }

    .mydivoverlap {
        position: relative;
        z-index: 1;
    }

    .mybuttonoverlap {
        position: absolute;
        z-index: 2;
        top: 44px;
        display: none;
        left: 59px;
    }

    .mydivouter:hover .mybuttonoverlap {
        display: block;
    }
</style>
<div class="mydivouter">
    <input type="button" class="mybuttonoverlap btn btn-info" value="Read More" />
</div>