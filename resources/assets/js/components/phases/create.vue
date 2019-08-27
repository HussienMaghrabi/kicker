<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title" v-if="project">
                            Add Phase to {{ project.en_name }}
                        </p>
                        <p class="card-header-title" v-else>
                            Add Phase
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="column first">
                        <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-6">
                                <b-field label="English Name">
                                    <b-input type="text" v-model="phase.en_name" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input type="text" v-model="phase.ar_name" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input v-model="phase.en_description" maxlength="200" type="textarea"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Description">
                                    <b-input v-model="phase.ar_description" maxlength="200" type="textarea"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Price / Meter">
                                    <b-input type="number" v-model="phase.meter_price" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Area">
                                    <b-input type="number" v-model="phase.area" />
                                </b-field>
                            </div>
                            <div class="column is-12">
                                <b-field label="Facility">
                                    <multiselect :close-on-select="false" v-model="phase.facilities"  tag-placeholder="Add this as new facility" placeholder="Select Facilities" label="name" track-by="id" value="id" :options="facilities" :multiple="true" :taggable="true" style="/*z-index: 1000000000;*/"></multiselect>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Meta Keywords">
                                    <b-input type="text" v-model="phase.meta_keywords" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Meta Description">
                                    <b-input type="text" v-model="phase.meta_description" />
                                </b-field>
                            </div>
                            <div class="column is-12">
                                <b-field label="Delivery Date">
                                    <b-datepicker
                                        placeholder="Click to select Date..."
                                        :date-formatter="dateFormatter"
                                        position="is-bottom-right" v-model="phase.delivery_date">
                                    </b-datepicker>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field class="file">
                                    <b><label style="margin-right:5px">Logo: </label></b><br>
                                    <b-upload v-model="phase.logo"
                                    @input="handleLogo">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="logo">
                                        {{ logo.name }}
                                    </span>
                                </b-field>
                                <div id="preview">
                                    <img v-if="logoUrl" :src="logoUrl" style="width:100%;height: 350px;" />
                                </div>
                            </div>
                            <div class="column is-6">
                                <b-field class="file">
                                    <b><label style="margin-right:5px">Promo: </label></b><br>
                                    <b-upload v-model="phase.promo"
                                    @input="handlePromo">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="promo">
                                        {{ promo.name }}
                                    </span>
                                </b-field>
                                <div id="preview">
                                    <img v-if="promoUrl" :src="promoUrl" style="width:100%;height: 350px;" />
                                </div>
                            </div>
                           
                            <div class="column is-12">
                                <button type="button" class="button is-primary is-meduim mr-10 import-excel" @click="storePhase">Submit</button>
                            </div> 
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {getAgentTypes,getRoles,storePhase,getFacilities} from './../../calls'
import Multiselect from 'vue-multiselect'
export default {
    name: "createPhase",
    props: {
        project: Object
    },
     data() {
            return {
                phase: {},
                isLoading: true,
                token: window.auth_user.csrf,
                agentSource: window.auth_user.agentType,
                userType: window.auth_user.type,
                id: null,
                logo: null,
                promo: null,
                uploadedLogo: '',
                uploadedPromo: '',
                agent_types: [],
                selectedAgentType: '',
                selectedRC: '',
                isSwitched: false,
                facilities: [],
                selectedRole: '',
                logoUrl: '',
                promoUrl: '',
            }
        },
        created() {
        },
        mounted() {
            // $('body > div > div > div > div > section > div > div > div.column.is-4 > div.field.file.has-addons').css('display','#f3f1f1fa')
            this.getFacilities()
        },
        components: {
            Multiselect
        },
        methods: {
            handleLogo(event) {
                const file = event
                console.log(file)
                this.logoUrl = URL.createObjectURL(file);
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedLogo = reader.result
                })
            },
            handlePromo(event) {
                const file = event
                console.log(file)
                this.promoUrl = URL.createObjectURL(file);
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedPromo = reader.result
                })
            },
            getFacilities(){
                getFacilities().then(response=>{
                    this.facilities = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            errorDialog() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Please Fill required inputs',
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
            dateFormatter(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.delivery_date = `${year}`
                return date
            },
            storePhase(){
                const bodyFormData = new FormData();
                bodyFormData.append("_token",this.token);
                const data = this.phase
                var facilities = this.phase.facilities.map((facility) => {
                    return facility.id;
                });
                Object.keys(data).forEach(function(key) {
                    bodyFormData.append(key,data[key]);
                });
                bodyFormData.delete('facilities')
                if(this.phase.facilities != null){
                    for (var i = 0; i < facilities.length; i++) {
                        bodyFormData.append('facility[]', facilities[i]);
                    }
                }
                bodyFormData.append("project_id",this.project.id);

                storePhase(bodyFormData).then(response=>{
                    console.log(response)
                    this.success("Saved")
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
            },
        }
}
</script>

<style>

</style>
