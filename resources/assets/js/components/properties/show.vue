<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Show Property
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editProperty" class="fas fa-edit" @click="toggleInputsActive"></i>                
                    <div class="column first">
                        <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-12">
                                <div class="owl-carousel owl-theme">
                                    <carousel :per-page="1" :navigationEnabled="true" :paginationEnabled="true" :autoplay="true" :loop="true">
                                        <slide style="padding-top: 1%;" v-for="image in propertyImages" :key="image.id">
                                            <img :src="'/uploads/' + image.images" style="height: 600px; width: 100%;" alt="Image Not Found">
                                        </slide>
                                    </carousel>
                                </div>
                            </div>
                            <div class="column is-6">
                                <b-field label="Code">
                                    <b-input type="text" v-model="property.code" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Name">
                                    <b-input type="text" v-model="property.en_name" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input type="text" v-model="property.ar_name" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Type">
                                    <b-select v-model="property.unit_id" :disabled="disabled">
                                        <option :value="type.id" v-for="type in unitTypes" :key="type.id">{{type.name}}</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input v-model="property.en_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input v-model="property.ar_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Price / Meter">
                                    <b-input type="number" v-model="property.meter_price" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Unit Price">
                                    <b-input type="number" v-model="property.start_price" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="card" style="width:100%">
                                <header class="card-header level">
                                    <div class="level">
                                        <div class="level-item">
                                            <p class="card-header-title">
                                                History
                                            </p>
                                        </div>
                                    </div>
                                </header>
                                <div class="card-content">
                                    <div class="column is-12" v-for="price in historyPrices">
                                        <div class="column is-6">
                                            <b-field label="Price">
                                                <b-input type="text" v-model="price.price" disabled />
                                            </b-field>
                                        </div>
                                        <div class="column is-6">
                                            <b-field label="Date">
                                                <b-input type="text" v-model="price.created_at" disabled />
                                            </b-field>
                                        </div>
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
                                    <div class="column is-12">
                                        <div class="column is-6">
                                            <b-field label="Clear">
                                                <b-input type="text" v-model="property.area_from" disabled />
                                            </b-field>
                                        </div>
                                        <div class="column is-6">
                                            <b-field label="Garden">
                                                <b-input type="text" v-model="property.area_to" disabled />
                                            </b-field>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-12" v-if="disabled==false">
                                <b-field label="Usage">
                                    <b-select v-model="property.type">
                                        <option value="personal">Residential</option>
                                        <option value="commercial">Commercial</option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column is-6" v-if="disabled==false">
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
                            <div class="column is-6" v-if="disabled==false">
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
                                <button type="button" class="button is-primary is-meduim mr-10 import-excel" @click="updateProperty" v-if="disabled==false">Submit</button>
                            </div> 
                        </div>
                    </div> 
                </section>
                <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
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
import {getProperty,updateDeveloper,updateProperty} from './../../calls'
import { Carousel, Slide } from "vue-carousel";
export default {
    data() {
            return {
                property: {},
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                isFullPage: true,
                historyPrices: [],
                propertyImages: [],
                imageUrl: '',
                unitTypes: [],
                dropFiles: []
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getData()
            $('select').css('width','100%')
            $('select').parent().css('width','100%')
        },
        components: {
            Carousel,
            Slide
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
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    getProperty(this.id).then(response=>{
                        console.log(response)
                        this.property = response.data.property
                        this.historyPrices = response.data.prices
                        this.propertyImages = response.data.images
                        this.unitTypes = response.data.unitTypes
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
            updateProperty(){
                const bodyFormData = new FormData();
                bodyFormData.append("_token",this.token);
                const data = this.property
                Object.keys(data).forEach(function(key) {
                    bodyFormData.append(key,data[key]);
                    console.log(key, data[key]);
                });
                const images = this.dropFiles
                if(images != null || images.length > 0){
                    for (var i = 0; i < images.length; i++) {
                        bodyFormData.append('images[]', images[i]);
                    }
                }
                bodyFormData.append("_method", "put");
                updateProperty(bodyFormData,this.id).then(response=>{
                    console.log(response)
                    this.getData()
                    this.success("Updated")
                })
                .catch(error => {
                    this.errorDialog()
                    console.log(error)
                })
                // data.append("en_name",this.developer.en_name);
                // data.append("ar_name",this.developer.ar_name);
                // data.append("en_description",this.developer.en_description);
                // data.append("ar_description",this.developer.ar_description);
                // data.append("email",this.developer.email);
                // data.append("phone",this.developer.phone);
                // data.append("image",this.file);
                // data.append("xls",this.xlsFile);
                // data.append("facebook",this.developer.facebook);
                // data.append("residential_commercial",this.selectedRC);
                // if(this.developer.cil_expire_date != null && this.developer.cil_expire_date != 'null'){
                //     data.append("cil_expire_date",this.developer.cil_expire_date);
                // }
                // data.append("image",this.file);
                // data.append("_token",this.token);
                // if(this.isFeatured == true){
                //     data.append("featured",1);
                // }else{
                //     data.append("featured",0);
                // }
                // const contactArr = this.contacts
                // if(this.contacts != null){
                //     for (var i = 0; i < contactArr.length; i++) {
                //         data.append('contacts[]', JSON.stringify(contactArr[i]));
                //     }
                // }

                // updateDeveloper(data,this.id).then(response=>{
                //     console.log(response)
                //     this.getData()
                //     this.success("Updated")
                // })
                // .catch(error => {
                //     this.errorDialog()
                //     console.log(error)
                // })
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
