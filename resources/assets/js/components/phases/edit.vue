<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit Phase
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
                            <div class="column is-6">
                                <b-field label="Delivery Date">
                                    <b-datepicker
                                        placeholder="Click to select Date..."
                                        :date-formatter="dateFormatter"
                                        position="is-bottom-right" v-model="phase.delivery_date">
                                    </b-datepicker>
                                </b-field>
                            </div>
                            <div class="column is-6">
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
                                <button type="button" class="button is-primary is-meduim mr-10 import-excel" @click="updatePhase">Update</button>
                            </div> 
                        </div>
                    </div> 
                </section>
            </div>
        </div>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import {getPhase,updatePhase,getPhaseFacilities,getFacilities} from './../../calls'
import Multiselect from 'vue-multiselect'
import { Carousel, Slide } from "vue-carousel";
export default {
    data() {
            return {
                phase: {},
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                facilities: [],
                delivery_date: ''
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            // this.getPhaseFacilities()
            this.getFacilities()
            this.getData()
            $('select').css('width','100%')
            $('select').parent().css('width','100%')
        },
        components: {
            Carousel,
            Slide,
            Multiselect
        },
        methods: {
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1)
            },
            handleFile(event) {
                const file = event
                console.log(file)
                if (!/\.(jpg|jpeg|png)$/i.test(file[0].name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedFile = reader.result
                })
            },
            handleMainImage(event) {
                const file = event
                console.log(file)
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedLogo = reader.result
                })
            },
            getData(){
                this.isLoading = true
                getPhase(this.id).then(response=>{
                    console.log(response)
                    this.phase = response.data.phase
                    this.isLoading = false
                })
                .catch(error => {
                    console.log(error)
                })
            },
            dateFormatter(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.delivery_date = year
                return date
            },
            getFacilities(){
                getFacilities().then(response=>{
                    console.log("TEST",response)
                    this.facilities = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            // getPhaseFacilities(){
            //     var data = {
            //         '_token': this.token,
            //         'phase_id': this.id
            //     }
            //     getPhaseFacilities(data).then(response=>{
            //         this.phase.facilities = response.data
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
            // },
            updatePhase(){
                const bodyFormData = new FormData();
                bodyFormData.append("_token",this.token);
                const data = this.phase
                Object.keys(data).forEach(function(key) {
                    bodyFormData.append(key,data[key]);
                    console.log(key, data[key]);
                });
                bodyFormData.append("_method", "put");
                const facilities = this.phase.facilities
                if(facilities != null){
                    for (var i = 0; i < facilities.length; i++) {
                        console.log(facilities[i])
                        bodyFormData.append('facility[]', JSON.stringify(facilities[i]['id']));
                    }
                }
                bodyFormData.delete('facilities');
                updatePhase(bodyFormData,this.id).then(response=>{
                    console.log(response)
                    this.success("Updated")
                })
                .catch(error => {
                    this.errorDialog()
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
        }
}
</script>

<style scoped>
    .column{
        margin-bottom:10px;
    }
    #texteditor h2{
        font-size: 1.5em;
        font-weight: bold;
    }
    #texteditor h3{
        font-size: 1.17em;
        font-weight: bold;
    }
    #texteditor h4{
        font-size: 16px;
        font-weight: bold;
    }
    #texteditor > div > div.ck.ck-editor__main > div ul{
        list-style:initial;
        display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;   
    }
    
    #texteditor > div > div.ck.ck-editor__main > div ol{
        display: block;
        list-style-type: decimal;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }
    #contact_wrapper{
        display:flex;
        flex-wrap:wrap;
    }
    #contact{
        margin-top:10px;
        margin-bottom:10px;
    }
    /* span .select,select{
        width:100%
    } */

</style>
