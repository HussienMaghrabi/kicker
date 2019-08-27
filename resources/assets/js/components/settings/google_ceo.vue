<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            <strong> <span class="fa fa-google"></span> </strong> <small> oogle seo </small>
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                 <i style="float:right;  color: #724a03; font-size: 1.5rem; cursor: pointer" class="fas fa-edit" @click="toggleInputsActive"></i>
                </section>
                <section>
                    <div class="columns">
                          <div class="column is-6">
                            <b-field label="Keywords in Arabic">
                                <multiselect :disabled="disabled" v-model="arKeywords" tag-placeholder="Add this as new email" placeholder="Add keywords in english" label="name" @tag="addArabicKeyword" track-by="id" :options="arKeywords" :multiple="true" :taggable="true"></multiselect>
                            </b-field>
                          </div>
                          <div class="column is-6">
                            <b-field label="Keywords in English">
                                <multiselect :disabled="disabled" v-model="enKeywords" tag-placeholder="Add this as new email" placeholder="Add keywords in arabic" label="name" @tag="addEnglishKeyword" track-by="id" :options="enKeywords" :multiple="true" :taggable="true"></multiselect>
                            </b-field>
                          </div>
                    </div>
                    <!-- text area meta content -->
                    <div class="columns">
                          <div class="column is-6">
                            <b-field label="content in Arabic">
                                <b-input :disabled="disabled" v-model="seo.meta_ar" maxlength="200" type="textarea"></b-input>
                            </b-field>
                          </div>
                          <div class="column is-6">
                            <b-field label="Content in english">
                                <b-input :disabled="disabled" v-model="seo.meta_en" maxlength="200" type="textarea"></b-input>
                            </b-field>
                          </div>
                    </div>
                    <!-- end text area meta content -->
                    <!-- java script seo -->
                    <div class="columns">
                          <div class="column is-6">
                            <b-field label="google javascript">
                                <b-input :disabled="disabled" v-model="seo.google_js_f" maxlength="200" type="textarea"></b-input>
                            </b-field>
                          </div>
                          <div class="column is-6">
                            <b-field label="google javascript">
                                <b-input :disabled="disabled" v-model="seo.google_js_s" maxlength="200" type="textarea"></b-input>
                            </b-field>
                          </div>
                    </div>
                    <!-- end script seo -->
                    <hr>
                    <div class="columns">
                        <div class="column is-12">
                            <b-button type="is-success"
                                @click="updateSeo"
                                icon-left="pen">
                                Edit
                            </b-button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import Multiselect from 'vue-multiselect'
import {
    getSeo,
    get_ar_words,
    get_en_words,
    updatefirstseo,
} from './../../calls'
export default {
    data() {
        return {
            isLoading:true,
            isFullPage:false,
            setting:[],
            seo:[],
            arKeywords:[],
            enKeywords:[],
            isLoading:true,
            disabled:true,
        }
    },
    components: {
        Multiselect
    },
    created(){
        this.testfun()
    },
    mounted(){
        this.getSeoSetting()
        this.getEnglishWords()
    },
    methods: {
        testfun(){
            // console.log('asjd')
            console.log('sadsadksadiadsa')
            get_ar_words().then(response=>{
                this.arKeywords = response.data
                console.log('get_ar_words',response)
            }).catch(error=>{
                console.log(error)
            })
        },
        toggleInputsActive(){
            this.disabled = !this.disabled
        },
        getEnglishWords(){
            get_en_words().then(response=>{
                this.enKeywords = response.data
                console.log('get_en_words',response)
            }).catch(error=>{
                console.log(error)
            })
        },
        getArabicWords(){
            // console.log('sadsadksadiadsa')
            get_ar_words().then(response=>{
                this.arKeywords = response.data
                console.log('get_ar_words',response)
            }).catch(error=>{
                console.log(error)
            })
        },

        updateSeo(){
            // this.isLoading = true
                const bodyFormData = new FormData();
            for (let key in this.seo) {
                let value = this.seo[key]
                bodyFormData.set(key,value)
            }
            for (let i = 0; i < this.arKeywords.length; i++) {
                bodyFormData.append('AR_Keywords[]', JSON.stringify(this.arKeywords))
                bodyFormData.append('EN_Keywords[]', JSON.stringify(this.enKeywords))
            }
            updatefirstseo(bodyFormData).then(response=>{
                this.isLoading = false
                this.alertsuccess('seo is up to date')
                this.getSeoSetting()
            }).catch(error=>{
                this.alerterror0('seo have some error')
                console.log(error)
            })
        },
        getSeoSetting(){
            getSeo().then(response=>{
                // console.log('data',response)
                this.seo = response.data
                this.isLoading = false
                console.log(response)
            }).catch(error=>{
                console.log(error)
            })
        },
        // getKeyWords(){
        //     getAllKeyWords().then(response=>{
        //         this.keyword = response.data
        //         console.log('keywords',this.keyword)
        //     }).catch(error=>{
        //         console.log(error)
        //     })
        // },

            getArabicWords(){

            },
            addArabicKeyword(newKeyword) {
                const keyword = {
                    name: newKeyword,
                    id: newKeyword.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.arKeywords.push(keyword)
                // this.name.push(keyword)
            },
            addEnglishKeyword(newKeyword) {
                const keyword = {
                    name: newKeyword,
                    id: newKeyword.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.enKeywords.push(keyword)
                // this.en_keywords.push(keyword)
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
    },
}
</script>
