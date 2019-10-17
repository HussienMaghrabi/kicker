<template>
     <div style="position: relative">
            <article class="media">
                <div class="media-left">
                    <figure class="image avatarImage">
                        <img src="/website_cover_81698172832.jpg">
                    </figure>
                    <!-- <span class="nameSpan" v-else>{{getShortName()}}</span> -->
                </div>
                <div class="media-content">
                <div class="content">
                    <div class="columns is-mobile is-12">
                        <div class="column is-6 respo-header show-lead" style="display: block; margin-top: 0; margin-left: 0">
                            <h3 class="lead"> Kirolos &nbsp &nbsp<i class="far fa-user" style="color:#444 !important"></i></h3>
                            
                            <p>Lead Owner  : <span> {{ getleads.prefix_name}} </span>.{{ getleads.first_name }}. </p>
                            <p>Email  : {{ getleads.email }} </p>
                            <p>Phone  : {{ getleads.phone}}  </p>
                            <!-- <p>Mobile  : {{ getleads.prefix_name}}  </p> -->
                            <!-- <div class="columns is-12 is-mobile"> -->
                               <p class="column">Lead status  : </p>
                             
                            <!-- </div> -->
                               <div class="field column is-12" style="margin-bottom: 5%;">
                                        <div class="select">
                                        <select>
                                            <option value="Contacted" selected>Contacted</option>
                                            <option value="Not Contacted">Not Contacted</option>
                                        </select>
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>
                </div>
            </article>

     <!-- begin company -->
     <div class="container">

       <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Comapany Data</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHidden = !isHidden"></i>
           </div>
       </div>

        <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHidden">
            <div class="columns is-12 is-mobile">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
            <div class="columns is-12" style="margin-left:1%;">
                <div class="column is-6">
                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Company Name</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>
                     
                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Phone</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Mobile</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Email</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Fax</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Website</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                </div>

                <div class="column is-6">
                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Lead source</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Industry</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Annual revenu</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">#Employees</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Commercial registration</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Ratings</label>
                            <b-input class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                </div>
             </div>   

              <div class="columns is-12 is-mobile text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div>

        </div> 


       
     <!-- End Company -->

     <!-- begin address -->
     <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Address</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenAdderess = !isHiddenAdderess"></i>
           </div>
     </div>

       <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHiddenAdderess">
            <div class="columns is-12 is-mobile">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
            <div class="columns is-12 " style="margin-left:1%;">
                <div class="column is-6">

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Street</label>
                            <b-input  class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">State</label>
                            <b-input  class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>
                    
                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Country</label>
                            <b-select  class="sub-input" :disabled="disabled" placeholder="Select a Country">
                                <option value="flint">Flint</option>
                                <option value="silver">Silver</option>
                            </b-select>
                        </b-field>
                    </div>

                   
                </div>

                <div class="column is-6">
                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">City</label>
                            <b-select  class="sub-input" :disabled="disabled" placeholder="Select a City">
                                <option value="flint">Flint</option>
                                <option value="silver">Silver</option>
                            </b-select>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Zip Code</label>
                            <b-input  class="sub-input" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                </div>
             </div>   

              <div class="columns is-12 is-mobile text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div>

       </div>
        <!-- end address -->

        <!-- begin contact person -->
      
      <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Contact Person</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenContact = !isHiddenContact"></i>
           </div>
      </div>
      
      <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHiddenContact">
            <div class="columns is-12 is-mobile">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
       <div class="columns is-12" style="margin-left:1%;">
                <div class="column is-6">

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">First Name</label>
                            <b-input  class="sub-input" type="text" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Last Name</label>
                            <b-input  class="sub-input" type="text" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Email</label>
                            <b-input  class="sub-input" type="email" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Nationality</label>
                            <b-select  class="sub-input" :disabled="disabled" placeholder="Select a Nationality">
                                <option value="flint">Flint</option>
                                <option value="silver">Silver</option>
                            </b-select>
                        </b-field>
                    </div>

                </div>

                <div class="column is-6">

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Phone</label>
                            <b-input  class="sub-input" type="number" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Mobile</label>
                            <b-input  class="sub-input" type="number" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Lead Status</label>
                            <b-select  class="sub-input" :disabled="disabled" placeholder="Select a Lead Status">
                                <option value="flint">Flint</option>
                                <option value="silver">Silver</option>
                            </b-select>
                        </b-field>
                    </div>

                    <div class="column is-12">
                        <b-field class="column is-12">
                            <label class="column is-3">Position</label>
                            <b-input  class="sub-input" type="number" :disabled="disabled"></b-input>
                        </b-field>
                    </div>

                </div>
             </div>   

              <div class="columns is-12 is-mobile text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div>
      </div>
        
     <!-- end contact person -->
     
     <!-- begin notes -->
      <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Notes for this lead</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenNotes = !isHiddenNotes"></i>
           </div>
      </div>

      <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHiddenNotes">
            <div class="columns is-12 is-mobile">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
            <div class="columns is-12 is-mobile" style="margin-left:1%;">
                <div class="column is-6 ">
                      <img style="max-width:7%;" class="imgProfile" src="/website_cover_81698172832.jpg">
                </div>
                <div class="column is-6 notes">
                    <b-field style="display:flex;" class="textareaa">
                        <b-input  type="textarea" placeholder="Add New Notes" :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>  

              <div class="columns is-12 is-mobile text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div> 
      </div>

     <!-- end notes -->

     <!-- begin attachment -->
     <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Attachements</h4>
           </div>
      </div>
      
     <div class="columns is-12 is-mobile" style="margin-bottom:2%">
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

     <!-- begin events -->

        <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Open activities and Events</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenEvents = !isHiddenEvents"></i>
           </div>
        </div>

       <div class="columns is-12" style="margin-bottom:2%">
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

             <b-modal :active.sync="isComponentModalActive" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Kickers</p>
                            </header>
                            <section class="modal-card-body">
                            <b-field>
                                <b-select placeholder="Select Contact" expanded>
                                    <option>Mohamed</option>
                                </b-select>
                            </b-field>

                            <b-field>
                                <b-input type="textarea" placeholder="Activity Description"></b-input>                                 
                            </b-field>

                            <b-field>
                                <b-datepicker
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
                                <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
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

     <!-- end events -->

     <!-- begin Closed activities and Past Events -->
     
     <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Closed activities and Past Events </h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenActivity = !isHiddenActivity"></i>
           </div>
    </div>

     <div class="columns is-12" style="margin-bottom:2%">
            <div class="column is-2">
                <b-field>
                    <i class="fas fa-tasks"></i>&nbsp &nbsp
                    <span style="color:rgb(100, 136, 213);cursor:pointer" @click="openColsedActivityModal">Add Closed Activity</span>
                </b-field>
            </div>
            <div class="column is-2">
                <b-field>
                    <i class="fas fa-calendar-alt"></i>&nbsp &nbsp
                    <span  style="color:rgb(100, 136, 213);cursor:pointer" @click="openEventModal">Add Past Event</span>
                </b-field>
            </div>

            <!-- begin closed activity modal -->
             
              <b-modal :active.sync="isComponentModalColsedActivity" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Kickers</p>
                            </header>
                            <section class="modal-card-body">
                            <b-field>
                                <b-select placeholder="Select Contact" expanded>
                                    <option>Mohamed</option>
                                </b-select>
                            </b-field>

                            <b-field>
                                <b-input type="textarea" placeholder="Activity Description"></b-input>                                 
                            </b-field>

                            <b-field>
                                <b-datepicker
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
                                <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
                                <button class="button" type="button" @click="isComponentModalColsedActivity = false">Cancel</button>
                            </footer>
                        </div>
                </b-modal>

            <!--  end closed activity modal -->

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

     <!-- end Closed activities and Past Events -->

     <!-- begin Opportunities -->
       
    <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Opportunities</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenOpportunities = !isHiddenOpportunities"></i>
           </div>
    </div>

    <div class="columns is-12" style="background-color:#F3F3F3;padding-left:2%" v-if="!isHiddenOpportunities">
        <div class="column is-12" style="margin-bottom:1%"><a>Proposal No: 271</a></div>
    </div>

    <div class="columns is-12" style="background-color:#F3F3F3;padding-left:2%;margin-bottom:2%" v-if="!isHiddenOpportunities">
        <h6 class="column is-2" style="color:rgb(100, 136, 213)">24-08-2019</h6>
        <h6 class="column is-3">CRM</h6>
        <h6 class="column is-3">Human Resources Management </h6>
        <h6 class="column is-3">Activity and project management </h6>
        <i class="fas fa-trash-alt column is-1" style="cursor:pointer"></i>
    </div>

     <div class="columns is-12" style="padding-left:2%;margin-bottom:3%" v-if="!isHiddenOpportunities">
        <a class="column is-2" style="color:rgb(100, 136, 213)"><i class="fas fa-plus" style="color:#000"></i>&nbsp Create proposal</a>
        <a class="column is-3"><i class="fas fa-plus" style="color:#000"></i>&nbsp Create Contract</a>
        <a class="column is-3"><i class="fas fa-plus" style="color:#000"></i>&nbsp Create invoice </a>
        <a class="column is-3"><i class="fas fa-plus" style="color:#000"></i>&nbsp View opportiunity status </a>
    </div>

     <!-- end Opportunities -->

     <!-- begin projects -->
    <div class="columns is-12 is-mobile">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Projects</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;"></i>
           </div>
    </div>
     <!-- end projects -->

     <!-- begin system -->
    <div class="columns is-12 is-mobile" style="margin-bottom:2%;">
        <div class="column is-8">
            <h4 style="color:#9A9A9A;display:contents">System &nbsp 100%</h4>&nbsp &nbsp&nbsp &nbsp
            <span  style="color:rgb(100, 136, 213);font-size:18px">View progress history</span>
        </div>
        <div class="column is-4">
            <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;"></i>
        </div>
    </div>

     <div class="columns is-12">
        <b-field>
            <i class="fas fa-plus" style="color:#000"></i>&nbsp &nbsp
            <span  style="color:rgb(100, 136, 213);cursor:pointer" @click="openGuranteeModal">Add Gurantee</span>
        </b-field>
     </div>

     <!-- begin Gurantee modal -->
             
              <b-modal :active.sync="isComponentModalGuranteeActive" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Gurantee Period</p>
                            </header>
                            <section class="modal-card-body">
                             <b-field label="Start Date">
                                <b-datepicker
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>

                             <b-field label="End Date">
                                <b-datepicker
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>

                            <b-field>
                                <b-checkbox>Include Terms and conditions</b-checkbox><br>
                            </b-field>
                          
                            </section>
                            <footer class="modal-card-foot">
                                <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
                                <button class="button" type="button" @click="isComponentModalGuranteeActive = false">Cancel</button>
                            </footer>
                        </div>
                </b-modal>

            <!--  end Gurantee modal -->

     <!-- end system -->

     </div>  <!-- end container -->
