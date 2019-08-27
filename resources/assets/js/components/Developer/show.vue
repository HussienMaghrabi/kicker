<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Show Developer
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>                
                <div class="column first">
                    <div class="columns is-multiline is-mobile" style="margin-bottom:20px">
                            <div class="column is-6">
                                <b-field label="English Name">
                                    <b-input type="text" :value="developer.en_name" v-model="developer.en_name" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Arabic Name">
                                    <b-input type="text" :value="developer.ar_name" v-model="developer.ar_name" :disabled="disabled" />
                                </b-field>
                            </div>
  
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input :value="developer.en_description" v-model="developer.en_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="English Description">
                                    <b-input :value="developer.ar_description" v-model="developer.ar_description" maxlength="200" type="textarea" :disabled="disabled"></b-input>
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Email">
                                    <b-input type="text" :value="developer.email" v-model="developer.email" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Phone">
                                    <b-input type="text" :value="developer.phone" v-model="developer.phone" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <b-field label="Facebook">
                                    <b-input type="text" :value="developer.facebook" v-model="developer.facebook" :disabled="disabled" />
                                </b-field>
                            </div>
                            <div class="column is-6">
                                <div class="field">
                                    <b><label style="display:block">Is Featured: </label></b>
                                    <b-switch v-model="isFeatured" :disabled="disabled">
                                    </b-switch>
                                </div>
                            </div>
                            <div class="column is-6" v-if="disabled==false">
                                <div class="field">
                                    <b-field label="Cil Expire Date Type">
                                        <b-select placeholder="Select Type" :disabled='disabled' expanded required
                                            v-model="date_type">
                                            <option value="month">Month</option>
                                            <option value="week">Week</option>
                                            <option value="day">Day</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <div class="column is-6" v-if="disabled==false">
                                <div class="field">
                                    <b-field label="Date After :">
                                        <b-select placeholder="Times" expanded required v-model="date_times">
                                            <option v-for="index in 10" :key="index" :value="index">
                                                {{index}}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <div class="column is-6">
                                <b><label style="display:block">Logo: </label></b>
                                <img :src="'/uploads/'+developer.logo" style="width:200px;height:200px"/>
                            </div>
                            <div class="column is-6" v-if="disabled==false" style="display: flex;justify-content: space-evenly;align-items: center;">
                                <b><label style="display:block">Logo Upload: </label></b>
                                <b-field class="file">
                                    <b-upload v-model="file"
                                    @input="handleFile">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="file">
                                        {{ file.name }}
                                    </span>
                                </b-field>
                            </div>
                            <div class="column is-6" v-if="disabled==false" style="display: flex;justify-content: flex-start;align-items: center;">
                                <b><label style="display:block">Xls Email Format File: </label></b>
                                <b-field class="file">
                                    <b-upload v-model="xlsFile"
                                    @input="handleXlsFile">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                    <span class="file-name" v-if="xlsFile">
                                        {{ xlsFile.name }}
                                    </span>
                                </b-field>
                            </div>
                            <div class="column is-12" v-if="disabled==false">
                                <button class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="addContact({contact_name:'',contact_phone:'',contact_email:''})">Add new Contact</button>
                                <div id="contact_wrapper">
                                    <div v-for="contact in contacts" id="contact">
                                        <b-field label="Name" style="display:inline-block">
                                            <b-input type="text" v-model="contact.contact_name" :disabled="disabled" />
                                        </b-field>
                                        <b-field label="Phone" style="display:inline-block">
                                            <b-input type="text" v-model="contact.contact_phone" :disabled="disabled" />
                                        </b-field>
                                        <b-field label="Email" style="display:inline-block">
                                            <b-input type="text" v-model="contact.contact_email" :disabled="disabled" />
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-12" v-if="disabled==false">
                                <b-field label="TextEditor" class="column is-12" id="texteditor"> 
                                    <ckeditor :editor="editor" v-model="editorData" tag-name="textarea"></ckeditor>
                                </b-field>
                            </div>
                            <div class="column is-12">
                                <button type="button" class="button is-success is-meduim mr-10 import-excel" v-if="disabled==false" @click="updateDeveloper">Edit</button>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {getDeveloper,updateDeveloper} from './../../calls'
export default {
    data() {
            return {
                developer: null,
                isLoading: true,
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
                id: null,
                disabled: true,
                isFullPage: true,
                file: null,
                xlsFile: null,
                uploadedFile: '',
                uploadedXlsFile: '',
                agent_types: [],
                selectedAgentType: '',
                selectedRC: '',
                isFeatured: false,
                roles: [],
                selectedRole: '',
                editor: ClassicEditor,
                editorData: '',
                editorConfig: {},
                contacts:[
                    {
                        contact_name: '',
                        contact_phone: '',
                        contact_email: '',
                    }
                ],
                date_type: 'day',
                date_times: 1
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted() {
            this.getData()
        },
        components: {
            
        },
        methods: {
            handleFile(event) {
                const file = event
                console.log(file)
                if (!/\.(jpg|jpeg|png)$/i.test(file.name)) {
                    alert('Your choice is not an image')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedFile = reader.result
                })
            },
            handleXlsFile(event) {
                const file = event
                console.log(file)
                if (!/\.(xls|xlsx|csv|doc|docx|rtf)$/i.test(file.name)) {
                    alert('Your choice is not a sheet')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.uploadedXlsFile = reader.result
                })
            },
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            getData(){
                this.isLoading = true
                    getDeveloper(this.id).then(response=>{
                        console.log(response)
                        this.developer = response.data
                        this.editorData = response.data.message
                        if(response.data.featured == 1){
                            this.isFeatured = true
                        }else{
                            this.isFeatured = false
                        }
                        // this.selectedAgentType = response.data.source_id
                        // this.selectedRC = response.data.residential_commercial
                        // this.selectedRole = response.data.role_id
                        // if(response.data.type == "admin"){
                        //     this.isFeatured = true
                        // }else{
                        //     this.isFeatured = false
                        // }
                        this.isLoading = false
                    })
                .catch(error => {
                    console.log(error)
                })
            },
            updateDeveloper(){
                const data = new FormData();
                var cil_expire_date;
                if(this.date_type == 'month'){
                    cil_expire_date = 30 * this.date_times
                }
                else if(this.date_type == 'week'){
                    cil_expire_date = 7 * this.date_times
                }
                else{
                    cil_expire_date = this.date_times
                }
                data.append("en_name",this.developer.en_name);
                data.append("ar_name",this.developer.ar_name);
                data.append("en_description",this.developer.en_description);
                data.append("ar_description",this.developer.ar_description);
                data.append("email",this.developer.email);
                data.append("phone",this.developer.phone);
                data.append("image",this.file);
                data.append("xls",this.xlsFile);
                data.append("facebook",this.developer.facebook);
                data.append("residential_commercial",this.selectedRC);
                data.append("cil_expire_date",cil_expire_date);
                data.append("image",this.file);
                data.append("message",this.editorData);
                data.append("_token",this.token);
                if(this.isFeatured == true){
                    data.append("featured",1);
                }else{
                    data.append("featured",0);
                }
                const contactArr = this.contacts
                if(this.contacts != null){
                    for (var i = 0; i < contactArr.length; i++) {
                        data.append('contacts[]', JSON.stringify(contactArr[i]));
                    }
                }

                updateDeveloper(data,this.id).then(response=>{
                    console.log(response)
                    this.getData()
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
            addContact(contact) {
                this.contacts.push(contact);
            }
            
            
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

</style>
