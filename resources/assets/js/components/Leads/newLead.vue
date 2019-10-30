<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="columns is-12 is-mobile" style="margin-bottom:3%">
            <div class="column is-2">
                <b class="newlead" style="font-size:18px">New Lead</b>
            </div>
            <div class="column is-8">
                <div class="select">
                    <select>
                        <option value="only_me" selected>Only Me</option>
                        <option value="friends">Friends</option>
                        <option value="public">Public</option>
                    </select>
                </div>
            </div>
            <div class="column is-1 save">
                <b-button type="is-info">Save</b-button>
            </div>
            <div  class="column is-1 cancel">
                <b-button type="is-danger">Cancel</b-button>
            </div>
        </div>

        <div class="columns is-12">
            <div class="columns is-12">
                <div class="column is-2">
                    <b-checkbox>Company lead</b-checkbox>
                </div>
                <div class="column is-6">
                    <b-checkbox>Individiual lead</b-checkbox>
                </div>
                <hr>
            </div>
        </div>

        <!-- Start Company Data  -->
        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">Company Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2">
                <section>
                    <b-field>
                        <b-upload v-model="NewLead.dropFiles" multiple drag-drop>
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
                        <span v-for="(file, index) in NewLead.dropFiles"
                              :key="index"
                              class="tag is-primary" >
                            {{file.name}}
                            <button class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)">

                            </button>
                        </span>
                    </div>
                </section>
            </div>
            <!-- image  -->

            <!-- Start line 1 -->
            <div class="column is-5">

                <b-field>
                    <label class="column is-4">Company Name</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" placeholder="Company Name" v-model="companyName"></b-input>
                </b-field>
                <!-- Company Name  -->

                <b-field v-for="(data, index) in phones" :key="'a'+index" >
                    <label class="column is-4">Phone</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0" placeholder="Phone" v-model="phoneArr[index]"  required></b-input>
                    <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removePhoneField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span>
                    </div>
                </b-field>
                <!-- Phone field -->

                <b-field v-for="(data, index) in mobiles" :key="'b'+index" >
                    <label class="column is-4">Mobile</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0" placeholder="Mobile" v-model="mobileArr[index]"  required></b-input>
                    <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMobileField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMobileField"></span>
                    </div>
                </b-field>
                <!-- Mobile field -->

                <b-field v-for="(data, index) in emails" :key="'c'+index" >
                    <label class="column is-4">Email</label>
                    <b-input class="Leaad" type="email" style="margin-left:5%;"  placeholder="Email" v-model="emailArr[index]" required ></b-input>
                    <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField"></span>
                    </div>
                </b-field>
                <!--  Email field -->

                <b-field v-for="(data, index) in faxes" :key="'d'+index" >
                    <label class="column is-4">Fax</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" min="0" placeholder="Fax"  v-model="faxArr[index]" required ></b-input>
                    <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span>
                    </div>
                </b-field>
                <!-- Fax field -->
            </div>
            <!-- End line 1 -->

            <!-- Start line 2 -->
            <div class="column is-4">
                <b-field>
                    <label  class="column is-4">Lead Source</label>
                    <b-select v-model="leadSourceId" class="Leaad2" expanded placeholder="Lead Source">
                        <option v-for="leadSource in lead_sources " :key="leadSource.id" :value="leadSource.id" >{{leadSource.name}}</option>
                    </b-select>
                </b-field>
                <!-- Lead Source select -->

                <b-field>
                    <label  class="column is-4">Industry</label>
                    <b-select v-model="industryId" class="Leaad2" expanded placeholder="Select Industry">
                        <option v-for="industry in industries " :key="industry.id" :value="industry.id" >{{industry.name}}</option>
                    </b-select>
                </b-field>
                <!-- Industry select -->

                <b-field>
                    <label class="column is-4">Annual revenu</label>
                    <b-input class="Leaad" style="margin-left:5%;" placeholder="Annual revenu" v-model="annualRevenu"></b-input>
                </b-field>
                <!-- Annual revenu field -->

                <b-field>
                    <label class="column is-4">Employees</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" placeholder="Employees" v-model="employee"></b-input>
                </b-field>
                <!-- Employees field -->

                <b-field>
                    <label  class="column is-4">Rating</label>
                    <b-select expanded class="Leaad2" v-model="rating" placeholder="Rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </b-select>
                </b-field>
                <!-- Rating select -->
            </div>
            <!-- End line 2 -->
        </div>
        <!-- End Company Data  -->

        <!-- Start Address Data  -->
        <div class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
            <h4 style="color:#9A9A9A">Address</h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer" @click="addAddress"></span>
            </div>
        </div>

        <div style="margin-top:10px;padding-bottom:15px" v-for="(address, indexAddress) in addresses" :key="indexAddress">
            <div v-if="indexAddress > 0" class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
                <h4 style="color:#9A9A9A">Address</h4>
                <div class="column is-1">
                    <span><img src="/images/remove.png" style="cursor:pointer" @click="removeAddressField(indexAddress,address)"></span>
                </div>
            </div>

            <div class="columns is-12">
                <div class="column is-2" style="margin-top:5%"></div>
                <div class="column is-5" style="margin-top:5%">
                    <b-field>
                        <label class="column is-4">Street</label>
                        <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="street"></b-input>
                    </b-field>
                    <!-- Street field -->

                    <b-field>
                        <label class="column is-4">State</label>
                        <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="state"></b-input>
                    </b-field>
                    <!-- State field -->

                    <b-field>
                        <label  class="column is-4">Country</label>
                        <b-select v-model="CountryId" class="Leaad2" expanded placeholder="Select Country">
                            <option v-for="country in countries " :key="country.id" :value="country.id" >{{country.name}}</option>
                        </b-select>
                    </b-field>
                </div>
                <!-- Country select -->

                <div class="column is-5" style="margin-top:5%">
                    <b-field>
                        <label  class="column is-4">City</label>
                        <b-select class="Leaad2" expanded>
                            <option>City</option>
                            <option>City</option>
                            <option>City</option>
                        </b-select>
                    </b-field>

                    <b-field>
                        <label class="column is-4">Zip Code</label>
                        <b-input class="Leaad" type="text" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
            </div>
        </div>
        <!-- End Address Data  -->

        <div class="columns is-12 plusSign contact" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A">Contact Person</h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer" @click="addContact"></span>
            </div>
        </div>

        <div style="margin-top:10px;padding-bottom:15px" v-for="(contact, indexContact) in contacts" :key="indexContact">
            <div  v-if="indexContact > 0" class="columns is-12 plusSign" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
                <h4 style="color:#9A9A9A">Contact Person</h4>
                <div class="column is-1">
                    <span><img src="/images/remove.png" style="cursor:pointer" @click="removeContactField(indexContact,contact)"></span>
                </div>
            </div>

            <div class="columns is-12">
                <div class="column is-2" style="margin-top:6%"></div>
                <div class="column is-5"  style="margin-top:6%">
                    <b-field>
                        <label  class="column is-4">Title</label>
                        <b-select class="Leaad2" expanded>
                            <option>Title</option>
                        </b-select>
                    </b-field>

                    <b-field>
                        <label class="column is-4">First Name</label>
                        <b-input class="Leaad" type="text" style="margin-left:5%;"></b-input>
                    </b-field>

                    <b-field>
                        <label class="column is-4">Last Name</label>
                        <b-input class="Leaad" type="text" style="margin-left:5%;"></b-input>
                    </b-field>

                    <b-field>
                        <label class="column is-4">Email</label>
                        <b-input class="Leaad" type="email" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-5"  style="margin-top:6%">
                    <b-field>
                        <label class="column is-4">Phone</label>
                        <b-input class="Leaad" type="number" style="margin-left:5%;"></b-input>
                    </b-field>

                    <b-field>
                        <label class="column is-4">Mobile</label>
                        <b-input class="Leaad" type="number" style="margin-left:5%;"></b-input>
                    </b-field>


                    <b-field>
                        <label  class="column is-4">Lead Status</label>
                        <b-select class="Leaad2" expanded>
                            <option value="contacted">Contacted</option>
                            <option value="not_contacted">Not Contacted</option>
                        </b-select>
                    </b-field>

                    <b-field>
                        <label class="column is-4">Position</label>
                        <b-input class="Leaad" type="text" style="margin-left:5%;"></b-input>
                    </b-field>

                </div>
            </div>
        </div>

        <div class="columns is-12 plusSign contact" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">Additional info</h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer"></span>
            </div>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2"></div>
        </div>

        <div class="columns is-12">
            <div class="column is-2"></div>
            <b-field  class="column is-9">
                <label class="column is-1">Description</label>
                <b-input type="textarea" style="margin-left:5%;" class="column is-9" v-model="description"></b-input>
            </b-field>
        </div>
    </div>
