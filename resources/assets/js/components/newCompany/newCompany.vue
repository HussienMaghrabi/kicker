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
                        drag-drop  @change="onFileChange">
                        <section class="section">
                            <div class="content has-text-centered">
                                <img src="/img/placeholder.png">
                                <!--   -->
                                <!-- <p>
                                    <b-icon
                                        icon="upload"
                                        size="is-large">
                                    </b-icon>
                                </p>
                                <p id="dropDiv">Drop your files here or click to upload</p> -->
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

           

            <!-- <div class="column is-4"> -->
                <!-- <b-field>
                     
                    <label  class="column is-3">
                      <b-checkbox style="margin-right:3px;margin-left:0px;">Sub To</b-checkbox>
                    </label>
                    <b-select expanded class="company2">
                        <option value="Rate" selected>Rate</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </b-select>
                </b-field> -->
                
            <!-- </div> -->

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
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="firstName[indexContact]"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Last Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="lastName[indexContact]"></b-input>
                </b-field>
                 
                 <!-- <b-field>
                      <label class="column is-4">Phone</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="phones.phone"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span> 
                      </div>
                </b-field> -->
                <!-- v-model="phoneArr[indexContact]" -->
                <!-- v-model.number="phones[data]"  -->
                 <b-field v-for="(data, index) in phones" :key="'a'+index" >
                     
                      <label class="column is-4">Phone</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0" v-model="phoneArr[index]" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removePhoneField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span> 
                      </div>
                </b-field>
                 <b-field v-for="(data, index) in mobiles" :key="'b'+index" >
                      <label class="column is-4">Mobile</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"   v-model="mobileArr[index]" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMobileField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMobileField"></span> 
                      </div>
                </b-field>

                <!-- <b-field>
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
                </b-field> -->
                 <b-field>
                      <label class="column is-4">Position</label>
                      <b-input class="company" type="text" style="margin-left:5%;" v-model="position[indexContact]"></b-input>
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

                <!-- <b-field>
                      <label class="column is-4">Fax</label>
                      <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="newFax"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span> 
                      </div>
                </b-field>

                 <b-field v-if="index > 0" v-for="(Fax, index) in faxes" :key="index">
                      <label class="column is-4">Fax</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="newFax"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(index,Fax)"></span> 
                      </div>
                </b-field> -->
                <b-field v-for="(data, index) in emails" :key="'d'+index" >
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="email" style="margin-left:5%;"   v-model="emailArr[index]" ></b-input>
                      <div class="column is-1">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField"></span> 
                      </div>
                </b-field>

                 <!-- <b-field>
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="newMail"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addMailField(index,Fax)"></span> 
                      </div>
                </b-field>

                 <b-field v-if="index > 0" v-for="(Email, index) in emails" :key="index">
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="newMail"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeMailField(index,Email)"></span> 
                      </div>
                </b-field> -->

                 <b-field>
                    <label  class="column is-3">Nationality</label>
                    <b-select v-model="nationalityId[indexContact]" placeholder="Select Nationality"  expanded>
                       <option v-for="nationality in nationalities " :key="nationality.id" :value="nationality.id" >{{nationality.nationality}}</option>
                    </b-select>
                </b-field>

                 <b-field>
                    <label class="column is-4">WebSite</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="WebSite[indexContact]"></b-input>
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
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="street[indexAddress]"></b-input>
                </b-field> 

                <b-field>
                    <label class="column is-4">State</label>
                    <b-input class="Leaad" type="text" style="margin-left:5%;" v-model="state[indexAddress]"></b-input>
                </b-field>
                 <b-field>
                    <label  class="column is-3">Country</label>
                    <b-select v-model="countryId[indexAddress]" placeholder="Select Country"  expanded>
                       <option v-for="country in countries " :key="country.id" :value="country.id" >{{country.name}}</option>
                    </b-select>
                </b-field>

            </div>

            <div class="column is-5" style="margin-top:5%">
                <b-field>
                    <label  class="column is-3">City</label>
                    <b-select v-model="cityId[indexAddress]" placeholder="Select City"  expanded>
                       <option v-for="city in cities " :key="city.id" :value="city.id" >{{city.name}}</option>
                    </b-select>
                </b-field>
                <b-field>
                    <label class="column is-4">Zip Code</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;" min="0"  v-model="zipCode[indexAddress]"></b-input>
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
                            <b-button type="is-success" style="margin-top:8px" @click="addNewProposedCompany()"><i class="fas fa-save"></i>&nbsp;
                               Save
                             </b-button>
                             <b-button type="is-danger" style="margin-top:8px"><i class="fas fa-remove "></i>&nbsp;
                              Cancel
                             </b-button>
                        </div>
                    </div>
                    
                </div>
            </div>

    

    </div>

</template>

<script>
import{getAllCurrency,getAllNationality,getAllCities,getAllCountries, dashgetstatus,addNewProposedCompany}   from './../../calls'
export default {
     data() {
        return {
            contactsArray:[],
                removebtn:'',
                title:'',
                firstName:[],
                lastName:[],
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
                zipCode:[],
                token:window.auth_user.csrf,
                NewCompany:[],
                indexContact:0,
            currencies:[],
            nationalities:[],
            cities:[],
            countries:[],
            activity:'',
            currencyId:null,
            nationalityId:[],
            cityId:[],
            countryId:[],
            companyName:'',
            Policy:'',
            Closing:'',
            Introduction:'',
            dropFiles: [],
            phones:[{ phone:[] }],
            phoneArr:[],
            mobileArr:[],
            emailArr:[],
            faxArr:[],
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
     
    },
      methods: {
        
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
                    // bodyFormData.set(key, value);
                }
                bodyFormData.append('image',this.NewCompany.dropFiles[0])
                bodyFormData.append('companyName',this.companyName);

          
            //     '_token':this.token,
            bodyFormData.append('activity',this.activity)
            bodyFormData.append('currencyId',this.currencyId)
            bodyFormData.append('firstName',this.firstName)
            bodyFormData.append('lastName',this.lastName)
            bodyFormData.append('phones',JSON.stringify(this.phoneArr))
            bodyFormData.append( 'mobiles',JSON.stringify(this.mobileArr))
            bodyFormData.append('position',this.position)
            bodyFormData.append('faxies',JSON.stringify(this.faxArr))
            bodyFormData.append('emails',JSON.stringify(this.emailArr))
            bodyFormData.append('nationlityId',this.nationalityId)
            bodyFormData.append('webSite',this.WebSite)
            bodyFormData.append('street',JSON.stringify(this.street))
            bodyFormData.append('state',JSON.stringify(this.state))
            bodyFormData.append('countryId',JSON.stringify(this.countryId))
            bodyFormData.append('city',JSON.stringify(this.cityId))
            bodyFormData.append('zipCode',JSON.stringify(this.zipCode))
            bodyFormData.append( 'introduction',this.Introduction)
            bodyFormData.append( 'closing',this.Closing)
            bodyFormData.append('policy',this.Policy)
            bodyFormData.append('contactsArray',JSON.stringify(this.contactsArray))
         
           
              addNewProposedCompany(bodyFormData).then(Response=>{
                //   console.log("the returned Value is ",Response.data)
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