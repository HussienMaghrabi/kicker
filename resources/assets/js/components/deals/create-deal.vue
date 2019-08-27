<template>
    <div>
        <div class="box">
            <div class="box-header with-border column is-12">
                <h1 class="box-title"> Add Deal</h1>
            </div>
            <div class="box-body column is-12">

                <div v-if="is_error" class="error-box column is-12" style="background-color: red">
                    <ul>

                        <li v-if="form_validation.proposal_id_error">{{form_validation.proposal_id_error}}</li>
                        <li v-if="form_validation.description_error">{{form_validation.description_error}}</li>
                        <li v-if="form_validation.agent_id_error">{{form_validation.agent_id_error}}</li>
                        <li v-if="form_validation.company_commission_error">{{form_validation.company_commission_error}}
                        </li>

                    </ul>
                </div>

                <b-field class="field-box" label="Proposal" type="" message="">
                    <b-select placeholder="Select Proposal" expanded required v-model="form_input.proposal">
                        <option v-for="proposal in confirmed_proposals" :key="proposal.id" :value="proposal.id">
                            Proposal: {{proposal.id}} , Agent: {{proposal.user_name}} , Client:
                            {{proposal.client_first_name}}
                            {{proposal.client_last_name}}</option>
                    </b-select>
                </b-field>
                <div class="box-body column is-12 body2" v-if="form_input.proposal">
                    <div class="columns is-multiline" style="margin: 0">
                        <div class="column is-6 box-field">
                            <strong>Buyer
                            </strong> <a
                                :href="'/admin/leads/'+ closed_deal_prop.lead_id">{{closed_deal_prop.first_name}}
                                {{closed_deal_prop.last_name}}</a>
                            <br>
                            <hr>
                        </div>
                        <div class="column is-6 box-field">
                            <strong>Seller:
                            </strong><a v-if="closed_deal_prop.unit_type!='new_home'"
                                :href="'/admin/leads/'+ lead_id">{{seller}}</a>
                            <span v-if="closed_deal_prop.unit_type=='new_home'">{{seller}}</span>
                            <br>
                            <hr>
                        </div>

                        <div class="column is-6 box-field">
                            <strong>Unit Type:
                            </strong>{{closed_deal_prop.unit_type}}
                            <br>
                            <hr>
                        </div>

                        <div class="column is-6 box-field">
                            <strong>Unit:
                            </strong><a :href="unitPath">{{unit}}</a>
                            <br>
                            <hr>
                        </div>

                        <div class="column is-6 box-field">
                            <strong>Price:
                            </strong>{{price}}
                            <br>
                            <hr>
                        </div>
                        <div class="column is-6 box-field" v-if="closed_deal_prop.unit_type == 'new_home'">
                            <strong>Project:
                            </strong><a
                                :href="'/admin/projects/'+ closed_deal_prop.project_id">{{closed_deal_prop.phase_name}}</a>
                            <br>
                            <hr>
                        </div>

                        <div class="column is-6 box-field">
                            <strong>File: </strong>
                            <a :href="'/uploads/'+ closed_deal_prop.file" class="fa fa-file" target="_blank"></a>
                            <br>
                            <hr>
                        </div>
                    </div>
                </div>
                <b-field class="field-box" label="Price" type="" message="">
                    <b-input class='disable-input' v-model="closed_deal_prop.proposal_price" type="input" >
                    </b-input>
                </b-field>

                <div class="columns column is-12" style="margin: 0; ">
                    <b-field class="field-box column is-6" label="Agent" type="" message=""
                        style="flex:unset !important">
                        <b-input class='disable-input' v-model="closed_deal_prop.user_name" type="input" >
                        </b-input>
                    </b-field>
                    <b-field class="field-box column is-6 has-add" style="flex:unset !important"
                        label="Agent Commission" type="" message="">
                        <b-input class='disable-input' v-model="form_input.commission" type="input" >
                        </b-input>
                        <span @click="addAgent" class="add"> <i class="fal fa-plus-square"></i></span>
                    </b-field>
                </div>
                <div class="columns column is-12" style="margin: 0; " v-for="(otherAgent,index) in has_other_agent"
                    :key="index">
                    <b-field class="field-box column is-6" label="Agent" type="" message=""
                        style="flex:unset !important">
                        <b-select placeholder="Select Agent" expanded required v-model="form_input.other_agent[index]">
                            <option v-for="agent in allAgents" :key="agent.id" :value="agent.id">
                                {{agent.name}}</option>
                        </b-select>
                    </b-field>
                    <b-field class="field-box column is-6 has-add" style="flex:unset !important"
                        label="Agent Commission" type="" message="">
                        <b-input class='disable-input' v-model="form_input.other_agent_commission[index]" type="input">
                        </b-input>
                        <span @click="deleteAgent(index)" class="minus"> <i class="far fa-minus-square"></i></span>
                    </b-field>
                </div>
                <b-field class="field-box" label="Company Commission " type="" message="">
                    <b-input v-model="form_input.company_commission" type="number" min="0">
                    </b-input>
                </b-field>
                <b-field class="field-box" label="Description" type="" message="">
                    <b-input v-model="form_input.description" maxlength="200" type="textarea"></b-input>
                </b-field>
                <input class="field-box btn" @click="submit_form" type="submit" value="Submit" />
            </div>
        </div>
    </div>
