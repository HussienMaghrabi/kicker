<template>
    <div class="container">
        <div class="card">
            <header class="card-header padding level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Website controller
                        </p>
                    </div>
                </div>
                <div class="level-right">
                </div>
            </header>
            <div class="columns">
                <!-- sort projects -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/sort_Projects" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-sort main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                    <b-button class="dev-btn">Sort Projects</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sort resale -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/sort_resale" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-sort main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                    <b-button class="dev-btn">Sort resale</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sort rental -->
                                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/sort_rental" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-sort main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                    <b-button class="dev-btn">Sort rental</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- endsort rentale -->
            </div>
            <div class="columns">
                <!-- settings -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/admin_settings" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-user-cog main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                    <b-button class="dev-btn">Settings</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end settings -->
                <!-- Blogs -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/events" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-pager main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                    <b-button class="dev-btn">Blogs</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Blogs -->
                <!-- projects baners -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/projects_banner" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-images main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                    <b-button class="dev-btn">projects banners</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end projects baners -->
            </div>
            <div class="columns">
                <!-- begin change markers -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <!-- <li><a><router-link to="/admin/vue/project_baners" class="far fa-eye"></router-link></a></li> -->
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-images main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                        <b-button @click="ChangeMarkers" class="dev-btn">Change Marker</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end change markers -->

                <!-- begin refresh -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <!-- <li><a><router-link to="/admin/vue/project_baners" class="far fa-eye"></router-link></a></li> -->
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-images main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                        <b-button @click="refreshSiteMap" class="dev-btn">Refresh Site Map</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end change markers -->

                <!-- begin refresh -->
                <div class="deve-card column is-4" style="padding-top: 0;">
                    <ul class="deve-icon">
                        <li><a><router-link to="/admin/vue/googleSeo" class="far fa-eye"></router-link></a></li>
                    </ul>
                    <div class="columns is-multiline is-mobile" style="margin: 0">
                        <div class="column is-12 holder-icon" style="padding-top: 0">
                            <!-- <img class="dev-img" :src="'logo.png'"> -->
                            <span class="fa fa-google main-icom"></span>
                        </div>
                        <div class="column is-12 dev-footer">
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="display: grid">
                                        <b-button class="dev-btn">Google S E O</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end change markers -->

                <!-- refresh modal -->
                    <b-modal :active.sync="refreshModal" has-modal-card :can-cancel="false">
                            <div class="modal-card" style="width: auto">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">URL sitemap.xml</p>
                                </header>
                                <section class="modal-card-body text-center">
                                    <div class="col-is-12">
                                        <b-field label="">
                                            <b-input id="myInput" placeholder="Disabled" :value="siteMapUrl" disabled></b-input>
                                            <b-button @click.stop.prevent="copied"><span class="fa fa-copy"></span></b-button>
                                        </b-field>
                                    </div>
                                </section>
                                <footer class="modal-card-foot">
                                    <button class="button" type="button" @click="refreshModal = false">Close</button>
                                </footer>
                            </div>
                    </b-modal>
                <!-- end refresh modal -->

            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<script>
    import{
    ChangeWebMarker,
    refresh,
    } from './../../calls'
    export default {
        data(){
            return{
                date:null,
                isLoading:false,
                refreshModal:false,
                isFullPage:true,
                siteMapUrl:null,
            }
        },
        methods:{
            conChange(){
                ChangeWebMarker().then(response=>{
                    console.log(response)
                    this.alertsuccess('Marker Is Uploaded')
                }).catch(error=>{
                    this.alerterror('some Error')
                    console.log(error)
                })
            },
            refreshSite(){
                refresh().then(response=>{
                    this.date = response.data.date
                    if (response.data.status == true) {
                        this.siteMapUrl = response.data.sitemap
                        this.alertsuccess('file xml is up to date at')
                        // this.isLoading = true
                        this.refreshModal = true;
                        // console.log(this.date)
                    }else{
                    this.alerterror('some Error')
                    console.log(error)
                    }
                }).catch(error=>{
                    this.alerterror('some Error')
                    console.log(error)
                })
            },
            refreshSiteMap(){
                this.$dialog.confirm({
                    title: 'Change',
                    message: 'Are you sure you want to <b>Change</b> Marker ?',
                    confirmText: 'Refresh',
                    type: 'is-success',
                    hasIcon: true,
                    onConfirm: () => this.refreshSite()
                })
            },
            copied(){
                let testingCodeToCopy = document.querySelector('#myInput')
                testingCodeToCopy.setAttribute('type', 'text')
                testingCodeToCopy.select()
                    this.alertsuccess('copied');
                try {
                    var successful = document.execCommand('copy');

                } catch (err) {
                    this.alerterror('Not copied');
                }
                window.getSelection().removeAllRanges()
            },
            ChangeMarkers(){
                this.$dialog.confirm({
                    title: 'Change',
                    message: 'Are you sure you want to <b>Change</b> Marker ?',
                    confirmText: 'Change',
                    type: 'is-success',
                    hasIcon: true,
                    onConfirm: () => this.conChange()
                })
            },
            alertsuccess(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-success'
                })
            },
            alerterror(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
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
    .holder-icon{
        text-align:center
    }
    .main-icom{
        font-size:3rem;
    }
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
        margin:auto;
        margin-bottom:2rem;
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