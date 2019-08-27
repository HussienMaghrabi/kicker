<template>
    <div>
        <div class="columns is-multiline" style="margin: 1rem 0">
            <div class="column is-12 prop-main-div" style="justify-content: center;">
                <div class="search_bar">
                    <b-autocomplete :open-on-focus="true" dir="ltr" rounded v-model="search" :data="filteredArray"
                        placeholder="Search By Name" icon="magnify" @input="find_dev">
                        <!-- @select="option => selected = option" -->
                        <template slot="empty">No results found</template>
                    </b-autocomplete>
                    <router-link to="/admin/vue/createDeal">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>
                <div class="card-content">
                    <b-table :data="allDeals" paginated backend-pagination :current-page="page" :total="total"
                        :per-page="perPage" @page-change="onPageChange" :pagination-simple="isPaginationSimple"
                        :default-sort-direction="defaultSortDirection" default-sort="id" aria-next-label="Next page"
                        aria-previous-label="Previous page" aria-page-label="Page" aria-current-label="Current page">
                        <template slot-scope="props" style="color: hotpink">

                            <b-table-column field="id" label="ID" width="40" sortable numeric>
                                {{ props.row.id }}
                            </b-table-column>
                            <b-table-column field="buyer" label="Buyer" sortable>
                                {{ props.row.buyer_first_name }} {{props.row.buyer_last_name}}
                            </b-table-column>
                            <b-table-column field="seller" label="Seller" sortable>
                                {{ props.row.seller_first_name }} {{props.row.seller_last_name}}
                            </b-table-column>
                            <b-table-column field="unit-type" label="Unit Type" sortable>
                                {{ props.row.unit_type }}
                            </b-table-column>
                            <b-table-column label="Action">
                                <div class="actions-icons">

                                      <router-link :to="'/admin/vue/showDeals/'+props.row.id">
                                              <i class="far fa-eye"></i>
                                      </router-link>

                                     <!-- <i class="far fa-eye" @click="showDeal(props.row)"></i> -->
                                    <i class="fas fa-trash" @click="deleteConfirm(props.row)"></i>
                                </div>
                            </b-table-column>

                        </template>
                        <template slot="empty">No results found</template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        showDeal,
        getAllDealsWithPaginate,
        DeleteDeal
    } from "./../../calls";
    export default {
        data() {
            return {
                search: '',
                filter_deve: [],
                selected: [],
                isLoading: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'asc',
                currentPage: 1,
                perPage: 10,
                allDeals: [],
                total: 0,
                page: 1,
            };
        },
        mounted() {
            this.getData();
            if (localStorage.getItem('Add Deal')) {
                this.$toast.open({
                    message: 'Deal has been Created',
                    type: 'is-success'
                })
                localStorage.removeItem('Add Deal');
            }
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
        components: {
        },
        methods: {
            getData(loading = true) {
                this.isLoading = loading;


                getAllDealsWithPaginate(this.page)
                    .then(response => {
                        console.log('deals', response);
                        this.allDeals = response.data.data;
                        for (let i = 0; i < this.allDeals.length; i++) {
                            if (this.allDeals[i].unit_type == 'rental') {
                                this.allDeals[i].unit_type = 'Rental'

                            }
                            if (this.allDeals[i].unit_type == 'resale') {
                                this.allDeals[i].unit_type = 'Resale'
                            }
                            if (this.allDeals[i].unit_type == 'new_home') {
                                this.allDeals[i].unit_type = 'New Home'
                            }
                            if (this.allDeals[i].unit_type == 'land') {
                                this.allDeals[i].unit_type = 'Land'
                            }
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
            onPageChange(page) {
                this.page = page
                var url = window.location.href.split("/");
                url[url.length - 1] = '' + page
                window.location.href = url.join('/');
                this.getData()
            },
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
                                this.filter_deve.push(dev.en_name);
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        })
                } else if (this.search.trim() === "") {
                    this.getData();
                }
            },
            showDeal(row) {
                showDeal(row.id).then(response => {
                    console.log(response);
                })
                window.location = "/admin/deals/" + row.id;
            },
            deleteConfirm(row) {
                this.$dialog.confirm({
                    title: "Deleting Resale",
                    message: "Are you sure you want to <b>delete</b> this Deal?",
                    confirmText: "Delete Deal",
                    type: "is-danger",
                    hasIcon: true,
                    onConfirm: () => this.deleteDeal(row.id)
                });
            },
            deleteDeal(id) {
                DeleteDeal(id).then(response => {
                    this.getData();
                    this.$toast.open({
                        message: 'Deal has been Deleted',
                        type: 'is-danger'
                    })
                    console.log(response);
                })
            },
            createDeal() {
                window.location = "/admin/deals/create";
            }
        }
    };
</script>


<style scoped>
    .search_bar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }

    .search_bar i {
        cursor: pointer;
        font-size: 24px;
        color: lightgreen;
        margin: 0px 15px;
        margin-top: 5px;
    }

    .search_bar i:hover {
        color: green;
    }

    .actions-icons i {
        cursor: pointer;
        margin-right: 2rem;
        font-size: 20px;
    }

    .actions-icons i:nth-child(1):hover {
        color: lightgreen;
    }

    .actions-icons i:nth-child(2):hover {
        color: orange;
    }

    .actions-icons i:nth-child(3):hover {
        color: red;
    }

    /* .actions-icons i:nth-child(4):hover {
        color: #00C851;
    } */

    .conf_green {
        color: #00C851;
        /* cursor: default !important; */
    }
</style>