<template>
    <div>

        <div class="columns is-multiline" style="margin: 1rem 0">
            <div class="column is-12 dev-main-div" style="justify-content: center;">
                <div class="columns is-multiline" style="justify-content: center;">
                    <div class="searchDiv column is-12" style="padding-top: 0; margin: 3px;" dir="rtl">

                        <b-autocomplete :open-on-focus="true" dir="ltr" rounded v-model="search" :data="Auto_Complete"
                            placeholder="Search By Name" icon="magnify">
                            <!-- @select="option => selected = option" -->
                            <template slot="empty">No results found</template>
                        </b-autocomplete>

                         <b-button type="is-info">
                                
                                <router-link :to="'/admin/vue/addDeveloper'" style="color:#fff;"> 
                                        Add
                                </router-link>
                        </b-button><br>

                    </div>
                    <div class="deve-card column is-3" style="padding-top: 0" v-for="dev in filteredArray"
                        :key="dev.id">
                        <p>{{ dev.id }}</p>
                        <ul class="deve-icon">
                            <li>
                                <router-link :to="'/admin/vue/developers/'+dev.id">
                                    <a><i class="far fa-eye"></i></a>
                                </router-link>
                            </li>
                            <li><a><i class="fas fa-trash" @click="deleteDev(dev)"></i></a></li>
                        </ul>
                        <div class="columns is-multiline is-mobile" style="margin: 0">
                            <div class="column is-12" style="padding-top: 0;max-height: 100%;display: flex;justify-content: center;">
                                <img :src="'/uploads/'+dev.logo" class="dev-img far fa-user" style="max-width:100%;max-height: 100%" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination-dev column is-12">
                <b-pagination @change="onPageChange" :total="total" :current.sync="current" :order="order" :size="size"
                    :simple="isSimple" :rounded="isRounded" :per-page="perPage" aria-next-label="Next page"
                    aria-previous-label="Previous page" aria-page-label="Page" aria-current-label="Current page">
                </b-pagination>
            </div>
            <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
        </div>

    </div>
</template>

<script>
    import {
        deleteResale,
        getAllDevelopersWithPaginate,
        searchForDevelopers,
        deleteDeveloper
    } from "./../../calls";
    export default {
        data() {
            return {
                filter_deve: [],
                search: '',
                selected: null,
                token: window.auth_user.csrf,
                page: parseInt(this.$route.params.page),
                isLoading: true,
                isPaginated: true,
                total: 0,
                current: 1,
                order: '',
                size: '',
                isFullPage: true,
                isSimple: false,
                isRounded: false,
                page: 1,
                perPage: 10,
                searchInput: "",
                allDevelopers: []
            };
        },
        computed: {
            filteredArray() {
                return this.allDevelopers.filter(option => {
                    return option.name
                        .toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            },
            Auto_Complete() {
                return this.filter_deve.filter(option => {
                    return option
                        .toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            }
        },
        mounted() {
            this.getData();
        },
        components: {
        },
        methods: {
            find_dev() {
                if (this.search) {
                    //this.isLoading = true
                    var data = {
                        'searchInput': this.search,
                        '_token': this.token
                    };
                    searchForDevelopers(data).then(response => {
                            this.allDevelopers = response.data
                            this.filter_deve = [];
                            for (let dev of this.allDevelopers) {
                                this.filter_deve.push(dev.name);
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        })
                } else if (this.search.trim() === "") {
                    this.getData();
                }
            },
            getData(loading = true) {
                this.isLoading = loading;
                getAllDevelopersWithPaginate(this.page)
                    .then(response => {
                        console.log(response)
                        this.allDevelopers = response.data.data;
                        this.filter_deve = [];
                        for (let dev of this.allDevelopers) {
                            this.filter_deve.push(dev.name);
                        }
                        console.log('deve', response.data.data)
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
            showDev(id) {
                window.location = "/admin/developers/" + id;
            },
            editDev(id) {
                window.location = "/admin/developers/" + id + "/edit";
            },
            deleteDev(dev) {
                this.confirmDeleteDev(dev)
                // if (confirm('Are you sure u want to delete ' + dev.name + '?')) {
                //     deleteDeveloper(dev.id).then(response => {
                //         window.location = "/admin/developers";
                //     })
                // }
            },
            confirmDeleteDev(dev) {
                this.$dialog.confirm({
                    title: 'Deleting Developer',
                    message: 'Are you sure you want to <b>delete</b> '+dev.name+ ' ?',
                    confirmText: 'Delete Developer',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deleteDeveloper(dev.id)
                })
            },
            deleteDeveloper(devID){
                deleteDeveloper(devID).then(response => {
                    this.success('Deleted')
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog('Something went wrong please try again later')
                    console.log(error)
                })
            },
            errorDialog(msg) {
                this.$dialog.alert({
                    title: 'Error',
                    message: msg,
                    type: 'is-danger',
                })
            },
            success(action) {
                this.$toast.open({
                    message: 'Developer '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
            // ResaleActions(event, id) {
            //     var action = event.target.value;
            //     if (action == "show") {
            //         window.location = "/admin/resale_units/" + id;
            //     } else if (action == "edit") {
            //         window.location = "/admin/resale_units/" + id + "/edit";
            //     } else if (action == "delete") {
            //         this.confirmDelete(id);
            //     }
            // },
            // showUnit(id) {
            //     window.location = "/admin/resale_units/" + id;
            // },
            // editUnit(id) {
            //     window.location = "/admin/resale_units/" + id + "/edit";
            // },
            // confirmDelete(id) {
            //     this.$dialog.confirm({
            //         title: "Deleting Resale",
            //         message: "Are you sure you want to <b>delete</b> Resale Unit?",
            //         confirmText: "Delete Resale Unit",
            //         type: "is-danger",
            //         hasIcon: true,
            //         onConfirm: () => this.deleteThisResale(id)
            //     });
            // },
            // deleteThisResale(id) {
            //     this.isLoading = true;
            //     deleteResale(id)
            //         .then(response => {
            //             this.getData();
            //             this.success("Deleted");
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
        }
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
        height: 250px;
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
        overflow: hidden!important;
    }


    .dev-main-div {
        padding: 0 3rem;
    }

    .button.is-info{
        margin-right: 5%;
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
