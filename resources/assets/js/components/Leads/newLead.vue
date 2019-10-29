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
               <b-button type="is-info" @click="addNewLead">Save</b-button>
           </div>
           <div  class="column is-1 cancel">
               <b-button type="is-danger">Cancel</b-button>
           </div>
       </div>

       <div class="columns is-12">
           <div class="column is-2">
              <b-checkbox v-model="checkboxcompany">Company lead</b-checkbox>
           </div>
            <div class="column is-6">
              <b-checkbox v-model="checkboxindividual">Individiual lead</b-checkbox>
           </div>
           <hr>
       </div>

        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
               <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">Comapany Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2">
                <section>
                    <b-field>
                        <b-upload v-model="newLead.dropFiles"
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
            <span v-for="(file, index) in newLead.dropFiles"
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

             <div class="column is-5">
                 
                <b-field>
                    <label class="column is-4">Company Name</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="name"></b-input>
                </b-field>

                <b-field>
                      <label class="column is-4">Phone</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-once v-model="newPhone"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span>
                      </div>
                </b-field>

                 <b-field class="repeat" v-if="index > 0" v-for="(phone, index) in phones" :key="index">
                      <label class="column is-4">Phone</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="newPhone"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removePhoneField(index,phone)"></span>
                      </div>
                </b-field>

                <b-field>
                    <label class="column is-4">Mobile</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="newMobile"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMobileField"></span> 
                    </div>
                </b-field>

                 <b-field v-if="indexMob > 0" v-for="(mobile, indexMob) in mobiles" :key="indexMob">
                    <label class="column is-4">Mobile</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="newMobile"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMobileField(indexMob,mobile)"></span> 
                    </div>
                </b-field>

                <b-field>
                    <label class="column is-4">Email</label>
                    <b-input class="Leaad" type="email" style="margin-left:5%;" v-model="newMail"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField"></span> 
                    </div>
                </b-field>

                <b-field v-if="indexMail > 0" v-for="(email, indexMail) in emails" :key="indexMail">
                    <label class="column is-4">Email</label>
                    <b-input class="Leaad" type="email" style="margin-left:5%;" v-model="newMail"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(indexMail,email)"></span> 
                    </div>
                </b-field>
                <!-- <b-field>
                    <label class="column is-4">fady</label>
                    <b-input class="Leaad" type="email" style="margin-left:5%;" v-model="newfady"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addfady"></span> 
                    </div>
                </b-field>
                <b-field v-if="indexMail > 0" v-for="(fady, indexMail) in fadys" :key="indexMail">
                    <label class="column is-4">fady</label>
                    <b-input class="Leaad" type="email" style="margin-left:5%;" v-model="newMail"></b-input>

                  
                </b-field> -->

                <b-field>
                    <label class="column is-4">Fax</label>
                    <b-input  class="Leaad" type="number" style="margin-left:5%;" v-model="newFax"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span> 
                    </div>
                </b-field>

                <b-field v-if="indexFax > 0" v-for="(fax, indexFax) in faxes" :key="indexFax">
                    <label class="column is-4">Fax</label>
                    <b-input class="Leaad" style="margin-left:5%;" v-model="newFax"></b-input>
                    <div class="column is-1">
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(indexFax,fax)"></span> 
                    </div>
                </b-field>


            </div>

           

            <div class="column is-4">
                <!-- <b-field>
                    <label class="column is-4">Lead Source</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="lead_source_id"></b-input>
                </b-field>        -->

                <b-field>
                    <label  class="column is-4">Lead Source</label>
                    <b-select class="Leaad2" expanded placeholder="Lead Source" v-model="lead_source_id">
                       <option v-for="leadsource in leadsources" :key="leadsource.id" :value="leadsource.id">
                           {{ leadsource.name }}
                       </option>
                    </b-select>
                </b-field>

                <!-- <b-field>
                    <label class="column is-4">Industry</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="industry_id"></b-input>
                </b-field> -->

                <b-field>
                    <label  class="column is-4">Industry</label>
                    <b-select class="Leaad2" expanded placeholder="Select Industry" v-model="industry">
                       <option v-for="industry in industries" :key="industry.id" :value="industry.id">
                           {{ industry.name }}
                       </option>
                    </b-select>
                </b-field>

                <b-field>
                    <label class="column is-4">Annual revenu</label>
                    <b-input class="Leaad" style="margin-left:5%;" v-model="annual_revenue"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">#Employees</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="employees_Number"></b-input>
                </b-field>

                <b-field>
                    <label  class="column is-4">Rating</label>
                    <b-select expanded class="Leaad2" v-model="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </b-select>
                </b-field>

            </div>

        </div>

        
        <div class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
            <h4 style="color:#9A9A9A">Address</h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer" @click="addAddress"></span> 
            </div>
        </div>

        <div style="margin-top:10px;padding-bottom:15px" 
         v-for="(address, indexAddress) in addresses" :key="indexAddress">

            <div v-if="indexAddress > 0" class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
               <h4 style="color:#9A9A9A">Address</h4>
               <div class="column is-1">
                   <span><img src="/images/remove.png" style="cursor:pointer" @click="removeAddressfield(indexAddress,address)"></span> 
               </div>
            </div>

         <div class="columns is-12">
            <div class="column is-2" style="margin-top:5%"></div>
            <div class="column is-5" style="margin-top:5%">
                <b-field>
                    <label class="column is-4">Street</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="street"></b-input>
                </b-field> 

                <b-field>
                    <label class="column is-4">State</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="state"></b-input>
                </b-field>

                <b-field>
                    <label  class="column is-4">Country</label>
                    <b-select class="Leaad2" expanded placeholder="Select Country" v-model="country">
                       <option v-for="countryy in countries" :value="countryy.id">
                           {{ countryy.name }}
                       </option>
                    </b-select>
                </b-field>
            </div>

            <div class="column is-5" style="margin-top:5%">
                 <b-field>
                    <label  class="column is-4">City</label>
                    <b-select class="Leaad2" expanded v-model="city">
                       <option v-for="cityy in cities" :value="cityy.id">
                           {{ cityy.name }}
                       </option>
                    </b-select>
                </b-field>

                <b-field>
                    <label class="column is-4">Zip Code</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="zipCode"></b-input>
                </b-field>

            </div>
         </div>
        </div>

    
        <div class="columns is-12 plusSign contact" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A">Contact Person</h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer" @click="addContact"></span> 
            </div>
        </div>

        <div style="margin-top:10px;padding-bottom:15px"
        v-for="(contact, indexContact) in contacts" :key="indexContact">

        <div  v-if="indexContact > 0" class="columns is-12 plusSign" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
               <h4 style="color:#9A9A9A">Contact Person</h4>
               <div class="column is-1">
                   <span><img src="/images/remove.png" style="cursor:pointer" @click="removeContactfield(indexContact,contact)"></span> 
               </div>
        </div>

        <div class="columns is-12">
          <div class="column is-2" style="margin-top:6%"></div>
            <div class="column is-5"  style="margin-top:6%">
                <b-field>
                    <label  class="column is-4">Title</label>
                    <b-select class="Leaad2" expanded v-model="title">
                        <option v-for="titlee in titles" :value="titlee.id">
                            {{ titlee.name }}
                        </option>
                    </b-select>
                </b-field>

                <b-field>
                    <label class="column is-4">First Name</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="firtName"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Last Name</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="lastName"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Email</label>
                    <b-input class="Leaad" type="email" style="margin-left:5%;" v-model="email"></b-input>
                </b-field>

            </div>

            <div class="column is-5"  style="margin-top:6%">
                <b-field>
                      <label class="column is-4">Phone</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="phone"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Mobile</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="mobile"></b-input>
                </b-field>
                

                <b-field>
                    <label  class="column is-4">Lead Status</label>
                     <b-select class="Leaad2" expanded v-model="leadStatus">
                        <option value="contacted">Contacted</option>
                        <option value="not_contacted">Not Contacted</option>
                    </b-select>
                </b-field>

                <b-field>
                      <label class="column is-4">Position</label>
                      <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="position"></b-input>
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
import {addNewLead,getcities,getCountries,getTitleData,getIndustries,getLeadSources} from './../../calls'

