<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="columns is-12 is-mobile" style="margin-bottom:3%">
            <div class="column is-2">
                <b class="newCompany" style="font-size:18px">New Company</b>
            </div>
        </div>

        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
               <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">Comapany Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2">
                <b-field style="padding-right: 6px; max-height: 200px; max-width: 200px;">
                    <b-upload v-model="NewCompany.dropFiles"
                              multiple
                              drag-drop  @change="onFileChange" required>
                        <section class="section">
                            <div class="content has-text-centered">
                                <img thumbnail fluid  :src="`/img/${companyImage}`" alt="Image 1"/>
                            </div>
                        </section>
                    </b-upload>


                    <div class="tags" >
                        <span v-for="(file, index) in NewCompany.dropFiles"
                              :key="index"
                              class="tag is-primary" >
                            {{file.name}}
                            <button class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)">
                            </button>
                        </span>
                    </div>
                </b-field>
            </div>
            
             <div class="column is-6">
                 
                <b-field>
                    <label class="column is-3">Company Name</label>
                    <b-input  expanded  v-model="companyName" type="text"  ></b-input>
                </b-field>   
                <b-field>
                    <label class="column is-3">Activity</label>
                    <b-input type="text" v-model="activity" expanded ></b-input>
                </b-field>

                 <b-field>
                     <label  class="column is-3">Currency</label>
                     <b-select v-model="currencyId" placeholder="Select Currency"  expanded>
                         <option v-for="currency in currencies " :key="currency.id" :value="currency.id" >{{currency.name}}</option>
                     </b-select>
                 </b-field>
            </div>
        </div>

        <div class="columns is-12 plusSign contact" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A">Contact </h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer" @click="addContact"></span> 
            </div>
        </div>

        <div style="margin-top:10px;padding-bottom:15px"
        v-for="(contact, indexContact) in contacts" :key="indexContact">

        <div  v-if="indexContact > 0" class="columns is-12 plusSign" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
               <h4 style="color:#9A9A9A">Contact</h4>
               <div class="column is-1">
                   <span><img src="/images/remove.png" style="cursor:pointer" @click="removeContactfield(indexContact,contact)"></span>
               </div>
        </div>

        <div class="columns is-12">
          <div class="column is-2" style="margin-top:6%"></div>
            <div class="column is-5"  style="margin-top:6%">
                <b-field >
                    <label class="column is-4">First Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="first_name"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Last Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="last_name"></b-input>
                </b-field>

                <b-field v-for="(data, index) in phones" :key="'a'+index"  >

                    <label class="column is-4">Phone</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0"  v-model="phone" ></b-input>
                    <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removePhoneField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span>
                    </div>
                </b-field>

<!--                 <b-field v-for="(data, index) in mobiles" :key="'b'+index" >-->
<!--                      <label class="column is-4">Mobile</label>-->
<!--                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"   v-model="mobile" ></b-input>-->
<!--                      <div class="column is-1">-->
<!--                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMobileField(index,data)"></span> -->
<!--                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMobileField"></span> -->
<!--                      </div>-->
<!--                </b-field>-->

                 <b-field>
                      <label class="column is-4">Position</label>
                      <b-input class="company" type="text" style="margin-left:5%;" v-model="position"></b-input>
                </b-field>
            </div>

            <div class="column is-5"  style="margin-top:6%">

                 <b-field v-for="(data, index) in faxes" :key="'c'+index" >
                      <label class="column is-4">Fax</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"   v-model="faxArr[index]" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span> 
                      </div>
                </b-field>

                <b-field v-for="(data, index) in emails" :key="'d'+index" >
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="email" style="margin-left:5%;"   v-model="email" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField"></span> 
                      </div>
                </b-field>

                 <b-field>
                    <label  class="column is-3">Nationality</label>
                    <b-select v-model="nationality_id" placeholder="Select Nationality"  expanded>
                       <option v-for="nationality in nationalities " :key="nationality.id" :value="nationality.id" >{{nationality.nationality}}</option>
                    </b-select>
                </b-field>

                 <b-field>
                    <label class="column is-4">WebSite</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="website"></b-input>
                </b-field>
            </div>
        </div>
        </div>

        <div class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
            <h4 style="color:#9A9A9A">Address</h4>
            <div class="column is-1">
                <span><img src="/images/add.png" style="cursor:pointer" @click="addAddress"></span> 
            </div>
        </div>

        <div style="margin-top:10px;padding-bottom:15px"
         v-for="(address, indexAddress) in addresses" :key="'f'+indexAddress">

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
                    <label  class="column is-3">Country</label>
                    <b-select v-model="country_id" placeholder="Select Country"  expanded>
                       <option v-for="country in countries " :key="country.id" :value="country.id" >{{country.name}}</option>
                    </b-select>
                </b-field>

            </div>

            <div class="column is-5" style="margin-top:5%">
                <b-field>
                    <label  class="column is-3">City</label>
                    <b-select v-model="city_id" placeholder="Select City"  expanded>
                       <option v-for="city in cities " :key="city.id" :value="city.id" >{{city.name}}</option>
                    </b-select>
                </b-field>
                <b-field>
                    <label class="column is-4">Zip Code</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"  v-model="zip_code"></b-input>
                </b-field>

            </div>
         </div>
        </div>

        <div class="columns is-12 plusSign contact" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">About THe Company</h4>

        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2"></div>
        </div>

         <div class="columns is-12">
              <div class="column is-2"></div>
              <b-field  class="column is-9">
                 <label class="column is-1">Introduction</label>
                 <b-input type="textarea" style="margin-left:5%;" v-model="Introduction" class="column is-9"></b-input>
              </b-field>
         </div>

         <div class="columns is-12">
              <div class="column is-2"></div>
              <b-field  class="column is-9">
                 <label class="column is-1">Closing</label>
                 <b-input type="textarea" style="margin-left:5%;" v-model="Closing" class="column is-9"></b-input>
              </b-field>
         </div>

         <div class="columns is-12">
              <div class="column is-2"></div>
              <b-field  class="column is-9">
                 <label class="column is-1">Policy</label>
                 <b-input type="textarea" style="margin-left:5%;" v-model="Policy" class="column is-9"></b-input>
              </b-field>
         </div>

         <div class="level">
             <div class="level-item filters">
                 <div class="field  mr-10">
                     <div class="control">
                         <b-button type="is-success" style="margin-top:8px" @click="addNewProposedCompany()">
                             <i class="fas fa-save"></i>&nbsp;
                                 Save
                         </b-button>

                         <b-button type="is-danger" style="margin-top:8px">
                             <i class="fas fa-remove "></i>&nbsp;
                                Cancel
                         </b-button>
                     </div>
                 </div>
             </div>
         </div>
    </div>

