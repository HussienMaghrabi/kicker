
<template>
    <div class="container is-fluid">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Upload Lead Data Excel
                        </p>
                    </div>
                </div>
                <div class="level">
                    <div class="level-item">
                        <form action="lead_data_xls" method="post" style="margin-top:10px;margin-bottom:10px"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" :value="csrf">                                
                            <button type="submit" class="button is-success is-meduim mr-10 import-excel" >                
                                Download Lead Data Excel Guide
                            </button>
                        </form>
                    </div>
                </div>

            </header>
            <div class="columns is-multiline is-mobile mb-5 ml-0" style="flex-direction: column;justify-content: center;align-items: center;padding: 50px;">
                <b-field>
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
                                <p>Drop your files here or click to upload</p>
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
                <button type="button" class="button is-success is-meduim mr-10 import-excel" @click="uploadLeadDataExcel">Import Leads Data</button>
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    </div>
</template>

<script>
import {uploadLeadDataExcel} from './../../calls'
 export default {
    data() {
        return {
            dropFiles: [],
            uploadedFile: '',
            loading: false,
            isFullPage: true,
            csrf: window.auth_user.csrf,
            isLoading: false,
            token: window.auth_user.csrf,
        }
    },
    components: {
    },
    methods: {
        deleteDropFile(index) {
            this.dropFiles.splice(index, 1)
        },
        handleFile(event) {
            const file = event
            console.log(file)
            if (!/\.(xls|xlsx|csv)$/i.test(file[0].name)) {
                alert('Your choice is not an excel sheet')
                return prevent()
            }
            var reader = new FileReader
            reader.addEventListener('load', () => {
                this.uploadedFile = reader.result
            })
        },
        uploadLeadDataExcel(){
            if(this.dropFiles.length > 0){
                    this.isLoading = true
                    const data = new FormData();
                    data.append("ExSheet",this.dropFiles[0]);
                    data.append("_token",this.csrf);
                    uploadLeadDataExcel(data).then(response=>{
                    console.log(response)
                    this.isLoading = false
                    this.success('Saved')
                    // window.location.href = "/admin/lead_summaries#/1"
                })
                .catch(error => {
                    this.errorDialog();
                    console.log(error)
                })
            }else{
                console.log('No Files Uploaded')
            }
        },
        errorDialog() {
            this.$dialog.alert({
                title: 'Error',
                message: 'Please Check Leads Data Excel File and make sure to provide the required inputs',
                type: 'is-danger',
            })
        },
        success(action) {
            this.$toast.open({
                message: 'Leads Data '+action+' Successfully',
                type: 'is-success',
                position: 'is-bottom',
                duration: 5000,
            })
        },

    }
}
</script>

<style>

</style>
