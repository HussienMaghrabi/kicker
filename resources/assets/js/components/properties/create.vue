<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Add Property
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
                                    <b-input type="text" v-model="property.en_name" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input type="text" v-model="property.ar_name" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Usage">
                                    <b-select v-model="property.type">
                                        <option value="personal">Residential</option>
                                        <option value="commercial">Commercial</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Type">
                                    <b-select v-model="property.unit_id">
                                        <option :value="type.id" v-for="type in unitTypes" :key="type.id">{{type.en_name}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="card" style="width:100%">
                                <header class="card-header level">
                                    <div class="level">
                                        <div class="level-item">
                                            <p class="card-header-title">
                                                Price
                                            </p>
                                        </div>
                                    </div>
                                </header>
                                <div class="card-content">
                                    <div class="column is-6">
                                        <b-field label="From">
                                            <b-input type="number" v-model="property.start_price"/>
                                        </b-field>
                                    </div>
                                    <div class="column is-6">
                                        <b-field label="Price / Meter">
                                            <b-input type="number" v-model="property.meter_price" />
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="width:100%">
                                <header class="card-header level">
                                    <div class="level">
                                        <div class="level-item">
                                            <p class="card-header-title">
                                                Area
                                            </p>
                                        </div>
                                    </div>
                                </header>
                                <div class="card-content">
                                    <div class="column is-6">
                                        <b-field label="From">
                                            <b-input type="number" v-model="property.area_from"/>
                                        </b-field>
                                    </div>
                                    <div class="column is-6">
                                        <b-field label="To">
                                            <b-input type="number" v-model="property.area_to"/>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input type="textarea" maxlength="200" v-model="property.en_description"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Description">
                                    <b-input type="textarea" maxlength="200" v-model="property.ar_description"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Main Image" class="file" style="display:flex;flex-direction:column">
                                    <b-upload v-model="property.main_image"
                                    @input="handleMainImage">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="property.main_image">
                                        {{ property.main_image.name }}
                                    </span>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Other Images">
                                    <b-upload v-model="dropFiles"
                                        multiple
                                        @input="handleFile"
                                        drag-drop>
                                        <section class="section">
                                            <div class="content has-text-centered">
                                                <p>
                                                    <b-icon
                                                        icon="upload"
                                                        size="is-large">
                                                    </b-icon>
                                                </p>
                                                <p>Drop your Images here or click to upload</p>
                                            </div>
                                        </section>
                                    </b-upload>
                                </b-field>
                                <div class="tags">
                                    <span v-for="(file, index) in dropFiles"
                                        :key="index"
                                        class="tag is-primary" >
                                        {{file.name}}
                                        <button class="delete is-small"
                                            type="button"
                                            @click="deleteDropFile(index)">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="column is-12">
                                <button type="button" class="button is-primary is-meduim mr-10 import-excel" @click="storeProperty">Submit</button>
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
<script>
import {storeProperty,getUnitTypes,getFacilities} from './../../calls'
import { Carousel, Slide } from "vue-carousel";
export default {
    name: "createProperty",
    props: {
        phase: Object
    },
    data() {
            return {
                property: {},
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                historyPrices: [],
                propertyImages: [],
                imageUrl: '',
                unitTypes: [],
                dropFiles: [],
            }
        },
        created() {
        },
        mounted() {
            console.log(this.phase)
            $('select').css('width','100%')
            $('select').parent().css('width','100%')
        },
        components: {
            Carousel,
            Slide
        },
        watch: {
            'property.type': function() {
                this.getUnitTypes();
            },
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
            storeProperty(){
                const bodyFormData = new FormData();
                bodyFormData.append("_token",this.token);
                const data = this.property
                Object.keys(data).forEach(function(key) {
                    bodyFormData.append(key,data[key]);
                    console.log(key, data[key]);
                });
                bodyFormData.append("phase_id",this.phase.id);
                bodyFormData.append("portal_id",this.phase.project_id);
                bodyFormData.append("main_image",this.property.main_image);

                const images = this.dropFiles
                if(images != null || images.length > 0){
                    for (var i = 0; i < images.length; i++) {
                        bodyFormData.append('images[]', images[i]);
                    }
                }
                storeProperty(bodyFormData).then(response=>{
                    console.log(response)
                    this.success("Saved")
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
            },
            getUnitTypes(){
                console.log("TEST")
                var data = {
                    '_token': this.token,
                    'usage': this.property.type
                }
                getUnitTypes(data).then(response=>{
                    this.unitTypes = response.data
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