</template>

<script>
    import{getAllCurrency,getAllNationality,getAllCities,getAllCountries, dashgetstatus,addNewProposedCompany,updateCompany,getProposedCompanyData}   from './../../calls'
    export default {
        data() {
            return {

                companyImage:'',
                contactsArray:[],
                removebtn:'',
                title:'',
                first_name:'',
                last_name:[],
                email:'',
                nationality:'',
                phone:'',
                mobile:'',
                leadStatus:'',
                position:[],
                WebSite:[],
                street:[],
                state:[],
                country:'',
                city:'',
                zip_code:[],
                token:window.auth_user.csrf,
                NewCompany:[],
                indexContact:0,
                currencies:[],
                nationalities:[],
                cities:[],
                countries:[],
                activity:'',
                currencyId:null,
                nationality_id:[],
                cityId:[],
                countryId:[],
                companyName:'',
                Policy:'',
                Closing:'',
                Introduction:'',
                dropFiles: [],
                phones:[{ phone:[] }],

                mobileArr:[],
                emailArr:[],
                faxArr:[],
                contact_array: [],
                address_array:[],
                // newPhoneArr:[],
                // newPhone:null,

                mobiles:[{
                    mobiles:[]
                }],
                emails:[{
                    emails:[]
                }],
                faxes:[{
                    faxes:[]
                }],
                addresses:[{
                    addresses:[]
                }],
                contacts:[{
                    contacts:[]
                }],
            }
        },
        mounted() {
            this.getAllCurrency()
            this.getAllNationality()
            this.getAllCities()
            this.getAllCountries()
            this.getData()

        },
        created() {
            this.id = this.$route.params.id
        },
        methods: {
            getData(){
                getProposedCompanyData(this.id).then(Response=>{
                    //   console.log("fffff",Response);
                    this.companyImage=Response.data.data.image;
                    this.companyName=Response.data.data.name;
                    this.activity=Response.data.data.activity;
                    this.currencyId=Response.data.data.currencyId;
                    this.Introduction=Response.data.data.introduction;
                    this.Closing=Response.data.data.closing;
                    this.Policy=Response.data.data.policy;
                    if(Response.data.data.proposalContacts !=null)
                        this.contact_array=Response.data.data.proposalContacts;
                    this.address_array=Response.data.data.proposalAddress;


                }).catch(error=>{
                    console,log(error);
                })
            },
            addNewProposedCompany(){
                //   var contactsArray=this.contacts.length+1;
                //   var p;
                //  for (let key in this.phones) {
                //     const value = this.phones[key];
                //   p=this.phones[key].phone;
                //     }
                // for (var i = 1; i < contactsArray; i++) {


                //   this.contactsArray.push({
                //   contactindex:i,
                //   firstName: this.firstName[i],
                //   lastName:this.lastName[i],
                //   pArray:this.p,

                //   mArray:this.mobileArr[i],
                //   fArray:this.faxArr[i],
                //   eArray:this.emailArr[i],
                //   nationality:this.nationalityId[i],
                //   webiste:this.WebSite[i]
                //  });


                // }
                const bodyFormData = new FormData();
                for (let key in this.NewCompany) {
                    const value = this.NewCompany[key];
                    this.id = this.$route.params.id

                    // bodyFormData.set(key, value);
                }
                bodyFormData.append('image',this.NewCompany.dropFiles[0])
                bodyFormData.append('companyName',this.companyName);
                bodyFormData.append('id', this.id);



                //     '_token':this.token,
                bodyFormData.append('activity',this.activity)
                bodyFormData.append('currencyId',this.currencyId)
                bodyFormData.append('first_name',this.first_name)
                bodyFormData.append('last_name',this.last_name)
                bodyFormData.append('phone',this.phone)
                bodyFormData.append('position',this.position)
                bodyFormData.append('faxies',this.faxArr)
                bodyFormData.append('email',this.email)
                bodyFormData.append('nationality_id',this.nationality_id)
                bodyFormData.append('website',this.website)
                bodyFormData.append('street',this.street)
                bodyFormData.append('state',this.state)
                bodyFormData.append('country_id',this.country_id)
                bodyFormData.append('city_id',this.city_id)
                bodyFormData.append('zip_code',this.zip_code)
                bodyFormData.append( 'introduction',this.Introduction)
                bodyFormData.append( 'closing',this.Closing)
                bodyFormData.append('policy',this.Policy)
                bodyFormData.append('contactsArray',JSON.stringify(this.contactsArray))


                updateCompany(bodyFormData).then(Response=>{
                    //   console.log("the returned Value is ",Response.data)
                    window.location.href="/admin/vue/allCompanies"
                })

            },
        getAllCities(){
              getAllCities().then(Response=>{
                  this.cities=Response.data.data
              }).catch(error=>{
                  console.log(error);
              })
          },
         getAllCountries(){
              getAllCountries().then(Response=>{
                  this.countries=Response.data.data
              }).catch(error=>{
                  console.log(error);
              })
          },
          getAllNationality(){
              getAllNationality().then(Response=>{
                  this.nationalities=Response.data.data
              }).catch(error=>{
                  console.log(error);
              })
          },
          getAllCurrency(){
              getAllCurrency().then(Response=>{
                  this.currencies=Response.data.data
              }).catch(error=>{
                  console.log(error);
              })
          },
        removeAddressfield(indexAddress,address){
           var idx = this.addresses.indexOf(address);
            console.log(idx, indexAddress);
            if (idx > -1) {
                this.addresses.splice(idx, 1);
                 this.addresses[indexAddress]='';
            }
        },
        removeContactfield(indexContact,contact){
            var idx = this.contacts.indexOf(contact);
            console.log(idx, indexContact);
            if (idx > -1) {
                this.contacts.splice(idx, 1);
            }
        },
        removePhoneField(index,data){

            var idx = this.phones.indexOf(data);
            console.log("ttttttttt",index);
            if (idx > -1) {
             this.phones.splice(idx,1);
             this.phoneArr[index]='';
            }

        },
        removeMobileField(indexMob,data){
            var idx = this.mobiles.indexOf(data);
            console.log(idx, indexMob);
            if (idx > -1) {
                this.mobiles.splice(idx, 1);
                 this.mobiles[indexMob]='';
            }
        },
        removeMailField(indexMail,email){
            var idx = this.emails.indexOf(email);
            console.log(idx, indexMail);
            if (idx > -1) {
                this.emails.splice(idx, 1);
                this.emails[indexMail]='';
            }
        },
        removeFaxField(indexFax,fax){
             var idx = this.faxes.indexOf(fax);
            console.log(idx, indexFax);
            if (idx > -1) {
                this.faxes.splice(idx, 1);
                this.faxes[indexFax]='';

            }
        },
        deleteDropFile(index) {
            this.dropFiles.splice(index, 1)
        },
        addPhoneField(){
            this.phones.push(this.phones.length+1)
            this.flag+=1;
        },
        addMobileField(){
        this.mobiles.push(this.mobiles.length+1)
        },
        addMailField(){
         this.emails.push(this.emails.length+1)
        },
        addFaxField(){
            this.faxes.push( this.faxes.length+1)
        },
         addAddress(){
         this.addresses.push( this.addresses.length+1)
        },
        addContact(){

         this.contacts.push( this.contacts.length+1)


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
.company{
    width: 100%;
    height:  50px;
}
.company2{
    width: 19%;
}
.plusSign{
    display: flex;
}
.contact{
    margin-top: 5%;
}
.newCompany{
    font-size: 11.5px !important;
}
.elementtt{
    height: 25px;
    width: 300px;
}
}
</style>










    