</div>


    

</template>


<script>
    import {

        getLeadData,
    } from "./../../calls"
export default {
    data() {
            return {
                isLoading: true,
                lead_id:null,
                getleads:[],
                token: window.auth_user.csrf,
                id: null,
                disabled: true,
                isHidden: true,
                isHiddenAdderess:true,
                isHiddenContact:true,
                isHiddenNotes:true,
                isHiddenAttachements:true,
                isHiddenEvents:true,
                isHiddenActivity:true,
                file: null,
                isComponentModalActive: false,  
                isComponentModalEventActive: false,  
                isHiddenNotificationsEvents: true,
                isHiddenOpportunities:true,
                isHiddenNotifications:true,
                isComponentModalColsedActivity:false,
                isComponentModalGuranteeActive:false
            }
        },
    created() {
        this.lead_id= this.$route.params.id
        this.getData()
    },
    mounted() {
    },
    components: {
        
    },
    methods: {
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
        openGuranteeModal(){
            this.isComponentModalGuranteeActive = true
        },
                getData(loading = true) {
                getLeadData(this.lead_id).then(response=>{
                    // console.log('TEEEEEEEES',response)
                    this.getleads = response.data
                    // console.log('this get lead var',this.getleads)
                    this.first_name_value = response.data.lead.first_name
                    // console.log('test response get lead',this.getleads)
                    // new get lead data
                    this.leadData = response.data.lead
                    this.contacts = response.data.contacts
                    this.newCallData.contact_id = 0
                    this.newMeetingData.contact_id = 0
                    this.newCallData.phone = this.leadData.phone
                    this.selectedTags = response.data.lead.tags
                // end new get lead data
                    this.isLoading = false;

                }).catch(error => {
                    console.log(error)
                })
            }

        },
        
}
</script>

<style>
.label {
    color: #444;
}
.control{
    /* width: 50%; */
}
@media screen and (max-width: 767px) {
.show-lead{
 margin-left: 17% !important;
}
.lead{
    margin-top: 25%;
}
.imgProfile{
    max-width: 40% !important;
}
.notes{
    width: 100% !important;
    /* margin-left: -28%; */
}
.textareaa{
    margin-left: -38%;
}
.edit{
    margin-left: 90% !important;
}
}
label{
    font-size: 17px;
    font-weight: 600;
}
.sub-input
{
    float: right;
    width: 70%;
}

</style>