  <template>
    <div class="container" style="background-color:#fff;padding:3%">
        <div class="columns is-12 is-mobile" style="margin-bottom:3%">
            <div class="column is-2">
                <b class="newCompany" style="font-size:18px">New Lead</b>
            </div>
        </div>

        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
               <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">Comapany Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2">
                <!-- <b-field style="padding-right: 6px; max-height: 200px; max-width: 200px;">
                    <b-upload v-model="NewCompany"
                              multiple
                              drag-drop  @change="" required>
                        <section class="section">
                            <div class="content has-text-centered">
                                <img thumbnail fluid  
                                v-for="newcomp in NewCompany" :key="newcomp.id"
                                :src="`/img/${newcomp.image}`" alt="Image 1"/>
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
                </b-field> -->
            </div>
            
             <div class="column is-6">
                 
                <b-field>
                    <label class="column is-3">Company Name</label>
                    <b-input  expanded v-for="company in companies" :key="company.id" v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   
                <b-field>
                    <label class="column is-3">Lead Type</label>
                    <b-input v-for="lead in leads "  :key="lead.id" v-model="lead.lead_type"  type="text" expanded  ></b-input>
                </b-field>
                <b-field>
                    <label class="column is-3">Lead Status</label>
                    <b-input v-for="lead in lead_status "  :key="lead.id" v-model="lead.lead_status"  type="text" expanded  ></b-input>
                </b-field>
                 <b-field v-for="(data, index) in phones" :key="'a'+index"  >

                    <label class="column is-3">Phone</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0" 
                       v-for="phone in company_phone " :key="phone.id"
                     v-model="phone.phone" ></b-input>
                    <div class="column is-3">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removePhoneField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span>
                    </div>
                </b-field>

                 <b-field v-for="(data, index) in mobiles" :key="'b'+index" >
                      <label class="column is-3">Mobile</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0" 
                          v-for="mob in company_mobile " :key="mob.id"
                     v-model="mob.mobile" ></b-input>
                      <div class="column is-3">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMobileField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMobileField"></span> 
                      </div>
                </b-field>

                <b-field v-for="(data, index) in emails" :key="'d'+index" >
                      <label class="column is-3">Email</label>
                      <b-input class="Leaad" type="email" style="margin-left:5%;"  
                      v-for="mail in company_email " :key="mail.id"
                       v-model="mail.compamymail" ></b-input>
                      <div class="column is-3">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField"></span> 
                      </div>
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
                    <b-input class="company" type="text" style="margin-left:5%;" 
                    v-for="first in first_name " :key="first.id"
                    v-model="first.first_name"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Last Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" 
                      v-for="last in last_name " :key="last.id"
                    v-model="last.last_name"></b-input>
                </b-field>

                <b-field v-for="(data, index) in phones" :key="'a'+index"  >

                    <label class="column is-4">Phone</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0" 
                       v-for="phone in phoness " :key="phone.id"
                     v-model="phone.personal_phone" ></b-input>
                    <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removePhoneField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span>
                    </div>
                </b-field>

                 <b-field v-for="(data, index) in mobiles" :key="'b'+index" >
                      <label class="column is-4">Mobile</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0" 
                          v-for="mob in mobiless " :key="mob.id"
                     v-model="mob.personal_mobile" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMobileField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMobileField"></span> 
                      </div>
                </b-field>

                 <b-field>
                      <label class="column is-4">Position</label>
                      <b-input class="company" type="text" style="margin-left:5%;" 
                       v-for="pos in position " :key="pos.id"
                      v-model="pos.position"></b-input>
                </b-field>
            </div>

            <div class="column is-5"  style="margin-top:6%">
