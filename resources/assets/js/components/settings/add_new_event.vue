<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            ADD EVENTS
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="English title">
                                <b-input placeholder="English title" v-model="NewEvent.en_title" ></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Arabic title">
                                <b-input placeholder="Arabic title" v-model="NewEvent.ar_title" ></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="English Description">
                                <b-input v-model="NewEvent.en_description" maxlength="200" type="textarea" ></b-input>
                            </b-field>
                        </div>
                        <div class="column is-3">
                            <b-field label="Arabic Description">
                                <b-input v-model="NewEvent.ar_description" maxlength="200" type="textarea" ></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding text-center">
                        <div class="column is-6">
                            <b-field label="Main image">
                                <b-upload v-model="singleimage"
                                    
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
                        <div class="column is-3">
                            <b-field label="Other images">
                                <b-upload v-model="multiimages"
                                    
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
                        <div class="column is-3">
                            <b-field label="PDF file">
                                <b-upload v-model="pdf_file"
                                    
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
                                <span v-for="(file, index) in pdf_file" :key="index" class="tag is-primary">
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
                                    :date-formatter="dateFormatterFrom"
                                    v-model="NewEvent.date"
                                    placeholder="Click to select..."
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>
                        </div>
                        <div class="columns is-6" style="margin:auto 10rem">
                            <div class="column is-4">
                                <b-field label="Event">
                                    <div class="field" >
                                        <b-switch v-model="NewEvent.event"
                                            
                                            true-value="1"
                                            false-value="0">
                                            {{ NewEvent.event }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="Blog">
                                    <div class="field" >
                                        <b-switch v-model="NewEvent.news"
                                            
                                            true-value="1"
                                            false-value="0">
                                            {{ NewEvent.news }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                            <div class="column is-4">
                                <b-field label="launch">
                                    <div class="field" >
                                        <b-switch v-model="NewEvent.launch"
                                            
                                            true-value="1"
                                            false-value="0">
                                            {{ NewEvent.launch }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-6">
                            <b-field label="Meta Keywords">
                                <b-input v-model="NewEvent.meta_keywords" maxlength="200" type="textarea" ></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Meta Description">
                                <b-input v-model="NewEvent.meta_description" maxlength="200" type="textarea" ></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="columns padding">
                        <div class="column is-12 text-center">
                            <b-button type="is-info"
                                @click="storeEvent"
                                
                                icon-left="send">
                                save now
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
StoreNewEvent
} from './../../calls'
export default {
    data() {
            return {
                NewEvent:[],
                images:[],
                singleimage:[],
                multiimages:[],
                pdf_file:[],
                disabled:true,
                isFullPage:false,
                isLoading:false,
            }
        },
        components:{
        },
        created() {
        },
        mounted(){
        },
        methods: {
            storeEvent(){
                const bodyFormData = new FormData();
                for (let key in this.NewEvent) {
                    const value = this.NewEvent[key];
                    bodyFormData.set(key, value);
                }
                bodyFormData.append('main_image',this.singleimage[0])
                bodyFormData.append('pdf_file',this.pdf_file[0])
                for (var i = 0; i < this.multiimages.length; i++) {
                    bodyFormData.append('other_images[]', this.multiimages[i]);
                }
                bodyFormData.append('dateFormat',this.parsedDateFrom)
                StoreNewEvent(bodyFormData).then(response=>{
                    // this.isLoading = true
                    // location.href = '/admin/vue/events'
                }).catch(error=>{
                    console.log(error)
                })
            },
            dateFormatterFrom(dt){
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
        }
}
</script>