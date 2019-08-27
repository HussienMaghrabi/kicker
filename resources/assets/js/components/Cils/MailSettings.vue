<template>
    <div>
        <div class="level mb-5">
            <div class="level">
                <div class="level-item">

                </div>
            </div>            
        </div>
        <div class="container is-fluid">
            <div class="card">
                <header class="card-header level ">
                    <div class="level">
                        <div class="level-item">
                            <p class="card-header-title">
                                Cil Mail Settings
                            </p>
                        </div>
                    </div>
                </header>
                <div class="content-wrapper" style="padding: 1rem 1.5rem 1rem;">
                    <div class="columns is-multiline is-mobile">
                        <b-field label="Email" class="column is-6">
                            <b-input type="email" :value="email" :disabled="true"></b-input>
                        </b-field>

                        <b-field label="Password" class="column is-6">
                            <b-input type="password"
                                password-reveal
                                :value="password"
                                :disabled="true">
                            </b-input>
                        </b-field>
                        <b-field label="CC" class="column is-12">
                            <multiselect v-model="mail_cc" tag-placeholder="Add this as new email" placeholder="Add an email" label="value" track-by="code" :options="mail_options" :multiple="true" :taggable="true" @tag="addEmail"></multiselect>
                        </b-field>

                        <b-field label="Accepted Keywords" class="column is-6">
                            <multiselect v-model="accepted_keywords" tag-placeholder="Add this as accepted keyword for cil" placeholder="Add accepted keyword" label="value" track-by="code" :options="accepted_keywords_options" :multiple="true" :taggable="true" @tag="addAcceptedKeyword"></multiselect>
                        </b-field>

                        <b-field label="Rejected Keywords" class="column is-6">
                            <multiselect v-model="rejected_keywords" tag-placeholder="Add this as rejected keyword for cil" placeholder="Add rejected keyword" label="value" track-by="code" :options="rejected_keywords_options" :multiple="true" :taggable="true" @tag="addRejectedKeyword"></multiselect>
                        </b-field>

                        <b-field label="Signature" class="column is-12" id="signature"> 
                            <ckeditor :editor="editor" v-model="signatureData" tag-name="textarea"></ckeditor>
                        </b-field>
                        <b-field label="Message" class="column is-12" id="message"> 
                            <ckeditor :editor="editor" :config="editorConfig" v-model="messageData" tag-name="textarea"></ckeditor>
                            <!-- <textarea name="content" id="editor">
                                &lt;p&gt;This is some sample content.&lt;/p&gt;
                            </textarea> -->
                        </b-field>
                        <b-button type="is-info" @click="saveCilSettings">Save</b-button>

                    </div>
                </div>
            </div>
        </div>

        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
    import Multiselect from 'vue-multiselect'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    // import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';
    import {getCils,getCilSettings,getUserEmails,getEmailsAutocomplete,saveCilSettings,getCilEmails,getCilAcceptedKeywords,getCilRejectedKeywords} from './../../calls'

    export default {
        data() {
            return {
                isLoading: false,
                isFullPage: true,
                selectedCils: [],
                token: window.auth_user.csrf,
                userId: window.auth_user.id,
                userType: window.auth_user.type,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(window.location.href.split("/").pop(-1)),
                perPage: 100,
                cils: [],
                isEmpty: false,
                cilsCurrentNumber: 0,
                cilsTotalNumber: 0,
                cilIds: [],
                ShowHint: false,
                hintId: '',
                reloadData: false,
                flag: 0,
                url: window.location.href,
                users:[],
                selectedUsers: [],
                email: null,
                password: null,
                mail_cc: [],
                mail_options: [],
                mail: '',
                accepted_keywords:[],
                accepted_keywords_options:[],
                rejected_keywords:[],
                rejected_keywords_options:[],
                openOnFocus: false,
                settings: [],
                editor: ClassicEditor,
                signatureData: '',
                messageData:'',
                
                editorConfig: {
                    // toolbar: [ 'bold', 'italic', '|', 'link' ],
                    // plugins: [CKFinder],
                    // toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote','ckfinder', 'imageUpload' ],
                    // heading: {
                    //     options: [
                    //         { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    //         { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    //         { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    //     ]
                    // },
                    // ckfinder: {
                    //     // options: {
                    //     //     resourceType: 'Images'
                    //     // }
                    // }
                }
                
            }
        },
        mounted() {
            this.getData()
        },
        components: {
            Multiselect
        },
        methods: {
            getData(loading = true){
                this.isLoading = loading
                this.users = window.users
                this.getCilSettings();
                this.getCilEmails();
                this.isLoading = false
            },
            getCilSettings(){
                getCilSettings().then(response=>{
                    this.email = response.data.settings.cil_email
                    this.password = response.data.settings.cil_password
                    this.signatureData = response.data.editors_data.signature
                    this.messageData = response.data.editors_data.message
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
            },
            addEmail(newEmail) {
                const email = {
                    value: newEmail,
                    code: newEmail.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.mail_options.push(email)
                this.mail_cc.push(email)
            },
            addAcceptedKeyword(newKeyword) {
                const keyword = {
                    value: newKeyword,
                    code: newKeyword.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.accepted_keywords_options.push(keyword)
                this.accepted_keywords.push(keyword)
            },
            addRejectedKeyword(newKeyword) {
                const keyword = {
                    value: newKeyword,
                    code: newKeyword.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.rejected_keywords_options.push(keyword)
                this.rejected_keywords.push(keyword)
            },
            saveCilSettings(){
                const mailCC = this.mail_cc.map((email) => {
                        return email.value;
                });
                const acceptedKeywords = this.accepted_keywords.map((keyword) => {
                        return keyword.value;
                });
                const rejectedKeywords = this.rejected_keywords.map((keyword) => {
                        return keyword.value;
                });
                
                var data ={
                    '_token':this.token,
                    'emails':mailCC,
                    'signature':this.signatureData,
                    'accepted_keywords':acceptedKeywords,
                    'rejected_keywords':rejectedKeywords,
                    'message':this.messageData
                };
                saveCilSettings(data).then(response=>{
                    console.log(response)
                    this.success('Updated')
                })
                .catch(error => {
                    console.log(error)
                    this.errorDialog()
                })
            },
            getCilEmails(){
                getCilEmails().then(response=>{
                    const responseOptions = response.data.map((option) => {
                        return {
                            value: option.email,
                            key: option.id,
                        };
                    });
                    this.mail_cc = responseOptions
                    console.log("Testttsdsad: ",response)
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getCilAcceptedKeywords(){
                getCilAcceptedKeywords().then(response=>{
                    const responseOptions = response.data.map((option) => {
                        return {
                            value: option.keyword,
                            key: option.id,
                        };
                    });
                    this.accepted_keywords = responseOptions
                    console.log("Testttsdsad: ",response)
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getCilRejectedKeywords(){
                getCilRejectedKeywords().then(response=>{
                    const responseOptions = response.data.map((option) => {
                        return {
                            value: option.keyword,
                            key: option.id,
                        };
                    });
                    this.rejected_keywords = responseOptions
                    console.log("Testttsdsad: ",response)
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
                    message: 'Mail Settings '+action+' Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
        }
    }
</script>

<style type="text/css" scoped="">

.cils-number
{
    position: absolute;
    left: 200px;
    bottom: 17.5vh;

}

@media screen and (max-width: 767px) {
    .cils-number{
        right: 10% !important;
        left: 285px !important;
    }
}
</style>

<style type="text/css">
    #message h2 ,#signature h2{
        font-size: 1.5em;
        font-weight: bold;
    }
    #message h3 ,#signature h3{
        font-size: 1.17em;
        font-weight: bold;
    }
    #message h4 ,#signature h3{
        font-size: 16px;
        font-weight: bold;
    }
    #message > div > div.ck.ck-editor__main > div ul{
        list-style:initial;
        display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;   
    }
    #signature > div > div.ck.ck-editor__main > div ul{
        list-style:initial;
        display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;   
    }
    
    #message > div > div.ck.ck-editor__main > div ol{
        display: block;
        list-style-type: decimal;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }
    #signature > div > div.ck.ck-editor__main > div ol{
        display: block;
        list-style-type: decimal;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }
    
</style>