<!-- 
                 <b-field v-for="(data, index) in faxes" :key="'c'+index" >
                      <label class="column is-4">Fax</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"  
                       v-for="fax in faxArr " :key="fax.id"
                       v-model="fax.personal_fax" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span> 
                      </div>
                </b-field> -->

                <b-field v-for="(data, index) in emails" :key="'d'+index" >
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="email" style="margin-left:5%;"  
                      v-for="mail in email " :key="mail.id"
                       v-model="mail.personal_mail" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField"></span> 
                      </div>
                </b-field>

                 <b-field>
                    <label class="column is-4">Status</label>
                    <b-input class="company" type="text" style="margin-left:5%;" 
                      v-for="stat in status " :key="stat.id"
                    v-model="stat.leadstatus"></b-input>
                </b-field>
                
                 <b-field>
                    <label  class="column is-3">Nationality</label>
                    <b-select v-model="nationality_id" placeholder="Select Nationality"  expanded>
                       <option v-for="nationality in nationalities " :key="nationality.id" :value="nationality.id" >{{nationality.nationality}}</option>
                    </b-select>
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
                    <b-input class="Leaad" type="text" style="margin-left:5%;" 
                    v-for="street in streets " :key="street.id"
                    v-model="street.street"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">State</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" 
                    v-for="state in states" :key="state.id"                    
                    v-model="state.state"></b-input>
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
                    <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"  
                       v-for="zip in zip_code " :key="zip.id"
                    
                    v-model="zip.zip_code"></b-input>
                </b-field>

            </div>
         </div>
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
    import{getcity,getcountry, dashgetstatus,
    addNewProposedCompany,updateCompany,getProposedCompanyData,
    
    ShowLeadData, getActivity ,getCurrency}   from './../../calls'
    export default {
        data() {
            return {
              
                contactsArray:[],
                removebtn:'',
                title:'',
                first_name:[],
                last_name:[],
                email:[],
                company_phone:[],
                company_mobile:[],
                company_name:[],
                company_email:[],
                nationality:'',
                phoness:[],
                mobiless:[],
                mobile:'',
                leadStatus:'',
                position:[],
                WebSite:[],
                streets:[],
                states:[],
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
                leads:[],
                lead_status:[],
                status:[],
                currencyId:null,
                nationality_id:[],
                city_id:[],
                country_id:[],
               
                companyName:'',
                companies: [],
                activities:[],
                Policies:[],
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
       
            this.getcity()
            this.getcountry()
            this.getData()
            this.ShowLeadData()
           
         

        },
        created() {
            this.id = this.$route.params.id
        },
        methods: {
            getData(){
                 ShowLeadData(this.id).then(Response=>{
                
                }).catch(error=>{
                     console,log(error);
             })

                
            },
            
        ShowLeadData(id){
            ShowLeadData(this.id).then(Response=>{
                  this.NewCompany=Response.data.data
                 this.companies=Response.data.data
                  this.leads=Response.data.data
                 this.first_name=Response.data.data
                 this.last_name=Response.data.data
                 this.phoness=Response.data.data
                this.faxArr=Response.data.data
                this.email=Response.data.data
                 this.position=Response.data.data
                 this.status=Response.data.data
                 this.streets=Response.data.data
                 this.states=Response.data.data
                this.zip_code=Response.data.data
                 this.Introduction=Response.data.data
                this.Closing=Response.data.data
                this.Policies=Response.data.data
                this.mobiless=Response.data.data  
                this.company_phone=Response.data.data
                this.company_mobile=Response.data.data
                this.company_email=Response.data.data


            
              this.lead_status=Response.data.data
                 console.log("dataaaaaaaaaaaaaaaaaaaaaa",this.companies)
                  console.log("ressssssssss",Response.data.data)
             }).catch(error=>{
                  console.log(error);
             })
            },


        getcity(id){
              getcity(this.id).then(Response=>{
                  this.cities=Response.data.data
              }).catch(error=>{
                  console.log(error);
              })
          },
         getcountry(id){
              getcountry(this.id).then(Response=>{
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

.card {
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.18);
    margin-bottom: 2rem;
    margin-left: -2% !important;
}
</style>










    