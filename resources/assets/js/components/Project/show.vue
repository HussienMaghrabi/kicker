<template>

    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Project Info
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                        <div class="container">
                            <div class="owl-carousel owl-theme">
                                 <!-- <carousel>
                                    <div v-for="photo in projectGallery" class="item">
                                        <img :src="'/uploads/'+photo.image" alt="Los Angeles" style="width:100%;">
                                    </div>
                                </carousel> -->
                                <carousel :per-page="1" :navigationEnabled="true" :paginationEnabled="true" :autoplay="true" :loop="true">
                                    <slide style="padding-top: 1%;" v-for="photo in projectGallery" :key="photo.id">
                                        <img :src="'/uploads/' + photo.image" style="height: 100%; width: 100%;" alt="Image Not Found">
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                        <div class="column is-12">
                            <b><label>ID: </label></b>
                            <span>{{ project.id }}</span>
                            <hr>
                        </div>
                        <div class="column is-6">
                            <b><label>English Name: </label></b>
                            <span>{{ project.en_name }}</span>
                            <hr>
                        </div>
                        <div class="column is-6">
                            <b><label>Arabic Name: </label></b>
                            <span>{{ project.ar_name }}</span>
                            <hr>
                        </div>
                        <div class="column is-12">
                            <b><label>English Description: </label></b>
                            <span>{{ project.en_description }}</span>
                            <hr>
                        </div>
                        <div class="column is-12">
                            <b><label>Arabic Description: </label></b>
                            <span>{{ project.ar_description }}</span>
                            <hr>
                        </div>
                        <div class="column is-4">
                            <b><label>Price / Meter : </label></b>
                            <span>{{ project.meter_price }}</span>
                            <hr>
                        </div>
                        <div class="column is-4">
                            <b><label>Area : </label></b>
                            <span>{{ project.area }} </span>
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <span>{{ project.area_to }} </span>
                            <hr>
                        </div>
                        <div class="column is-4">
                            <b><label>Developer : </label></b>
                            <span>{{ project.developerName }}</span>
                            <hr>
                        </div>
                        <div class="column is-6">
                            <b><label>Logo : </label></b>
                            <div id="logo">
                                <img :src="'/uploads/'+project.logo" />
                            </div>
                            <hr>
                        </div>
                        <div class="column is-6">
                            <b><label>Cover : </label></b>
                            <div id="cover">
                                <img :src="'/uploads/'+project.cover" />
                            </div>
                            <hr>
                        </div>
                        <div class="column is-4">
                            <b><label>Location on Map : </label></b>
                            <span>{{ location }}</span>
                            <hr>
                        </div>
                        <div class="column is-12">
                            
                            <router-link :to="{ name: 'createPhase', params: { project: project }}"
                             class=" button is-success">Add Phase</router-link>
                        </div>
                        <div class="table_wrapper">
                            <b-table
                            :data="phases"
                            :paginated="isPaginated"
                            :per-page="perPage"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="user.first_name"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            id="table">
                            
                            <template slot-scope="props">
                                <b-table-column style="float:left;" field="id" label="ID" width="40" sortable numeric>
                                    {{ props.row.id }}
                                </b-table-column>

                                <b-table-column class="width" field="name" label="Name" sortable>
                                    {{ props.row.name }}
                                </b-table-column>

                                <b-table-column class="padding" field="" label="show" sortable >
                                    <router-link class="button is-primary is-medium" :to="'/admin/vue/showPhase/'+props.row.id" style="color:#fff;">
                                        Show
                                    </router-link>  
                                </b-table-column>

                                <b-table-column class="padding" field="" label="Edit" sortable >
                                    <router-link class="button is-primary is-medium" :to="'/admin/vue/editPhase/'+props.row.id" style="color:#fff;">
                                        Edit
                                    </router-link>  
                                </b-table-column>

                                <b-table-column class="padding btn_delete" field="phase_id" label="delete" sortable>
                                    <button class=" button is-medium" @click="deletePhaseActive(props.row)">
                                            Delete  
                                    </button>
                                </b-table-column>

                            </template>
                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                                </template>
                            </b-table>
                        </div>
                    </div>
                </div>
                <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
            </div>
        </div>
    </div>
</template>
<script>

import {getProject,getProjectPhotos,deletePhase} from './../../calls'
import { Carousel, Slide } from "vue-carousel";

export default {
     data() {
            return {
                project: {},
                location: '',
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                projectGallery: [],
                phases: [],
                phasesCurrentNumber: 0,
                phasesTotalNumber: 0,
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: true,
                defaultSortDirection: 'desc',
                // total: 0,
                page: 1,
                perPage: 10,
                isFullPage: true,
                paginationPosition: 'bottom',
                currentPage: 1,
            }
        },
        created() {
            this.id = this.$route.params.id
            this.getProjectPhotos()
        },
        mounted() {
            this.getData()
            $('#table > div.table-wrapper > table').css('background-color','#f3f1f1fa')
        },
        components: {
            Carousel,
            Slide
        },
        methods: {
            getProjectPhotos(){
                getProjectPhotos(this.id).then(response=>{
                    this.projectGallery = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getData(){
                this.isLoading = true
                getProject(this.id).then(response=>{
                    this.project = response.data.project
                    this.location = response.data.location
                    this.phases = response.data.phases
                    this.phasesCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                    this.phasesTotalNumber = response.data.total
                    if(this.phases.length == 0){
                        this.isEmpty = true
                    }
                    this.isLoading = false
                })
                .catch(error => {
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
                    message: 'Agent '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
            deletePhaseActive(phase) {
                this.$dialog.confirm({
                    title: 'Deleting Phase',
                    message: 'Are you sure you want to <b>delete</b> '+phase.name+ ' ?',
                    confirmText: 'Delete Developer',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.deletePhase(phase.id)
                })
            },
            deletePhase(phaseID){
                deletePhase(phaseID).then(response => {
                    this.success('Deleted')
                    this.getData()
                })
                .catch(error => {
                    this.errorDialog('Something went wrong please try again later')
                    console.log(error)
                })
            },
        }
}
</script>

<style scoped>
    #logo,#cover{
        padding: 10px;
    }
    #logo img,#cover img{
        width: 100%;
        height: 500px;
    }
    .table_wrapper{
        width: 100%;
    }
</style>
