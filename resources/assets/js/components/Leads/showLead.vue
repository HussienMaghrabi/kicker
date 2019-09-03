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
                    <div class="columns is-mobile">
                        <div class="column is-6 respo-header" style="display: block; margin-top: 0; margin-left: 0">
                            <h3> Kirolos &nbsp &nbsp<i class="far fa-user" style="color:#444 !important"></i></h3>
                            <p>Lead Owner  : --  </p>
                            <p>Email  : -- </p>
                            <p>Phone  : -- </p>
                            <p>Mobile  : -- </p>
                            <div class="columns is-12">
                               <p class="column is-3">Lead status  : </p>
                                <div class="field column is-6" style="margin-bottom: 5%;">
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
                </div>
            </article>

     <!-- begin company -->
     <div class="container">

       <div class="columns is-12">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Comapany Data</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHidden = !isHidden"></i>
           </div>
       </div>

        <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHidden">
            <div class="columns">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
            <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Company Name">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Lead source">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

             <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Phone">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Industry">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

              <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Mobile">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Annual revenu">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

             <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Email">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="#Employees">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>  

              <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Fax">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Commercial registration">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

             <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Website">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Ratings">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

              <div class="columns is-12 text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div>

        </div> 


       
     <!-- End Company -->

     <!-- begin address -->
     <div class="columns is-12">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Address</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenAdderess = !isHiddenAdderess"></i>
           </div>
     </div>

       <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHiddenAdderess">
            <div class="columns">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
            <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Street">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="City">
                        <b-select :disabled="disabled" style="margin-left:5%;" placeholder="Select a City" expanded>
                            <option value="flint">Flint</option>
                            <option value="silver">Silver</option>
                        </b-select>
                    </b-field>
                </div>
             </div>   

             <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="State">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Zip Code">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

              <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Country">
                       <b-select :disabled="disabled" style="margin-left:5%;" placeholder="Select a Country" expanded>
                            <option value="flint">Flint</option>
                            <option value="silver">Silver</option>
                        </b-select>
                    </b-field>
                </div>
              </div>

              <div class="columns is-12 text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div>

       </div>
        <!-- end address -->

        <!-- begin contact person -->
      
      <div class="columns is-12">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Contact Person</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenContact = !isHiddenContact"></i>
           </div>
      </div>
      
      <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHiddenContact">
            <div class="columns">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
       <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="First Name">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Phone">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

             <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Last name">
                        <b-input :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Mobile">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>   

              <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Email">
                        <b-input type="email" :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Lead Status">
                         <div class="control has-icons-left">
                         <div class="select">
                            <select  :disabled="disabled" style="margin-left:5%;">
                                <option value="Contacted" selected>Contacted</option>
                                <option value="Not Contacted">Not Contacted</option>
                            </select>
                         </div>
                         </div>
                     </b-field>
                </div>
             </div>   

             <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                    <b-field style="display:flex;" label="Nationality">
                       <div class="control has-icons-left">
                         <div class="select">
                            <select  :disabled="disabled" style="margin-left:5%;">
                                <option value="Contacted" selected>Contacted</option>
                                <option value="Not Contacted">Not Contacted</option>
                            </select>
                         </div>
                         </div>
                    </b-field>
                </div>

                <div class="column is-6">
                    <b-field style="display:flex" label="Position">
                        <b-input  :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div> 

              <div class="columns is-12 text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div>
      </div>
        
     <!-- end contact person -->
     
     <!-- begin notes -->
      <div class="columns is-12">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Notes for this lead</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;" 
               v-on:click="isHiddenNotes = !isHiddenNotes"></i>
           </div>
      </div>

      <div style="background-color:#F3F3F3;margin-bottom:3%;" v-if="!isHiddenNotes">
            <div class="columns">
                <i style="margin-left:98%;margin-top:2%;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" 
                @click="toggleInputsActive"></i>                
            </div><hr>
            
            <div class="columns" style="margin-left:1%;">
                <div class="column is-6">
                      <img style="max-width:7%;" src="/website_cover_81698172832.jpg">
                </div>
                <div class="column is-6">
                    <b-field style="display:flex;">
                        <b-input type="textarea" placeholder="Add New Notes" :disabled="disabled" style="margin-left:5%;"></b-input>
                    </b-field>
                </div>
             </div>  

              <div class="columns is-12 text-center" style="margin:auto;margin-left:3%;padding-bottom:2%;">
                   <b-button :disabled="disabled"  type="is-success" icon-right="pen"> Edit </b-button>
              </div> 
      </div>

     <!-- end notes -->

     <!-- begin attachment -->
     <div class="columns is-12">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Attachements</h4>
           </div>
      </div>
      
     <div class="columns is-12" style="margin-bottom:2%">
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

        <div class="columns is-12">
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
     
     <div class="columns is-12">
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
       
    <div class="columns is-12">
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
    <div class="columns is-12">
           <div class="column is-8">
               <h4 style="color:#9A9A9A;">Projects</h4>
           </div>
           <div class="column is-4">
               <i class="fas fa-arrow-circle-down" style="font-size:23px;float:right;cursor:pointer;"></i>
           </div>
    </div>
     <!-- end projects -->

     <!-- begin system -->
    <div class="columns is-12" style="margin-bottom:2%;">
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
import {} from './../../calls'
export default {
    data() {
            return {
                isLoading: true,
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
        this.id = this.$route.params.id
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
</style>