<template>
    <div>
        <div class="box">
            <div class="box-header with-border column is-12">
                <h1 class="box-title"> Proposal</h1>
            </div>
            <div class="box-body column is-12">

                <div v-if="is_error" class="error-box column is-12" style="background-color: red">
                    <ul>
                        <li v-if="form_validation.unit_type_error">{{form_validation.unit_type_error}}</li>
                        <li v-if="form_validation.Residential_Commercial_error">
                            {{form_validation.Residential_Commercial_error}}</li>
                        <!-- <li v-if="form_validation.unit_error">{{form_validation.unit_error}}</li> -->
                        <li v-if="form_validation.developer_error">{{form_validation.developer_error}}</li>
                        <!-- <li v-if="form_validation.project_error">{{form_validation.project_error}}</li>
                        <li v-if="form_validation.phase_error">{{form_validation.phase_error}}</li> -->
                        <li v-if="form_validation.lead_error">{{form_validation.lead_error}}</li>
                        <li v-if="form_validation.price_error">{{form_validation.price_error}}</li>
                        <li v-if="form_validation.description_error">{{form_validation.description_error}}</li>
                    </ul>
                </div>

                <b-field class="field-box" label="Unit Type" type="" message="">
                    <b-select placeholder="Select Unit Type" expanded required v-model="form_input.unit_type">
                        <option value="resale">Resale</option>
                        <option value="rental">Rental</option>
                        <option value="new_home">New Home</option>
                        <option value="land">Land</option>
                    </b-select>
                </b-field>

                <b-field class="field-box" label="Residential/Commercial" type="" message="">
                    <b-select placeholder="Residential/Commercial" :disabled='disable_field' expanded
                        v-model="form_input.personal_commercial">
                        <option value="personal">Residential</option>
                        <option value="commercial">Commercial</option>
                    </b-select>
                </b-field>
                <b-field v-if="form_input.unit_type != 'new_home'" class="field-box" label="Unit" type="" message="">
                    <b-select placeholder="Select a unit" expanded required v-model="form_input.unit_id">
                        <option v-for="unit in units" :key="unit.id" :value="unit.id">{{unit.title}}</option>
                        <option v-if="units.length==0||!units" disabled> No results found </option>
                    </b-select>
                </b-field>
                <div class="column is-3">
                    <b-field v-if="form_input.unit_type == 'new_home'" class="field-box" label="Developer" type=""
                        message="">
                        <b-select placeholder="Developers" expanded required v-model="form_input.developer_id">
                            <option v-for="developer in allDevelopers" :key="developer.id" :value="developer.id">
                                {{developer.name}}</option>
                        </b-select>
                    </b-field>
                </div>
                <div class="column is-3">
                    <b-field
                        v-if="developerProjects.length>0 && form_input.developer_id && form_input.unit_type == 'new_home'"
                        class="field-box" label="Project" type="" message="">
                        <b-select placeholder="Projects" expanded v-model="form_input.project_id">
                            <option v-for="project in developerProjects" :key="project.id" :value="project.id">
                                {{project.name}}</option>
                        </b-select>
                    </b-field>
                </div>
                <div class="column is-3">
                    <b-field
                        v-if="ProjectsPhases.length>0 && form_input.project_id && form_input.developer_id && form_input.unit_type == 'new_home'"
                        class="field-box" label="Phases" type="" message="">
                        <b-select placeholder="Phases" expanded v-model="form_input.phase_id">
                            <option v-for="phase in ProjectsPhases" :key="phase.id" :value="phase.id">
                                {{phase.name}}</option>
                        </b-select>
                    </b-field>
                </div>
                <div class="column is-3">
                    <b-field
                        v-if="units_phases.length>0 && form_input.phase_id && form_input.project_id && form_input.developer_id && form_input.unit_type == 'new_home'"
                        class="field-box" label="Unit Phases" type="" message="">
                        <b-select placeholder="Unit Phases" expanded v-model="form_input.unit_id">
                            <option v-for="unit in units_phases" :key="unit.id" :value="unit.id">
                                {{unit.name}}</option>
                        </b-select>
                    </b-field>
                </div>
                <b-field class="field-box" label="Lead" type="" message="">
                    <b-select placeholder="Select Lead" expanded required v-model="form_input.lead_id">
                        <option v-for="lead in leads" :key="lead.id" :value="lead.id">{{lead.first_name}}
                            {{lead.last_name}} - <span v-if="auth_id == lead.agent_id"> My lead </span>
                            <span v-else> {{lead.agentName}}'s Leads</span></option>
                    </b-select>
                </b-field>

                <b-field class="field-box" label="Price" type="" message="">
                    <b-input v-model="form_input.price" type="number" min="0"></b-input>
                </b-field>

                <b-field class="field-box" label="Description" type="" message="">
                    <b-input v-model="form_input.description" maxlength="200" type="textarea"></b-input>
                </b-field>

                <b-field class="field-box" label="file" type="" message="">
                    <input class="uploadfile" type="file" id="file" ref="file" v-on:change="handleFileUpload()" />
                </b-field>

                <input class="field-box btn" @click="submit_form" type="submit" value="Update" />
            </div>
        </div>
    </div>
