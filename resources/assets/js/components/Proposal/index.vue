<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Proposals
                        </p>
                    </div>
                </div>
                <div class="level">
                    <div class="level-item filters">
                        <div class="field  mr-10">
                        </div>            
                    </div>
                </div>
            </header>
            <div class="card-content">
                <div class="columns is-multiline" style="margin: 1rem 0">
                    <div class="column is-12 prop-main-div" style="justify-content: center;">
                        <div class="search_bar">
                            <b-autocomplete :open-on-focus="true" dir="ltr" rounded v-model="search" :data="Auto_Complete"
                                placeholder="Search By Name" icon="magnify">
                                <!-- @select="option => selected = option" -->
                                <template slot="empty">No results found</template>
                            </b-autocomplete>
                            <router-link to="/admin/vue/createProposal">
                                <i class="fas fa-plus"></i>
                            </router-link>
                        </div>
                        <div class="card-content">
                            <b-table :data="filteredArray" paginated backend-pagination :current-page="page" :total="total"
                                :per-page="perPage" @page-change="onPageChange" :pagination-simple="isPaginationSimple"
                                :default-sort-direction="defaultSortDirection" default-sort="id" aria-next-label="Next page"
                                aria-previous-label="Previous page" aria-page-label="Page" aria-current-label="Current page">
                                <template slot-scope="props" style="color: hotpink">

                                    <b-table-column field="id" label="ID" width="40" sortable numeric>
                                        {{ props.row.id }}
                                    </b-table-column>

                                    <b-table-column field="lead" label="lead" sortable>
                                        {{ props.row.first_name }} {{props.row.last_name}}
                                    </b-table-column>
                                    <b-table-column label="Actions">
                                        <div class="actions-icons">
                                            <router-link :to="'/admin/vue/showProposal/'+props.row.id">
                                                <i class="far fa-eye"></i>
                                            </router-link>
                                            <router-link :to="'/admin/vue/editProposal/'+props.row.id">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                            <i class="fas fa-trash" @click="deleteProposal(props.row)"></i>
                                        </div>
                                    </b-table-column>
                                    <b-table-column label="Confirm">
                                        <div class="actions-icons">
                                            <i v-if="props.row.status!= 'confirmed'" class="far fa-check-circle"
                                                @click='confirm(props.row)'></i>
                                            <i v-if="props.row.status == 'confirmed'" @click='confirm(props.row)'
                                                class="far fa-check-circle conf_green"></i>
                                        </div>
                                    </b-table-column>

                                    <!-- <b-table-column field="date" label="Date" sortable centered>
                            <span class="tag is-success">
                                {{ new Date(props.row.date).toLocaleDateString() }}
                            </span>
                        </b-table-column> -->

                                </template>
                                <template slot="empty">No results found</template>
                            </b-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        deleteProp,
        confirmProp,
        showProposal,
        editProposal,
        getAllProposalsWithPaginate
    } from "./../../calls";
    export default {
        data() {
            return {
                search: '',
                filter_proposals: [],
                selected: [],
                isLoading: true,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'asc',
                currentPage: 1,
                perPage: 10,
                allProposals: [],
                total: 0,
                page: 1,
                rowID:null,
            };
        },
        mounted() {
            this.getData();
        },
        computed: {
            filteredArray() {
                return this.allProposals.filter(option => {
                    var name = option.first_name+' '+option.last_name
                    return name.toString()
                        .toLowerCase()
                        .indexOf(this.search.toLowerCase()) >= 0
                })
            },
            Auto_Complete() {
                return this.filter_proposals.filter(option => {
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
                // this.allProposals = window.proposals;

                getAllProposalsWithPaginate(this.page)
                    .then(response => {
                        console.log(response);
                        this.allProposals = response.data.data;
                        this.filter_proposals = [];
                        for (let proposal of this.allProposals) {
                            this.filter_proposals.push(proposal.first_name + ' ' + proposal.last_name);
                        }
                        // console.log('deve', response.data.data)
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
            // deleteProposal(row) {
            //     this.isLoading = true
            //     if (confirm('Are you sure u want to delete ' + row.first_name + ' ' + row.last_name + '?')) {
            //         deleteProp(row.id).then(response => {
            //             // window.location = "/admin/vue/proposals";
            //             this.isLoading = false
            //             this.getData()
            //         })
            //     }
            // },
        deleteProposal(row) {
            this.rowID = row.id
            this.$dialog.confirm({
                title: 'Deleting ',
                message: 'Are you sure u want to delete ' + row.first_name + ' ' + row.last_name + '?',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleterop(this.rowID)
            })
        },
        deleterop(rowID){
            deleteProp(rowID).then(response => {
                // window.location = "/admin/vue/proposals";
                this.isLoading = false
                this.getData()
            })
        },
            // confirm(row) {
            //     confirmProp(row.id).then(response => {
            //         this.getData();
            //         if (row.status != 'confirmed') {
            //             this.$toast.open({
            //                 message: 'Confirmed',
            //                 type: 'is-success'
            //             })
            //         }else {
            //             this.$toast.open({
            //                 message: 'Unconfirm',
            //                 type: 'is-danger'
            //             })
            //         }
            //         console.log(this.allProposals, 'proop');
            //     })
            // }
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