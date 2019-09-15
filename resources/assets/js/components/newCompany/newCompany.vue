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
                <b-field style="padding-right: 6px;">
                    <b-upload v-model="dropFiles" 
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
            </div>

             <div class="column is-6">
                 
                <b-field>
                    <label class="column is-3">Company Name</label>
                    <b-input class="company"   type="text" ></b-input>
                </b-field>   
                <b-field>
                    <label class="column is-3">Activity</label>
                    <b-input class="company" type="text" ></b-input>
                </b-field>   
            </div>

           

            <div class="column is-4">
                <b-field>
                     
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
                </b-field>
                 <b-field>
                    <label  class="column is-3">Currency</label>
                    <b-select expanded class="company2">
                        <option value="Rate" selected>Rate</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
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
                <b-field>
                    <label class="column is-4">First Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="firstName"></b-input>
                </b-field>

                <b-field>
                    <label class="column is-4">Last Name</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="lastName"></b-input>
                </b-field>

                 <b-field>
                      <label class="column is-4">Phone</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" v-model="newPhone"></b-input>
                      <div class="column is-1">
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addPhoneField"></span> 
                      </div>
                </b-field>

                 <b-field v-if="index > 0" v-for="(phone, index) in phones" :key="index">
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
                      <label class="column is-4">Position</label>
                      <b-input class="company" type="text" style="margin-left:5%;" v-model="position"></b-input>
                </b-field>


               
            </div>

            <div class="column is-5"  style="margin-top:6%">
                <b-field>
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
                </b-field>

                 <b-field>
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
                </b-field>

                <b-field>
                    <label  class="column is-3">Nationality</label>
                    <b-select class="company2 column is-3" expanded v-model="nationality">
                        <option value="egyptian">Egyptian</option>
                        <option value="2">Mrs.</option>
                        <option value="3">Ms.</option>
                    </b-select>
                </b-field>
                 <b-field>
                    <label class="column is-4">WebSite</label>
                    <b-input class="company" type="text" style="margin-left:5%;" v-model="WebSite"></b-input>
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
                        <option value="egypt">Egypt</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </b-select>
                </b-field>
            </div>

            <div class="column is-5" style="margin-top:5%">
                 <b-field>
                    <label  class="column is-4">City</label>
                    <b-select class="Leaad2" expanded v-model="city">
                        <option value="egypt">Egypt</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
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
                            <b-button type="is-success" style="margin-top:8px"><i class="fas fa-save"></i>&nbsp;
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
export default {
     data() {
        return {
              
            Policy:'',
            Closing:'',
            Introduction:'',
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
                newFax:'',
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
                firstName:'',
                lastName:'',
                email:'',
                nationality:'',
                phone:'',
                mobile:'',
                leadStatus:'',
                position:''
            }],
        }
     },
      methods: {
        removeAddressfield(indexAddress,address){
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
        addPhoneField(){
             this.phones.push({
               newPhone: '',
            });
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
        },
        addContact(){
            this.contacts.push({
                removebtn:'',
                title:'',
                firstName:'',
                lastName:'',
                email:'',
                nationality:'',
                phone:'',
                mobile:'',
                leadStatus:'',
                position:''
            })
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