</template>

<script>
    import {
        getAllAgents,
        storeDeal,
        getProposalsConfirmed,
        getProposalClosedDeal
    } from "./../../calls";
    export default {
        data() {
            return {
                has_other_agent: [],
                confirmed_proposals: [],
                closed_deal_prop: {},
                seller: null,
                seller_id: null,
                unit: null,
                price: null,
                lead_id: null,
                unitPath: null,
                allAgents: [],
                isLoading: true,
                is_error: false,
                proposal: {},
                form_input: {
                    description: null,
                    proposal: null,
                    commission: null,
                    other_agent: [],
                    other_agent_commission: [],
                    company_commission: null,
                },
                form_validation: {
                    proposal_id_error: null,
                    price_error: null,
                    agent_commission_error: null,
                    company_commission_error: null,
                    seller_id_error: null,
                    buyer_id_error: null,
                    description_error: null,
                    agent_id_error: null,
                },
                token: window.auth_user.csrf,
                auth_id: window.auth_user.id,
            };
        },
        mounted() {
            this.getData();
        },
        watch: {
            'form_input.other_agent': {
                handler: function (val, oldVal) {
                    for (let i = 0; i < val.length; i++) {
                        if (val[i]) {
                            for (var k = 0; k < this.allAgents.length; k++) {
                                if (this.allAgents[k].id == val[i]) {
                                    this.form_input.other_agent_commission[i] = this.closed_deal_prop
                                        .proposal_price * this
                                        .allAgents[k].commission / 100;
                                    break;
                                }
                            }
                        }
                    }
                },
                deep: true
            },
            'form_input.proposal': function () {
                this.getProposalClosedDeal(this.form_input.proposal);
            }
        },
        components: {
        },
        methods: {
            getData() {
                this.getProposalsConfirmed();
                this.getAllAgents();
            },
            getProposalsConfirmed() {
                getProposalsConfirmed()
                    .then(response => {
                        this.confirmed_proposals = response.data;
                        console.log('prop', this.confirmed_proposals);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getProposalClosedDeal(id) {
                getProposalClosedDeal(id).then(response => {
                    this.closed_deal_prop = response.data;
                    console.log("cloooooosed",this.closed_deal_prop)
                    this.form_input.commission = this.closed_deal_prop.proposal_price * this.closed_deal_prop
                        .user_commission / 100;

                    if (this.closed_deal_prop.unit_type == 'new_home') {

                        this.closed_deal_prop.unit_type = 'New Home';
                        this.lead_id = this.closed_deal_prop.lead_id
                        this.seller = this.closed_deal_prop.project_name;
                        // this.seller_id = this.closed_deal_prop.project_id;
                        this.unit = this.closed_deal_prop.property_name;
                        this.price = this.closed_deal_prop.start_price;
                        this.unitPath = "/admin/properties/" + this.closed_deal_prop.property_id;
                        this.form_input.company_commission = this.closed_deal_prop.project_commission;
                    }
                    if (this.closed_deal_prop.unit_type == 'resale') {

                        this.seller = this.closed_deal_prop.leadResale_first_name + ' ' + this.closed_deal_prop
                            .leadResale_last_name;
                        // this.seller_id = this.closed_deal_prop.resale_id;
                        this.unit = this.closed_deal_prop.resale_title;
                        this.price = this.closed_deal_prop.price;
                        this.lead_id = this.closed_deal_prop.leadResale_id;
                        this.unitPath = "/admin/resale_units/" + this.closed_deal_prop.resale_id;
                        this.form_input.company_commission = 0;
                    }

                    if (this.closed_deal_prop.unit_type == 'rental') {
                        this.seller = this.closed_deal_prop.leadRental_first_name + ' ' + this.closed_deal_prop
                            .leadRental_last_name;
                        // this.seller_id = this.closed_deal_prop.rental_id;
                        this.unit = this.closed_deal_prop.rental_title;
                        this.price = this.closed_deal_prop.rent;
                        this.lead_id = this.closed_deal_prop.leadRental_id;
                        this.unitPath = "/admin/rental_units/" + this.closed_deal_prop.rental_id;
                        this.form_input.company_commission = 0;
                    }
                    if (this.closed_deal_prop.unit_type == 'land') {
                        this.seller = this.closed_deal_prop.leadLand_first_name + ' ' + this.closed_deal_prop
                            .leadLand_last_name;
                        // this.seller_id = this.closed_deal_prop.land_id;
                        this.unit = this.closed_deal_prop.land_title;
                        this.price = this.closed_deal_prop.meter_price + ' * ' + this.closed_deal_prop.area;
                        this.lead_id = this.closed_deal_prop.leadLand_id;
                        this.unitPath = "/admin/lands/" + this.closed_deal_prop.land_id;
                        this.form_input.company_commission = 0;
                    }
                    console.log('prop deals', this.closed_deal_prop);
                }).catch(error => {
                    console.log(error);
                });
            },
            getAllAgents() {
                getAllAgents().then(response => {
                        this.allAgents = response.data;
                        console.log('Agents', this.allAgents);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            addAgent() {
                this.has_other_agent.push(1);
                this.form_input.other_agent.push(null);
                this.form_input.other_agent_commission.push(null);
                console.log('add');
            },
            deleteAgent(index) {
                this.has_other_agent.splice(index, 1);
                this.form_input.other_agent.splice(index, 1);
                this.form_input.other_agent_commission.splice(index, 1);
            },
            submit_form() {
                this.clearValidation();

                if (this.form_input.proposal == null) {
                    this.is_error = true;
                    this.form_validation.proposal_id_error = "Proposal is required";
                }
                if (this.form_input.description == null) {
                    this.is_error = true;
                    this.form_validation.description_error = "Description is required";
                }
                if (this.form_input.other_agent != null) {
                    for (var i = 0; i < this.form_input.other_agent.length; i++) {
                        if (!this.form_input.other_agent[i]) {
                            this.is_error = true;
                            this.form_validation.agent_id_error = "Agent is required";
                        }
                    }
                }
                if (this.form_input.company_commission == null) {
                    this.is_error = true;
                    this.form_validation.company_commission_error = "Company commission is required";
                }

                if (!this.is_error) {
                    var data = {
                        proposal_id: this.form_input.proposal,
                        price: this.closed_deal_prop.proposal_price,
                        agent_commission: this.form_input.commission,
                        company_commission: this.form_input.company_commission,
                        broker_commission: null,
                        seller_id: this.lead_id,
                        buyer_id: this.closed_deal_prop.lead_id,
                        description: this.form_input.description,
                        agent_id: this.closed_deal_prop.user_id,
                        other_agent: this.form_input.other_agent,
                        other_agent_commission: this.form_input.other_agent_commission
                    };
                    storeDeal(data).then(response => {
                        localStorage.setItem('Add Deal', 'Created');
                        window.location = "/admin/vue/deals";
                    })
                }
            },
            clearValidation() {
                this.is_error = false;
                this.form_validation.proposal_id_error = null;
                this.form_validation.description_error = null
                this.form_validation.agent_id_error = null;
                this.form_validation.company_commission_error = null;
            }
        }
    };
</script>

<style scoped>
    .uploadfile {
        background-color: white;
        border-color: #dbdbdb;
        color: #363636;
        -webkit-box-shadow: inset 1px 1px 3px 1px rgba(10, 10, 10, 0.1);
        box-shadow: inset 1px 1px 3px 1px rgba(10, 10, 10, 0.1);
        max-width: 100%;
        width: 100%;
        -moz-appearance: none;
        -webkit-appearance: none;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        border: 1px solid transparent;
        border-radius: 4px;
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        font-size: 1rem;
        height: 2.25em;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        line-height: 1.5;
        padding-bottom: calc(0.375em - 1px);
        padding-left: calc(0.625em - 1px);
        padding-right: calc(0.625em - 1px);
        padding-top: calc(0.375em - 1px);
        position: relative;
        vertical-align: top;
        font-family: BlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
        margin: 0;
    }

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


    .box-title::before,
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
    }

    .box-body {
        width: 95%;
        margin: 0 auto;
        font-size: 1em;
        background: #ffffff;
        border-radius: 3px;
        box-shadow: 0 0px 20px rgba(0, 0, 0, 0.1);
    }

    .body2 {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
    }

    .body2 hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        border-top: 1px solid #eee;
        height: 0;
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
    }

    .body2 .box-field {
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px
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

    .field-box {
        margin: 10px 10px;
    }

    .field-box.btn {
        background: #3c8dbc;
        color: #fff;
        border: none;
        height: 48px;
        font-size: 15px;
        padding: 0 2em;
        cursor: pointer;
        transition: 800ms ease all;
    }

    .field-box.btn:hover {
        background: rgb(17, 192, 177);
        color: rgb(26, 106, 171);
    }

    .select select {
        line-height: 1rem;
    }

    ul,
    li {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    ul {
        margin: 0.5em 0;
    }

    li {
        margin: 0.5em;
        color: whitesmoke;
        font-weight: bold;
        margin-left: 3em;
    }

    li:before {
        content: '\f00d';
        font-family: 'FontAwesome';
        float: left;
        margin-left: -1.5em;
        color: #0074D9;
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

<style>
    @import url("https://use.fontawesome.com/releases/v5.8.1/css/all.css");

    .disable-input input {
        border-radius: 4px !important;
        box-shadow: none !important;
        border-color: #d2d6de !important;
        cursor: text !important;
    }



    .add,
    .minus {
        font-family: "Font Awesome 5 Free";
        /* This is the correct font-family*/
        font-style: normal;
        font-weight: normal;
        font-size: 30px;
        text-decoration: inherit;
        border-color: #3273dc;
        right: 0;
        z-index: 4;
        border: 3px solid transparent;
        display: block;
        position: absolute;
        top: 33%;
        /* content: "\f0fe"; */
        cursor: pointer;
    }

    .has-add.field.has-addons {
        display: unset !important;
        justify-content: unset !important;
        position: relative;
    }
</style>