export default {
     data() {
        return {
            dropFiles: [],
            phones:[{
                newPhone:''
                }],
            mobiles:[{
                newMobile:''
            }],
            emails:[{
                newMail:''
            }],
            faxes:[{
                newFax:''
            }],
            addresses:[{
                street:'',
                state:'',
                country:'',
                city:'',
                zipCode:''
            }],
            contacts:[{
                removebtn:'',
                title:'',
                industry:'',
                firtName:'',
                lastName:'',
                email:'',
                nationality:'',
                phone:'',
                mobile:'',
                leadStatus:'',
                position:''
            }],
            name:null,
            checkboxindividual:null,
            checkboxcompany:null,
            industry_id:null,
            employees_Number:null,
            rating:null,
            logo:null,
            description:null,
            annual_revenue:null,
            lead_source_id:null,
            cities:[],
            countries:[],
            nationalities:[],
            newLead:[],
            titles:[],
            industries:[],
            leadsources:[]

        }
     },
     mounted(){
         this.getAllCities()
         this.getAllCountries()
         this.getAllTitles()
         this.getAllIndustries()
         this.getAllLeadSources()

     },
      methods: {
         removeAddressfield(indexAddress,address,){
             var idx = this.addresses.indexOf(address);
             console.log(idx, indexAddress);
             if (idx > -1) {
                 this.addresses.splice(idx, 1);
             }
         },
        removeContactfield(indexContact,contact){
                var idx = this.contacts.indexOf(contact);
            console.log(idx, indexContact);
            if (idx > -1) {
                this.contacts.splice(idx, 1);
            }
        },
        removePhoneField(index,phone){
            var idx = this.phones.indexOf(phone);
            console.log(idx, index);
            if (idx > -1) {
                this.phones.splice(idx, 1);
            }
        },
        removeMobileField(indexMob,mobile){
            var idx = this.mobiles.indexOf(mobile);
            console.log(idx, indexMob);
            if (idx > -1) {
                this.mobiles.splice(idx, 1);
            }
        },
        removeMailField(indexMail,email){
            var idx = this.emails.indexOf(email);
            console.log(idx, indexMail);
            if (idx > -1) {
                this.emails.splice(idx, 1);
            }
        },
        removeFaxField(indexFax,fax){
             var idx = this.faxes.indexOf(fax);
            console.log(idx, indexFax);
            if (idx > -1) {
                this.faxes.splice(idx, 1);
            }
        },
        deleteDropFile(index) {
            this.dropFiles.splice(index, 1)
        },
        // addPhoneField(){
        //      this.phones.push({
        //        newPhone: '',
        //     });

        // },
           addPhoneField: function() {
            var id =
                Math.max.apply(
                Math,
                this.phones.map(function(o) {
                    return o.id;
                })
                ) + 1;
            // this.phones.push({ id, field: null, value: null });
             this.phones.push({
               newPhone:'',
            });
            console.log("phones", this.phones)
            },
        addMobileField(){
             this.mobiles.push({
               newMobile: '',
            });
        },
        addMailField(){
            this.emails.push({
                newMail: '',
            })
        },
        addFaxField(){
            this.faxes.push({
                newFax: '',
            })
        },
        addAddress(){
            this.addresses.push({
                street:'',
                state:'',
                country:'',
                city:'',
                zipCode:''  
            })
            console.log("addresses",this.addresses)
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
            })
            console.log("contacts",this.contacts)
        },
        getAllCities(){
            getcities().then(response=>{
                console.log('all cities',response)
                this.cities = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },
        getAllCountries(){
            getCountries().then(response=>{
                this.countries = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },
        getAllTitles(){
            getTitleData().then(response=>{
                console.log('all titles',response)
                this.titles = response.data.data
            }).catch(error=>{
                console.log(error)
            })
        },

        getAllIndustries(){
            getIndustries().then(response=>{
                console.log('all industries',response)
                this.industries = response.data
            }).catch(error=>{
                console.log(error)
            })
        },

        getAllLeadSources(){
            getLeadSources().then(response=>{
                console.log('all Lead Sources',response)
                this.leadsources = response.data
            }).catch(error=>{
                console.log(error)
            })
        },

        addNewLead(){
            const bodyFormData = new FormData();
            for (let key in this.newLead) {
                const value = this.newLead[key];

            }
            bodyFormData.append('image',this.newLead.dropFiles[0])
            bodyFormData.append('name',this.name);
            bodyFormData.append('checkboxcompany',this.checkboxcompany);
            bodyFormData.append('checkboxindividual',this.checkboxindividual);
            bodyFormData.append('industry_id',this.industry);
            bodyFormData.append('employees_Number',this.employees_Number);
            bodyFormData.append('phones',this.phones);
            bodyFormData.append('mobiles',this.mobiles);
            bodyFormData.append('emails',this.emails);
            bodyFormData.append('faxes',this.faxes);
            bodyFormData.append('rating',this.rating);
            // bodyFormData.append('logo',this.logo);
            bodyFormData.append('description',this.description);
            bodyFormData.append('annual_revenue',this.annual_revenue);
            bodyFormData.append('lead_source_id',this.lead_source_id);
            bodyFormData.append('street',this.street);
            bodyFormData.append('state',this.state);
            bodyFormData.append('country_id',this.country);
            bodyFormData.append('city_id',this.city);
            bodyFormData.append('zip_code',this.zipCode);
            // bodyFormData.append('company_id',this.company_id);
            bodyFormData.append('first_name',this.firtName);
            bodyFormData.append('last_name',this.lastName);
            bodyFormData.append('title_id',this.title);
            bodyFormData.append('email',this.email);
            bodyFormData.append('nationality',this.nationality);
            bodyFormData.append('phone',this.phone);
            bodyFormData.append('mobile',this.mobile);

            bodyFormData.append('position',this.position);
            bodyFormData.append('leadstatus',this.leadStatus);

            console.log('dataaaaaa',bodyFormData)
            addNewLead(bodyFormData).then(response=>{
                alert('Lead Added Successfully')
                // $(location).attr('href', '/admin/vue/Leads')
            })
            .catch(error => {
                    console.log(error)
            })
            console.log("phoneeeeeeeees",this.phones)
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