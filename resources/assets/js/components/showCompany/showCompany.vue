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
                    <b-upload v-model="NewCompany"
                              multiple
                              drag-drop  @change="" required>
                        <section class="section">
                            <div class="content has-text-centered">
                                <img thumbnail fluid  :src="`/img/${NewCompany.image}`" alt="Image 1"/>
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
                    <b-input  expanded  v-model="companies.Company_Name" type="text"> </b-input>

                 
                </b-field>   
                <b-field>
                    <label class="column is-3">Activity</label>
                    <b-input v-model="activity.activity"  type="text" expanded  ></b-input>
                </b-field>

                 <b-field>
                     <label  class="column is-3">Currency</label>
                     <b-select v-model="currencyId" placeholder="Select Currency"  expanded>
                         <option v-for="currency in currencies " :key="currency.id" :value="currency.id" >{{currency.activity}}</option>
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
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="first_name.first_name"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Last Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="last_name.last_name"></b-input>
                </b-field>

                <b-field v-for="(data, index) in phones" :key="'a'+index"  >

                    <label class="column is-4">Phone</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0"  v-model="phone.personal_phone" ></b-input>
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
                      <b-input class="company" type="text" style="margin-left:5%;" v-model="position.position"></b-input>
                </b-field>
            </div>

            <div class="column is-5"  style="margin-top:6%">

                 <b-field v-for="(data, index) in faxes" :key="'c'+index" >
                      <label class="column is-4">Fax</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"   v-model="faxArr.personal_fax" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span> 
                      </div>
                </b-field>

                <b-field v-for="(data, index) in emails" :key="'d'+index" >
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="email" style="margin-left:5%;"   v-model="email.personal_mail" ></b-input>
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
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="website.website"></b-input>
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
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="street.street"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">State</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="state.state"></b-input>
                </b-field>

                 <b-field>
                    <label  class="column is-3">Country</label>
                    <b-select v-model="country_id" placeholder="Select Country"  expanded>
                       <option v-for="country in countries " :key="country.id" :value="country.id" >{{country.country}}</option>
                    </b-select>
                </b-field>

            </div>

            <div class="column is-5" style="margin-top:5%">
                <b-field>
                    <label  class="column is-3">City</label>
                    <b-select v-model="city_id" placeholder="Select City"  expanded>
                       <option v-for="city in cities " :key="city.id" :value="city.id" >{{city.city}}</option>
                    </b-select>
                </b-field>
                <b-field>
                    <label class="column is-4">Zip Code</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"  v-model="zip_code.zip_code"></b-input>
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
                 <b-input type="textarea" style="margin-left:5%;" v-model="Introduction.introduction" class="column is-9"></b-input>
              </b-field>
         </div>

         <div class="columns is-12">
              <div class="column is-2"></div>
              <b-field  class="column is-9">
                 <label class="column is-1">Closing</label>
                 <b-input type="textarea" style="margin-left:5%;" v-model="Closing.closing" class="column is-9"></b-input>
              </b-field>
         </div>

         <div class="columns is-12">
              <div class="column is-2"></div>
              <b-field  class="column is-9">
                 <label class="column is-1">Policy</label>
                 <b-input type="textarea" style="margin-left:5%;" v-model="Policy.policy" class="column is-9"></b-input>
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
    import{getAllCurrency,getAllNationality,getAllCities,getAllCountries, dashgetstatus,
    addNewProposedCompany,updateCompany,getProposedCompanyData,
    
    ShowCompanyData, getActivity ,getCurrency}   from './../../calls'
    export default {
        data() {
            return {

                companyImage:'',
                contactsArray:[],
                removebtn:'',
                title:'',
                first_name:[],
                last_name:[],
                email:[],
                nationality:'',
                phone:[],
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
                activity:[],
                currencyId:null,
                nationality_id:[],
                city_id:[],
                country_id:[],
                website:[],
                companyName:'',
                companies: [],
                activities:[],
                Policy:[],
                Closing:[],
                Introduction:[],
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
            this.ShowCompanyData()
            this.getActivity()
         

        },
        created() {
            this.id = this.$route.params.id
        },
        methods: {
            getData(){
                 ShowCompanyData(this.id).then(Response=>{
                
                }).catch(error=>{
                     console,log(error);
             })

                
            },
            
        ShowCompanyData(){
            ShowCompanyData().then(Response=>{
                  this.NewCompany=Response.data.data[0]
                 this.companies=Response.data.data[0]
                  this.activity=Response.data.data[0]
                 this.first_name=Response.data.data[0]
                 this.last_name=Response.data.data[0]
                 this.phone=Response.data.data[0]
                this.faxArr=Response.data.data[0]
                this.email=Response.data.data[0]
                 this.position=Response.data.data[0]
                 this.website=Response.data.data[0]
                 this.street=Response.data.data[0]
                 this.state=Response.data.data[0]
                this.zip_code=Response.data.data[0]
                 this.Introduction=Response.data.data[0]
                this.Closing=Response.data.data[0]
                this.Policy=Response.data.data[0]
            
                 console.log("dataaaaaaaaaaaaaaaaaaaaaa",this.companies)
                  console.log("ressssssssss",Response.data.data)
             }).catch(error=>{
                  console.log(error);
             })
            },

        // getActivity() {
        //     getActivity().then(Response=>{
        //          this.activity=Response.data.data[0]
        //          console.log("aaaaaaaaaaaaaaaaaaaaa",this.activity)
        //           console.log("ressssssssss",Response)
        //      }).catch(error=>{
        //           console.log(error);
        //      })
        //     },

             getAllCurrency(){
              getAllCurrency().then(Response=>{
                  this.currencies=Response.data.data
              }).catch(error=>{
                  console.log(error);
              })
          },
          
          getAllNationality(){
              getAllNationality().then(Response=>{
                  this.nationalities=Response.data.data
                  console.log("--------------------",Response);
                  console.log("sssssssssssssssssssssssssssssss",this.nationalities);

              }).catch(error=>{
                  console.log(error);
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










    