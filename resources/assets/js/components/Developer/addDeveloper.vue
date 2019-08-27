<template>
    <div class="container style">
            <div class="modal-card" style="width: auto">
                    <b class="modal-card-title"> Add Developer</b><br>
                <section>
                    
                    <b-field label="English Name">
                         <b-input type="text" v-model="en_name"></b-input>
                    </b-field>

                    <b-field label="Arabic Name">
                         <b-input type="text" v-model="ar_name"></b-input>
                    </b-field>

                    <b-field label="English Description">
                        <b-input type="textarea" v-model="en_description"></b-input>
                    </b-field>

                    <b-field label="Arabic Description">
                        <b-input type="textarea" v-model="ar_description"></b-input>
                    </b-field>

                    <b-field label="Facebook">
                        <b-input type="text" v-model="facebook"></b-input>
                    </b-field>

                    <b-field>
                        <b-switch v-model="featured"><b>Is Featured</b></b-switch>
                    </b-field>

                    <div class="column is-6">
                        <b-field class="file" label="Logo">
                            <b-upload v-model="logo"
                            @input="handleFile">
                                <a class="button is-primary">
                                    <b-icon icon="upload"></b-icon>
                                    <span>Click to upload</span>
                                </a>
                            </b-upload>
                            <span class="file-name" v-if="logo">
                                {{ logo.name }}
                            </span>
                        </b-field>
                    </div>

                    <div class="column is-6">
                        <b-field class="file" label="Xls Email Format File:">
                            <b-upload v-model="xls">
                                <a class="button is-primary">
                                    <b-icon icon="upload"></b-icon>
                                    <span>Click to upload</span>
                                </a>
                            </b-upload>
                            <span class="file-name" v-if="xls">
                                {{ xls.name }}
                            </span>
                        </b-field>
                    </div>

                    <b-field label="Phone">
                        <b-input type="number" v-model="phone"></b-input>
                    </b-field>

                    <b-field label="Email">
                        <b-input type="email" v-model="email"></b-input>
                    </b-field>
                    <br>
                    
                </section>
                <b-button @click="addDeveloper" type="is-info">Submit</b-button>
            </div>
    </div>
</template>

<script>
import {addDeveloper} from './../../calls'
export default {
    data() {
            return {
                en_name:null,
                ar_name:null,
                en_description:null,
                ar_description:null,
                facebook:null,
                image: null,
                uploadedFile: '',
                imageUrl: '',
                logo:null,
                phone:null,
                email:null,
                featured: false,
                token: window.auth_user.csrf,
                isLoading: true,
                xls:null
            }},
    mounted() {
    },
 methods: {
     handleFile(event) {
        const logo = event
        console.log(logo)
        this.imageUrl = URL.createObjectURL(logo);
        if (!/\.(jpg|jpeg|png)$/i.test(logo.name)) {
            alert('Your choice is not an image')
            return prevent()
        }
        var reader = new FileReader
        reader.addEventListener('load', () => {
            this.uploadedFile = reader.result
        })
    
     },
    addDeveloper(){
            const data = new FormData();
            data.append("en_name",this.en_name);
            data.append("ar_name",this.ar_name);
            data.append("en_description",this.en_description);
            data.append("ar_description",this.ar_description);
            data.append("facebook",this.facebook);
            data.append("logo",this.logo);
            data.append("phone",this.phone);
            data.append("email",this.email);
            data.append("featured",this.featured);
            data.append("_token",this.token);
            addDeveloper(data).then(response=>{
                $(location).attr('href', '/admin/vue/developers')
                this.success("Saved")
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
            message: 'Developer'+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
 },
}
</script>
<style>
 .control{
     width: 50%;
 }
 .button.is-info{
     float: left;
     width: 6%;
 }
 
.style
{
    background-color: white;
    padding: 20px;
    height: auto;
} 
</style>


