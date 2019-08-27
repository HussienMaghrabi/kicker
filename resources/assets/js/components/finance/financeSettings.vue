<template>
        <div class="container" style="text-align:center;margin-bottom:5%">
            <div class="column is-12 dev-main-div" style="justify-content: center;">
                <div class="columns is-multiline" style="justify-content: center;">
                    <div class="searchDiv column is-12" style="padding-top: 0; margin: 3px;" dir="rtl">

                        <b-autocomplete :open-on-focus="true" dir="ltr" rounded v-model="search" :data="Auto_Complete"
                            placeholder="Search By Name" icon="magnify">
                            <!-- @select="option => selected = option" -->
                            <template slot="empty">No results found</template>
                        </b-autocomplete>
                    </div>
                    <!-- begin card -->
                    <div class="columns">

                        <!-- begin card -->
                        <div class="deve-card column is-4" style="padding-top: 0;margin-right:47%">
                            <ul class="deve-icon">
                                <li><a><router-link to="/admin/vue/outcome_category" class="far fa-eye"></router-link></a></li>
                            </ul>
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="padding-top: 0">
                                    <p><i class="fas fa-money-check-alt"></i></p>
                                </div>
                                <div class="column is-12 dev-footer">
                                    <div class="columns is-multiline is-mobile" style="margin: 0">
                                        <div class="column is-12" style="display: grid">
                                            <b-button class="dev-btn">Outcome Categories</b-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <!-- begin card -->
                        <div class="deve-card column is-4" style="padding-top: 0;">
                            <ul class="deve-icon">
                                <li><a><router-link to="/admin/vue/sub_categories" class="far fa-eye"></router-link></a></li>
                            </ul>
                            <div class="columns is-multiline is-mobile" style="margin: 0">
                                <div class="column is-12" style="padding-top: 0">
                                    <p><i class="fas fa-money-check-alt"></i></p>
                                </div>
                                <div class="column is-12 dev-footer">
                                    <div class="columns is-multiline is-mobile" style="margin: 0">
                                        <div class="column is-12" style="display: grid">
                                            <b-button class="dev-btn">Outcome Sub-Categories</b-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                </div>
            </div>
        </div>
</template>

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
        font-size: 40px;
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