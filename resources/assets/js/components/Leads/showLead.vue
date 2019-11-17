  <template>
    <div class="container" style="background-color:#fff;padding:1%">
        <div class="columns is-12 is-mobile" style="margin-bottom:3%">
            <div class="column is-2">
                <b class="newCompany" style="font-size:18px">New Lead</b>
            </div>
        </div>

        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
               <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000">Comapany Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
            <div class="column is-2" style="margin-top:6%">  </div>
            
             <div class="column is-5" style="margin-top:6%">

                <b-field>
                    <label class="column is-4">Company Name</label>
                    <b-input style="margin-left:5%"  
                     v-for="company in companies" :key="company.id"
                      v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   
                <b-field>
                    <label class="column is-4">Lead Type</label>
                    <b-input  style="margin-left:5%; " v-for="lead in leads "
                     :key="lead.id" v-model="lead.lead_type"  type="text"   ></b-input>
                </b-field>
             
                 <b-field v-for="(data, index) in companyphones" :key="'a'+index"  >

                    <label class="column is-4">Phone</label>
                    <b-input class="Leaad" type="number" style="margin-left:5%;"   min="0" 
                       v-for="phone in company_phone " :key="phone.id"
                     v-model="phone.phone" ></b-input>
                    <div class="column is-4">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeCompanyPhone(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addCompanyPhone"></span>
                    </div>
                </b-field>

                 <b-field v-for="(data, index) in companymobiles" :key="'b'+index" >
                      <label class="column is-4">Mobile</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0" 
                          v-for="mob in company_mobile " :key="mob.id"
                     v-model="mob.mobile" ></b-input>
                      <div class="column is-4">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeCompanyMobile(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addCompanyMobile"></span> 
                      </div>
                </b-field>

                <b-field v-for="(data, index) in companyemails" :key="'d'+index" >
                      <label class="column is-4">Email</label>
                      <b-input class="Leaad" type="email" style="margin-left:5%;"   min="0" 
                      v-for="mail in company_email " :key="mail.id"
                       v-model="mail.compamymail" ></b-input>
                      <div class="column is-4">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeCompanyMail(index,data)"></span> 
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addCompanyMail"></span> 
                      </div>
                </b-field>

                <b-field v-for="(data, index) in companyfaxes" :key="'b'+index" >
                      <label class="column is-4">Fax</label>
                      <b-input class="Leaad" type="number" style="margin-left:5%;" min="0" 
                          v-for="fax in faxes " :key="fax.id"
                     v-model="fax.mobile" ></b-input>
                      <div class="column is-4">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeFaxField(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addFaxField"></span> 
                      </div>
                </b-field>
                

            

            </div>

            <div class="column is-5" style="margin-top:6%">
                
                
                  <b-field style="padding-bottom: 1%;">
                    <label class="column is-4">Webiste</label>
                    <b-input style="margin-left:5%"  
                     v-for="company in companies" :key="company.id"
                      v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   

                <b-field style="padding-bottom: 1%;">
                    <label class="column is-4">Industry</label>
                    <b-input style="margin-left:5%"  
                     v-for="company in companies" :key="company.id"
                      v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   

                   <b-field style="padding-bottom: 1%;">
                    <label class="column is-4">Annual Revenu</label>
                    <b-input style="margin-left:5%"  
                     v-for="company in companies" :key="company.id"
                      v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   

                  <b-field style="padding-bottom: 1%;">
                    <label class="column is-4">Employees</label>
                    <b-input style="margin-left:5%"  
                     v-for="company in companies" :key="company.id"
                      v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   
                 <b-field style="padding-bottom: 1%;">
                    <label class="column is-4">Commercial registration</label>
                    <b-input style="margin-left:5%"  
                     v-for="company in companies" :key="company.id"
                      v-model="company.company_name" type="text"> </b-input>

                 
                </b-field>   

                 
                 <b-field style="padding-bottom: 1%;">
                    <label  class="column is-3">Rating</label>
                    <b-select v-model="nationality_id" placeholder="Select Rating " expanded>
                       <option v-for="nationality in nationalities " :key="nationality.id" :value="nationality.id" >{{nationality.nationality}}</option>
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
<!-- begin address section -->
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
<br><br><br>
         <!-- begin notes -->
        
      <div class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
         
               <h4 style="color:#9A9A9A;">Notes for this lead</h4>
              <div class="column is-1">
             <i class="fas fa-angle-double-down" style="font-size: 31px; margin-left: 14%;" 
               v-on:click="isHiddenNotes = !isHiddenNotes"></i>
             
            </div>
          
      </div>

      <div  class="columns is-12" style="background-color:#F3F3F3;margin-top:3% ; padding:4%" v-if="!isHiddenNotes"> 
                
                <div class=" columns is-6 notes">
                     <b-field v-for="(data, index) in companymobiles" :key="'b'+index" >
                    
                      <b-input class="Leaad" type="text" style="margin-left:5%;" 
                          v-for="mob in company_mobile " :key="mob.id" placeholder="Add new note"> </b-input>
                      <div class="">
                        <span v-if="index > 0"><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeCompanyMobile(index,data)"></span>
                        <span v-else><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addCompanyMobile"></span> 
                      </div>
                </b-field>
                </div>


      </div>

     <!-- end notes -->

     <br><br><br>
  <!-- begin attachment -->
     <div class="columns is-12 plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
         
               <h4 style="color:#9A9A9A;">Attachements</h4>
              <div class="column is-1">
             <i class="fas fa-angle-double-down" style="font-size: 31px; margin-left: 14%;" 
               v-on:click ="isHiddenAttach=!isHiddenAttach"></i>
             
            </div>
          
      </div>
      
     <div class="columns is-12 is-mobile" style="margin-top:1% ; padding:4%" v-if="isHiddenAttach">
       <div class="column is-8">
              <b-field class="file">
                    <b-upload v-model="file">
                        <a class="button is-primary">
                            <i class="fas fa-paperclip"></i>&nbsp &nbsp
                            <span>Add An Attachement</span>
                        </a>
                    </b-upload>
                    <span class="file-name" v-if="file">
                        {{ file.name }}
                    </span>
              </b-field>
        </div>
     </div>

     <!-- end attachment -->
       <br><br><br>

       <!-- begin events -->

        <div class="columns is-12 is-mobile plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
               <h4 style="color:#9A9A9A;">Open activities and Events</h4>
      
           <div class="column is-1">
               <i class="fas fa-angle-double-down" style="font-size: 31px; margin-left: 14%;" 
               v-on:click="isHiddenEvents = !isHiddenEvents"></i>
           </div>
        </div>

         <div class="columns is-12" style="margin-bottom:2%" v-if="!isHiddenEvents">
            <div class="column is-2">
                <b-field>
                    <i class="fas fa-tasks"></i>&nbsp &nbsp
                    <span style="color:rgb(100, 136, 213);cursor:pointer" @click="openModal">New Task</span>
                </b-field>
            </div>
             <div class="column is-2">
                <b-field>
                    <i class="fas fa-calendar-alt"></i>&nbsp &nbsp
                    <span  style="color:rgb(100, 136, 213);cursor:pointer" @click="openEventModal">New Event</span>
                </b-field>
            </div>
            <!-- task model -->

           <b-modal :active.sync="isComponentModalActive" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Kickers</p>
                            </header>
                            <section class="modal-card-body">
                            <b-field>
                                <b-select v-model="task_contact" placeholder="Select Contact" expanded>
                                    <option>Mohamed</option>
                                </b-select>
                            </b-field>

                            <b-field>
                                <b-input v-model="task_note" type="textarea" placeholder="Activity Description"></b-input>                                 
                            </b-field>

                            <b-field>
                                <b-datepicker v-model="task_date"
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>
                             
                            <b-field>
                                <i class="fas fa-bell"></i>&nbsp &nbsp
                                <span  style="color:rgb(100, 136, 213)" v-on:click="isHiddenNotifications = !isHiddenNotifications">Notifications</span>
                            </b-field>

                            <div class="field" v-if="!isHiddenNotifications">
                                <b-checkbox>Notify Me By System Notification</b-checkbox><br>
                                <b-checkbox>Notify Me By SMS</b-checkbox><br>
                                <b-checkbox>Notify Me By Mail</b-checkbox>
                            </div>                   
                            
                            </section>
                            <footer class="modal-card-foot">
                                <b-button @click="savetask" type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
                                <button class="button" type="button" @click="isComponentModalActive = false">Cancel</button>
                            </footer>
                        </div>
                </b-modal>

                  <!-- modal event -->

                 <b-modal :active.sync="isComponentModalEventActive" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                    
                            <section class="modal-card-body">

                                <b-field>
                                    <b-select placeholder="Select Contact" expanded>
                                        <option>Mohamed</option>
                                    </b-select>
                                </b-field>
                                
                                <h4>Kickers</h4>
                                <b-field>
                                    <b-select placeholder="Select Contact" expanded>
                                        <option>Mohamed</option>
                                        <option>Kirolos</option>
                                    </b-select>
                                </b-field>

                                <b-field>
                                    <b-input type="text" placeholder="Event Name"></b-input>                                 
                                </b-field>
                                
                                <b-field>
                                    <b-input type="textarea" placeholder="Details"></b-input>                                 
                                </b-field>

                                <b-field>
                                    <b-select placeholder="Where" expanded>
                                        <option>Cairo</option>
                                    </b-select>
                                </b-field>

                                <b-field>
                                    <b-datepicker
                                        icon="calendar-today">
                                    </b-datepicker>
                                </b-field>

                                <b-field>
                                    <b-select placeholder="AT" expanded>
                                        <option>12:00 pm</option>
                                        <option>11:00 pm</option>
                                    </b-select>
                                </b-field>

                                <b-field>
                                    <b-datepicker
                                        icon="calendar-today">
                                    </b-datepicker>
                                </b-field>

                                <b-field>
                                    <b-select placeholder="AT" expanded>
                                        <option>12:00 pm</option>
                                        <option>11:00 pm</option>
                                    </b-select>
                                </b-field>
                                
                                <b-field>
                                    <i class="fas fa-bell"></i>&nbsp &nbsp
                                    <span  style="color:rgb(100, 136, 213)" v-on:click="isHiddenNotificationsEvents = !isHiddenNotificationsEvents">Notifications</span>
                                </b-field>

                                <div class="field" v-if="!isHiddenNotificationsEvents">
                                    <b-checkbox>Notify Me By System Notification</b-checkbox><br>
                                    <b-checkbox>Notify Me By SMS</b-checkbox><br>
                                    <b-checkbox>Notify Me By Mail</b-checkbox>
                                </div>                   
                                
                            </section>
                            <footer class="modal-card-foot">
                                <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
                                <button class="button" type="button" @click="isComponentModalEventActive = false">Cancel</button>
                            </footer>
                        </div>
                </b-modal>

                <!-- end modal event -->


         </div>
        <!--end events -->
    <br><br><br>


         <!-- begin Closed activities and Past Events -->
         
     <div class="columns is-12 is-mobile plusSign" style="padding-bottom: 28px;border-bottom: solid 1px lightgray;">
          
               <h4 style="color:#9A9A9A;">Closed activities and Past Events </h4>
 
           <div class="column is-1">
                <i class="fas fa-angle-double-down" style="font-size: 31px; margin-left: 14%;" 
               v-on:click="isHiddenActivity = !isHiddenActivity"></i>
           </div>

            
    </div>

     <div class="columns is-12" style="margin-bottom:2%" v-if="!isHiddenActivity">
            <div class="column is-2">
                <b-field>
                    <i class="fas fa-tasks"></i>&nbsp; &nbsp;
                    <span style="color:rgb(100, 136, 213);cursor:pointer" >Add Closed Activity</span>
                </b-field>
            </div>
             <div class="column is-2">
                <b-field>
                    <i class="fas fa-calendar-alt"></i>&nbsp; &nbsp;
                    <span  style="color:rgb(100, 136, 213);cursor:pointer" >Add Past Event</span>
                </b-field>
            </div>
            </div>
    <!-- end closed activity modal -->
    <br><br><br>
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
    import{getcity,getcountry,
    ShowLeadData }   from './../../calls'
    export default {
        data() {
            return {
                task_contact:"",
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
               ComMobileArr:[],
               ComPhoneArr:[],
               ComemailArr:[],
                companyName:'',
                companies: [],
                activities:[],
                Policies:[],
                Closing:[],
                Introduction:[],
                dropFiles: [],
                phones:[{ phone:[] }],
                companyphones:[ {companyphone:[]} ],
                companymobiles:[{ companymobile:[] }],
                companyemails:[{companyemail:[]}],
                companyfaxes:[
                    {
                        companyfax:[]
                    }
                ],
                faxes:[],
                mobileArr:[],
                emailArr:[],
                faxArr:[],
                contact_array: [],
                address_array:[],
                isHiddenAttach:false,
                isHiddenNotes:true,
                mobiles:[{
                    mobiles:[]
                }],
                emails:[{
                    emails:[]
                }],
                
                addresses:[{
                    addresses:[]
                }],
                contacts:[{
                    contacts:[]
                }],
                file: null,
                isHiddenEvents:true,
                isComponentModalActive: false,  
                isComponentModalEventActive: false,  
                isHiddenActivity:true,
                isComponentModalColsedActivity:false,
                isHiddenNotificationsEvents:true,
                isHiddenNotifications:true,
                 task_date:"",
                 task_note:'',
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
            savetask(){
                     this.task_array.push({
                        task_contact:this.task_contact,
                        task_note:this.task_note,
                        task_date:this.task_date
                     })
                     console.log("task",this.task_array)
        },
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
                 this.faxes=Response.data.data



            
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
         removeCompanyPhone(indexph,data){

            var idx = this.companyphones.indexOf(data);
            if (idx > -1) {
             this.companyphones.splice(idx,1);
             this.ComPhoneArr[indexph]='';
            }

        },
         removeCompanyMobile(index,data){
            var idx = this.companymobiles.indexOf(data);
            if (idx > -1) {
                this.companymobiles.splice(idx, 1);
                 this.ComMobileArr[index]='';
            }
        },
         removeCompanyMail(indexMail,email){
            var idx = this.companyemails.indexOf(email);
            console.log(idx, indexMail);
            if (idx > -1) {
                this.companyemails.splice(idx, 1);
                this.ComemailArr[indexMail]='';
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
                 this.mobileArr[indexMob]='';
            }
        },
        removeMailField(indexMail,email){
            var idx = this.emails.indexOf(email);
            console.log(idx, indexMail);
            if (idx > -1) {
                this.emails.splice(idx, 1);
                this.emailArr[indexMail]='';
            }
        },
        removeFaxField(indexFax,fax){
             var idx = this.companyfaxes.indexOf(fax);
            console.log(idx, indexFax);
            if (idx > -1) {
                this.companyfaxes.splice(idx, 1);
                this.faxArr[indexFax]='';

            }
        },
        deleteDropFile(index) {
            this.dropFiles.splice(index, 1)
        },
        addCompanyPhone(){
            this.companyphones.push(this.companyphones.length+1)
            this.flag+=1;
        },
         addCompanyMobile(){
            this.companymobiles.push(this.companymobiles.length+1)
            this.flag+=1;
        },
         addCompanyMail(){
         this.companyemails.push(this.companyemails.length+1)
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
            this.companyfaxes.push( this.companyfaxes.length+1)
        },
         addAddress(){
         this.addresses.push( this.addresses.length+1)
        },
        addContact(){

         this.contacts.push( this.contacts.length+1)


        },
         toggleInputsActive(){
                this.disabled = !this.disabled
        },

        openModal(){
            this.isComponentModalActive = true
        },
        openEventModal(){
            this.isComponentModalEventActive = true
        },
             openColsedActivityModal(){
            this.isComponentModalColsedActivity = true
        },
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

.notes{
    width: 100% !important;
    /* margin-left: -28%; */
}
.file-name {
    margin-left: 3% !important; 
}
</style>










    