</template>

<script>
    import {
        getLands,
        getUnits,
        getAgentLeads,
        getAllDevelopers,
        getDeveloperProjects,
        updateProposal,
        getProjectsPhases,
        getPhasesUnit,
        showProposal
    } from "./../../calls";
    export default {
        data() {
            return {
                file: '',
                search: '',
                filter_deve: [],
                selected: [],
                disable_field: false,
                isLoading: true,
                proposal: {},
                units: [],
                units_phases: [],
                leads: [],
                is_error: false,
                developerProjects: [],
                allDevelopers: [],
                ProjectsPhases: [],
                loadData: true,
                form_input: {
                    unit_type: null,
                    unit_id: null,
                    developer_id: null,
                    project_id: null,
                    phase_id: null,
                    personal_commercial: null,
                    lead_id: null,
                    file: null,
                    price: null,
                    description: null
                },
                form_validation: {
                    unit_type_error: null,
                    unit_error: null,
                    developer_error: null,
                    project_error: null,
                    phase_error: null,
                    Residential_Commercial_error: null,
                    lead_error: null,
                    price_error: null,
                    description_error: null
                },
                token: window.auth_user.csrf,
                auth_id: window.auth_user.id,
                id: null
            };
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            // this.showProposal();
            this.getData();
        },
        watch: {
            'form_input.unit_type': function () {
                if (this.form_input.unit_type == "land") {
                    this.disable_field = true;
                    this.form_input.personal_commercial = null;
                    this.getUnits(this.form_input.unit_type);
                } else {
                    this.disable_field = false;
                    if (this.form_input.personal_commercial != null) {
                        this.getUnits(this.form_input.unit_type);
                    }
                    if (this.form_input.unit_type == 'new_home') {

                        if (this.loadData == false) {
                            this.form_input.unit_id = null;
                            this.form_input.developer_id = null;
                            this.form_input.project_id = null;
                            this.form_input.phase_id = null;
                        }
                        this.getAllDevelopers();
                        this.loadData = false;
                    }
                }
            },
            'form_input.personal_commercial': function () {
                this.getUnits(this.form_input.unit_type);
            },
            'form_input.developer_id': function () {
                this.developerProjects = [];
                this.ProjectsPhases = [];
                this.units_phases = [];
                this.getDeveloperProjects();
            },
            'form_input.project_id': function () {
                this.ProjectsPhases = [];
                this.units_phases = [];
                this.getProjectsPhases();
            },
            'form_input.phase_id': function () {
                this.units_phases = [];
                this.getPhasesUnit();
            },
            // 'form_input.file': function () {
            //     this.file = this.$refs.fileeee;
            //     // let formData = new FormData();

            //     // formData.append('file', this.file);
            //     console.log(formData, 'formdata');
            //     console.log(this.form_input.file, "file");
            // },
        },
        components: {
        },
        methods: {
            getData() {
                // this.getAgentLeads();
                this.showProposal();
            },
            showProposal(){
                showProposal(this.id)
                    .then(response => {
                        console.log("test",response)
                        this.proposal = response.data;
                        this.loadProposal()
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            loadProposal() {
                // this.proposal = window.proposal;
                console.log("TST: ",this.proposal)
                if (this.proposal.unit_type == "land") {
                    this.form_input.unit_type = this.proposal.unit_type;
                    this.form_input.unit_id = this.proposal.land_id;
                    this.form_input.lead_id = this.proposal.lead_id;
                    this.form_input.price = this.proposal.price;
                    this.form_input.description = this.proposal.description;
                    // this.form_input.file = this.proposal.file;
                } else {
                    if (this.proposal.unit_type == "new_home") {
                        this.form_input.unit_type = this.proposal.unit_type;
                        this.form_input.personal_commercial = this.proposal.personal_commercial;
                        this.form_input.developer_id = this.proposal.developer_id;
                        this.form_input.project_id = this.proposal.project_id;
                        this.form_input.phase_id = this.proposal.phase_id;
                        this.form_input.unit_id = this.proposal.property_id;
                        this.form_input.lead_id = this.proposal.lead_id;
                        this.form_input.price = this.proposal.price;
                        this.form_input.description = this.proposal.description;
                        // this.form_input.file = this.proposal.file;
                    } else {
                        if (this.proposal.unit_type == "rental") {
                            this.form_input.unit_type = this.proposal.unit_type;
                            this.form_input.personal_commercial = this.proposal.personal_commercial;
                            this.form_input.unit_id = this.proposal.rental_id;
                            this.form_input.lead_id = this.proposal.lead_id;
                            this.form_input.price = this.proposal.price;
                            this.form_input.description = this.proposal.description;
                            // this.form_input.file = this.proposal.file;
                        } else {
                            this.form_input.unit_type = this.proposal.unit_type;
                            this.form_input.personal_commercial = this.proposal.personal_commercial;
                            this.form_input.unit_id = this.proposal.resale_id;
                            this.form_input.lead_id = this.proposal.lead_id;
                            this.form_input.price = this.proposal.price;
                            this.form_input.description = this.proposal.description;
                            // this.form_input.file = this.proposal.file;
                        }
                    }
                }
            },
            getUnits(type) {
                if (type != "new_home") {
                    if (type == "land") {
                        getLands()
                            .then(response => {
                                this.units = response.data;
                                console.log(this.units.length);
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    } else {
                        var data = {
                            personal_commercial: this.form_input.personal_commercial,
                            type: type,
                            _token: this.token
                        };
                        getUnits(data).then(response => {
                            this.units = response.data;
                        }).catch(error => {
                            console.log(error);
                        });

                    }
                }
            },
            getAgentLeads() {
                getAgentLeads()
                    .then(response => {
                        this.leads = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getAllDevelopers() {
                getAllDevelopers().then(response => {
                    this.allDevelopers = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            getDeveloperProjects() {
                var data = {
                    id: this.form_input.developer_id,
                    _token: this.token
                };
                getDeveloperProjects(data).then(response => {
                    this.developerProjects = response.data;
                    console.log(this.developerProjects);
                }).catch(error => {
                    console.log(error);
                });
            },
            getProjectsPhases() {
                var data = {
                    id: this.form_input.project_id,
                    _token: this.token
                };
                getProjectsPhases(data).then(response => {
                        this.ProjectsPhases = response.data;
                        console.log(this.ProjectsPhases);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getPhasesUnit() {
                var data = {
                    id: this.form_input.phase_id,
                    type: this.form_input.personal_commercial,
                    _token: this.token
                };
                getPhasesUnit(data).then(response => {
                    this.units_phases = response.data;
                    console.log(this.units_phases, "unite phases");
                })
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
                this.form_input.file = this.file;
            },
            submit_form() {
                this.clearValidation();
                if (this.form_input.unit_type == null) {
                    this.is_error = true;
                    this.form_validation.unit_type_error = "Unit Type is required";
                }
                if (this.form_input.personal_commercial == null && this.form_input.unit_type != "land") {
                    this.is_error = true;
                    this.form_validation.Residential_Commercial_error = "Residential/Commercial is required";
                }
                // if (this.form_input.unit_id == null && this.form_input.unit_type != "new_home") {
                //     this.is_error = true;
                //     this.form_validation.unit_error = "Unit is required";
                // }
                if (this.form_input.lead_id == null) {
                    this.is_error = true;
                    this.form_validation.lead_error = "Lead is required";
                }
                if (this.form_input.price == null) {
                    this.is_error = true;
                    this.form_validation.price_error = "Price is required";
                }
                if (this.form_input.price < 0) {
                    this.is_error = true;
                }
                if (this.form_input.description == null) {
                    this.is_error = true;
                    this.form_validation.description_error = "Description is required";
                }
                if (this.form_input.developer_id == null && this.form_input.unit_type == "new_home") {
                    this.is_error = true;
                    this.form_validation.developer_error = "Developer is required";
                }
                // if (this.form_input.project_id == null && this.form_input.unit_type == "new_home") {
                //     this.is_error = true;
                //     this.form_validation.project_error = "Project is required";
                // }
                // if (this.form_input.phase_id == null && this.form_input.unit_type == "new_home") {
                //     this.is_error = true;
                //     this.form_validation.phase_error = "Phase is required";
                // }



                if (!this.is_error) {
                    const formData = new FormData();
                    for (const key in this.form_input) {
                        const value = this.form_input[key];
                        formData.set(key, value);
                    }
                    formData.append('unit_type', this.form_input.unit_type);
                    formData.append('unit_id', this.form_input.unit_id);
                    formData.append('developer_id', this.form_input.developer_id);
                    formData.append('project_id', this.form_input.project_id);
                    formData.append('phase_id', this.form_input.phase_id);
                    formData.append('personal_commercial', this.form_input.personal_commercial);
                    formData.append('lead_id', this.form_input.lead_id);
                    formData.append('price', this.form_input.price);
                    formData.append('description', this.form_input.description);
                    formData.append('file', this.form_input.file);
                    updateProposal(formData).then(response => {
                        window.location = "/admin/proposals";
                    })
                }
            },
            clearValidation() {
                this.is_error = false;
                this.form_validation.unit_type_error = null;
                this.form_validation.unit_error = null
                this.form_validation.developer_error = null;
                this.form_validation.project_error = null;
                this.form_validation.phase_error = null;
                this.form_validation.Residential_Commercial_error = null;
                this.form_validation.lead_error = null;
                this.form_validation.price_error = null;
                this.form_validation.description_error = null;
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
        background-color: whitesmoke !important;
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