</template>

<script>
import {getLeadSources,getIndustries,getCountries} from './../../calls'

export default {
     data() {
         return {
             dropFiles: [],
             NewLead:[],
             companyName:'',
             phone:'',
             phones:[{ phone:[] }],
             phoneArr:[],
             mobile:'',
             mobiles:[{ mobiles:[] }],
             mobileArr:[],
             email:'',
             emails:[{ emails:[] }],
             emailArr:[],
             fax:'',
             faxes:[{ faxes:[] }],
             faxArr:[],
             lead_sources:[],
             leadSourceId:null,
             industries:[],
             industryId:null,
             annualRevenu:'',
             employee:'',
             rating:'',
             addresses:[
                 {
                     street:'',
                     state:'',
                     CountryId:'',
                     city:'',
                     zipCode:''
                 }
             ],
             countries:[],

         }
     },
     mounted(){
         this.getLeadSources();
         this.getIndustries();
         this.getCountries();
     },
      methods: {
          deleteDropFile(index) {
              this.dropFiles.splice(index, 1)
          },

          addPhoneField: function() {
              this.phones.push(this.phones.length+1);
              this.flag+=1;
          },

          removePhoneField(index,phone){
              var idx = this.phones.indexOf(phone);
              console.log(idx, index);
              if (idx > -1) {
                  this.phones.splice(idx, 1);
                  this.phoneArr[index]='';
              }
          },

          addMobileField(){
              this.mobiles.push(this.mobiles.length+1);
              this.flag+=1;
          },

          removeMobileField(indexMob,mobile){
              var idx = this.mobiles.indexOf(mobile);
              console.log(idx, indexMob);
              if (idx > -1) {
                  this.mobiles.splice(idx, 1);
                  this.mobiles[indexMob]='';
              }
          },

          addMailField(){
              this.emails.push(this.emails.length+1);
              this.flag+=1;
          },

          removeMailField(indexMail,email){
              var idx = this.emails.indexOf(email);
              console.log(idx, indexMail);
              if (idx > -1) {
                  this.emails.splice(idx, 1);
                  this.emails[indexMail]='';
              }
          },

          addFaxField(){
              this.faxes.push( this.faxes.length+1);
              this.flag+=1;
          },

          removeFaxField(indexFax,fax){
              var idx = this.faxes.indexOf(fax);
              console.log(idx, indexFax);
              if (idx > -1) {
                  this.faxes.splice(idx, 1);
                  this.faxes[indexFax]='';

              }
          },

          addAddress(){
              this.addresses.push({
                  street:'',
                  state:'',
                  country:'',
                  city:'',
                  zipCode:''
              });
              console.log("addresses",this.addresses)
          },

          removeAddressField(indexAddress,address,){
              var idx = this.addresses.indexOf(address);
              console.log(idx, indexAddress);
              if (idx > -1) {
                  this.addresses.splice(idx, 1);
              }
          },

          addContact(){
              this.contacts.push({
                  title:'',
                  removebtn:'',
                  firtName:'',
                  lastName:'',
                  email:'',
                  nationality:'',
                  phone:'',
                  mobile:'',
                  leadStatus:'',
                  position:''
              });
              console.log("contacts",this.contacts)
          },

          removeContactField(indexContact,contact){
              var idx = this.contacts.indexOf(contact);
              console.log(idx, indexContact);
              if (idx > -1) {
                  this.contacts.splice(idx, 1);
              }
          },

          getLeadSources(){
              getLeadSources().then(Response=>{
                  this.lead_sources = Response.data
              }).catch(error=>{
                  console.log(error);
              })
          },

          getIndustries(){
              getIndustries().then(Response=>{
                  this.industries = Response.data
              }).catch(error=>{
                  console.log(error);
              })
          },

          getCountries(){
              getCountries().then(Response=>{
                  this.countries = Response.data.data
              }).catch(error =>{
                  console.log(error);
              })
          },

          addNewLead(){
              const bodyFormData = new FormData();
              for (let key in this.NewLead) {
                  const value = this.NewLead[key];
              }
              bodyFormData.append('image',this.NewLead.dropFiles[0]);
              bodyFormData.append('companyName',this.companyName);
              bodyFormData.append('phones',JSON.stringify(this.phoneArr));
              bodyFormData.append( 'mobiles',JSON.stringify(this.mobileArr));
              bodyFormData.append('emails',JSON.stringify(this.emailArr));
              bodyFormData.append('faxes',JSON.stringify(this.faxArr));
              bodyFormData.append('leadSourceId',this.leadSourceId);
              bodyFormData.append('industryId',this.industryId);
              bodyFormData.append('annualRevenu',this.annualRevenu);
              bodyFormData.append('employee',this.employee);
              bodyFormData.append('rating',this.rating);
          }
      }

}
</script>

<style>
@media screen and (max-width: 767px) {
.save{
    margin-right: 11%;
}
.cancel{
    margin-left: -45%;
}
.Leaad{
    width: 58%;
}
.Leaad2{
    width: 19%;
}
.plusSign{
    display: flex;
}
.contact{
    margin-top: 5%;
}
.newlead{
    font-size: 11.5px !important;
}
}
</style>