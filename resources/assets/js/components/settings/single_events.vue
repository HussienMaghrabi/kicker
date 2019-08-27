<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            EDIT EVENTS
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="English title">
                                <b-input placeholder="English title" v-model="singleData.en_title" :disabled="disabled"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Arabic title">
                                <b-input placeholder="Arabic title" v-model="singleData.ar_title" :disabled="disabled"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="English Description">
                                <b-input v-model="singleData.en_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Arabic Description">
                                <b-input v-model="singleData.ar_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding text-center">
                        <div class="column is-3" style="margin:auto">
                            <b-field label="Main image">
                                <b-upload v-model="singleimage"
                                    :disabled="disabled"
                                    multiple
                                    drag-drop>
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <p>
                                                <b-icon
                                                    icon="upload"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Drop your files here or click to upload</p>
                                        </div>
                                    </section>
                                </b-upload>
                            </b-field>
                            <div class="tags">
                                <span v-for="(file, index) in singleimage" :key="index" class="tag is-primary">
                                    {{file.name}}
                                    <button
                                    class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)"
                                    ></button>
                                </span>
                            </div>
                        </div>
                        <div class="column is-3" style="margin:auto">
                            <b-field label="Other images">
                                <b-upload v-model="multiimages"
                                    :disabled="disabled"
                                    multiple
                                    drag-drop>
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <p>
                                                <b-icon
                                                    icon="upload"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Drop your files here or click to upload</p>
                                        </div>
                                    </section>
                                </b-upload>
                            </b-field>
                            <div class="tags">
                                <span v-for="(file, index) in multiimages" :key="index" class="tag is-primary">
                                    {{file.name}}
                                    <button
                                    class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)"
                                    ></button>
                                </span>
                            </div>
                        </div>
                        <div class="column is-3" style="margin:auto">
                            <b-field label="Pdf file">
                                <b-upload v-model="uploadpdf"
                                    :disabled="disabled"
                                    multiple
                                    drag-drop>
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <p>
                                                <b-icon
                                                    icon="upload"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Drop your files here or click to upload</p>
                                        </div>
                                    </section>
                                </b-upload>
                            </b-field>
                            <div class="tags">
                                <span v-for="(file, index) in uploadpdf" :key="index" class="tag is-primary">
                                    {{file.name}}
                                    <button
                                    class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)"
                                    ></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="Select a date">
                                <b-datepicker
                                    :disabled="disabled"
                                    v-model="singleData.date"
                                    placeholder="Click to select..."
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>
                        </div>
                        <div class="columns is-5" style="margin:auto 10rem">
                            <div class="column is-4">
                                <b-field label="Event">
                                    <div class="field" >
                                        <b-switch v-model="singleData.event"
                                            :disabled="disabled"
                                            true-value="1"
                                            false-value="0">
                                            {{ singleData.event }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Blog">
                                    <div class="field" >
                                        <b-switch v-model="singleData.news"
                                            :disabled="disabled"
                                            true-value="1"
                                            false-value="0">
                                            {{ singleData.news }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="launch">
                                    <div class="field" >
                                        <b-switch v-model="singleData.launch"
                                            :disabled="disabled"
                                            true-value="1"
                                            false-value="0">
                                            {{ singleData.launch }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                        </div>
                        <div class="column is-1">
                            <a target="blank" :href="'/uploads/'+singleData.pdf"> PDF Link </a>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="Meta Keywords">
                                <b-input v-model="singleData.meta_keywords" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Meta Description">
                                <b-input v-model="singleData.meta_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-6 text-center">
                            <b-field label="preview main image">
                                <img :src="'/uploads/'+singleData.image" alt="" style="height: 100%; width: 100%;">
                            </b-field>
                        </div>
                        <div class="column is-6 text-center">
                            <b-field label="preview Other images">
                                <carousel :per-page="1" :navigationEnabled="true" :paginationEnabled="true" :autoplay="true" :loop="true">
                                    <slide v-for="image in images" :key="image.id">
                                        <img :src="'/uploads/' + image.image" style="height: 100%; width: 100%;">
                                    </slide>
                                </carousel>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12 text-center">
                            <b-button type="is-info"
                                @click="updateEvent"
                                :disabled="disabled"
                                icon-left="send">
                                Update now
                            </b-button>
                        </div>
                    </div>
                </section>
                <!-- begin data -->
                <!-- end data -->
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
    margin-bottom: 3rem
}
</style>
<script>
import {
    singleEventData,
    updateEventByid
} from './../../calls'
import { Carousel, Slide } from "vue-carousel"
export default {
    data() {
            return {
                singleData:[],
                images:[],
                singleimage:[],
                multiimages:[],
                uploadpdf:[],
                disabled:true,
                isFullPage:false,
                isLoading:true,
                id:null,
            }
        },
        components:{
            Carousel,
            Slide
        },
        created() {
            this.id = this.$route.params.id
            console.log(this.id)
        },
        mounted(){
            this.getsingleEventData()
        },
        methods: {
            getsingleEventData(){
                singleEventData(this.id).then(response=>{
                    this.singleData = response.data.Event
                    this.images = response.data.images
                    console.log("this singe event data",response)
                    this.isLoading = false
                })
            },
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            updateEvent(){
                const bodyFormData = new FormData();
                for (let key in this.singleData) {
                    const value = this.singleData[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('event_id',this.id)
                bodyFormData.append('main_image',this.singleimage[0])
                bodyFormData.append('pdf_file',this.uploadpdf[0])
                for (var i = 0; i < this.multiimages.length; i++) {
                    bodyFormData.append('other_images[]', this.multiimages[i]);
                }
                updateEventByid(bodyFormData).then(response=>{
                    this.isLoading = true
                    this.getsingleEventData()
                    this.alertsuccess('Blog is up to date ')
                }).catch(error=>{
                    console.log(error)
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