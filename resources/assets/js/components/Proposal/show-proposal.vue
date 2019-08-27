<template>
    <div>
        <div class="box">
            <div class="box-header with-border column is-12">
                <h1 class="box-title"> Proposal</h1>
            </div>
            <div class="box-body column is-12">


                <strong>Lead: </strong> {{proposal.first_name}} {{proposal.last_name}}
                <br>
                <hr>


                <strong>Unite Type: </strong> {{proposal.unit_type}}
                <br>
                <hr>


                <strong>Residential/Commercial: </strong> {{proposal.personal_commercial}}
                <br>
                <hr>

                <strong>Developer :</strong> {{proposal.developer}}
                <br>
                <hr>

                <strong>Project :</strong> {{proposal.project}}
                <br>
                <hr>
                
                <strong>Phase :</strong> {{proposal.phase}}
                <br>
                <hr>

                <strong>Unit :</strong> {{proposal.phaseUnit}}
                <br>
                <hr>

                
                <!-- <b-field>
                     <b><label>phases : </label></b>
                            <span class="phases" v-for="phase in phases">{{ phase.name }}</span>
                     <hr>
                </b-field>
                <hr> -->

                <!-- <strong>Units :</strong>
                <b-field>
                    <b-select expanded v-model="unit_id">
                        <option v-for="phaseUint in phaseUnits" :value="phaseUint.id">
                            {{phaseUint.en_name}}
                        </option>
                    </b-select>
                </b-field>
                <hr> -->

                <strong>File: </strong> 
                <a :href="'/uploads/'+ proposal.file" class="fa fa-file" target="_blank"></a>
                <img >
                <br>
                <hr>
                <strong>Price: </strong> {{proposal.price}}
                <br>
                <hr>
                <div class="description column is-12"
                    style="display:flex; flex-direction: column; align-items: stretch;">
                    <strong>Description </strong> <textarea style="flex-grow: 8; margin-top:5px;" rows="5"
                        readonly> {{proposal.description}}</textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {showProposal,getProjectsPhases,getPhasesUnit} from "./../../calls";
    export default {
        data() {
            return {
                search: '',
                filter_deve: [],
                selected: [],
                isLoading: true,
                proposal: {},
                unit: '',
                id: null,
                phase_id:null,
                phases:[],
                project_id:null,
                unit_id:null,
                project_name:null,
                phaseUnits:[],
                token: window.auth_user.csrf
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
                showProposal(this.id)
                .then(response => {
                    this.proposal = response.data;

                    if(this.proposal.unit_type == "new_home"){
                        this.proposal.unit_type = "New Home"
                    }
                    if(this.proposal.unit_type == "resale"){
                        this.proposal.unit_type = "Resale"
                    }
                    if(this.proposal.unit_type == "rental"){
                        this.proposal.unit_type = "Rental"
                    }
                    if(this.proposal.unit_type == "land"){
                        this.proposal.unit_type = "Land"
                    }
                    if(this.proposal.personal_commercial == "personal"){
                        this.proposal.personal_commercial = "Residential"
                    }
                    this.getPhases();
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                });
                // this.proposal = window.proposal;                
            },
            getPhases(){

                    var data ={
                    '_token':this.token,
                    'id':this.proposal.project_id,
                    };
                    console.log("HAHAHHAHAHAHAHAHAH",data)
                getProjectsPhases(data).then(response=>{
                    console.log('all phases',response)
                    this.phases = response.data
                }).catch(error=>{
                    console.log(error)
                })
            },    
        //  getPhasesUnits(){
        //          var data ={
        //             '_token':this.token,
        //             'id':this.proposal.project_id,
        //           };
        //         getPhasesUnit(data).then(response=>{
        //             console.log('all phases Units',response)
        //             this.phaseUnits = response.data
        //         }).catch(error=>{
        //             console.log(error)
        //         })
        // }, 
        
        
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

     /* .phases{
        background-color: #7484fd;
        border: 1px solid #4c5ee6;
        border-radius: 15px;
        color: #FFFFFF;
        padding: 2px;
        margin-right: 6px;
        margin-left: 6px;
    } */

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