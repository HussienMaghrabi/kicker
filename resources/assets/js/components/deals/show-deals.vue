<template>
    <div>
        <div class="box">
            <div class="box-header with-border column is-12">
                <h1 class="box-title"> Deal</h1>
            </div>
            <div class="box-body column is-12">
                <div class="columns is-multiline" style="margin: 0">
                    <div class="column is-6">
                        <strong>Buyer:
                        </strong>{{deal.buyer_first_name}} {{deal.buyer_last_name}}
                        <br>
                        <hr>
                    </div>


                    <div class="column is-6">
                        <strong>Seller: </strong>{{deal.seller_first_name}} {{deal.seller_last_name}}
                        <br>
                        <hr>
                    </div>

                    <div class="column is-6">
                        <strong>Lead: </strong>{{deal.user_name}} 
                        <br>
                        <hr>
                    </div>

                    <div class="column is-6">
                        <strong>Price: </strong>{{ deal.price }}
                        <br>
                        <hr>
                    </div>

                    <div class="column is-6">
                        <strong>Proposal: </strong> <a @click="showProp(deal.proposal_id)">
                            # {{deal.proposal_id }} </a>
                        <br>
                        <hr>
                    </div>


                     <div class="column is-6">
                        <strong>Residential/Commercial: </strong> {{deal.personal_commercial}}
                        <br>
                        <hr>
                    </div>


                    <div class="column is-6">
                        <strong>Unit Type:</strong> {{ deal.unit_type }}
                        <br>
                        <hr>
                    </div>

                    <div class="column is-6">
                        <strong>Unit:</strong> {{deal.unit}}
                        <br>
                        <hr>
                    </div>

                    <div class="column is-6">
                        <strong>Agent: </strong> {{ deal.user_name }}
                        <br>
                        <hr>
                    </div>

                    <div class="column is-6">
                        <strong>Agent Commission: </strong> {{ deal.agent_commission }}
                        <br>
                        <hr>
                    </div>

                    <div class="column is-12">
                        <strong>Company Commission: </strong> {{ deal.company_commission }}
                        <br>
                        <hr>
                    </div>

                    <div class="description column is-12"
                        style="display:flex; flex-direction: column; align-items: stretch;">
                        <strong>Description </strong> <textarea style="flex-grow: 8; margin-top:5px;" rows="5"
                            readonly> {{deal.description}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {showDeal} from "./../../calls";
    export default {
        data() {
            return {
                search: '',
                filter_deve: [],
                selected: [],
                isLoading: true,
                proposal: {},
                deal: {},
                unit: ''
            };
        },
        created() {
          this.id = this.$route.params.id
        },
        mounted() {
            this.getData();
        },
        components: {
        },
        methods: {
            getData(loading = true) {
                this.isLoading = loading;
                showDeal(this.id).then(response=>{
                    // console.log("deaaaaal",Response)
                   this.deal = response.data
                    if (this.deal.unit_type == 'rental') {
                     this.deal.unit_type = "Rental";
                    }
                    if (this.deal.unit_type == 'resale') {
                      this.deal.unit_type = "Resale";
                    }
                    if (this.deal.unit_type == 'new_home') {
                      this.deal.unit_type = "New Home";
                    }
                    if(this.deal.personal_commercial == "personal"){
                        this.deal.personal_commercial = "Residential"
                    }
                   this.isLoading = false
                   console.log("ddddd",this.deal)
                }).catch(error=>{
                  console.log(error)
                }
                )
                // this.proposal = window.proposal;
                // this.deal = window.deal;
                // console.log('deals', this.deal);
                // if (this.deal.unit_type == 'rental') {
                //     this.unit = this.deal.rental_title;
                // }
                // if (this.deal.unit_type == 'resale') {
                //     this.unit = this.deal.resale_title;
                // }
                // if (this.deal.unit_type == 'new_home') {
                //     this.unit = this.deal.property_name;
                // }
            },
            showProp(id) {
                window.location = "/admin/proposals/" + id;
            }
        }
    };
</script>


<style scoped>
    .box {
        /* justify-content: center !important; */
        background-color: unset !important;
        padding: unset !important;
    }

    .box-header {
        text-align: center;
    }

    .box-title {
        color: black;
        font-family: 'EB Garamond', serif;
        font-size: 3.5em;
        font-weight: normal;
        font-style: normal;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        line-height: 2.2em;
        display: block;
        text-shadow: 0.07em 0.07em 0 rgba(0, 0, 0, 0.1);

    }


    /* .box-title::before,
    .box-title::after {
        content: "§";
        display: inline-block;
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
        opacity: 0.2;
        margin: 0 0.6em;
        font-size: 0.5em;
    } */

    .box-body {
        width: 95%;
        margin: 0 auto;
        font-size: 1em;
        background: #ffffff;
        border-radius: 3px;
        box-shadow: 0 0px 20px rgba(0, 0, 0, 0.1);
    }


    .box-body strong {
        margin-left: 10px;
    }

    textarea {
        padding: 10px;
        margin: 0px 2px;
        font: 20px/28px 'Open Sans', sans-serif;
        letter-spacing: 1px;
        cursor: default;
        background-color: whitesmoke;
    }

    @media screen and (max-width:1087px) {
        .box-title {
            font-size: 2em;
        }

        .box-body {
            font-size: 15px;
        }
    }
</style>