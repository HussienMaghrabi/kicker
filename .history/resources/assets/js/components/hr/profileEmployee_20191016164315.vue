<template>
    <section class="container">
       <div class="columns is-12">
           <div class="column is-4">
               <img src="/website_cover_81698172832.jpg" style="max-width:40%;margin-left:7%;border:solid 3px #b07d12; "/>
           </div>

           <div style="margin-top:5%;" class="is-4">
               <i class="far fa-user"></i>    <h4 style="display:-webkit-inline-box;color:#b07d12;font-weight:700;"> 
                   {{ employees.en_first_name }}
               </h4>
           </div> 

       </div>

       <div class="columns is-12">
           <div id="chart" class="column is-4" >
               <apexchart type=pie width=380 :options="chartOptions" :series="series" />
           </div>

           <div id="app" class="column is-5" style="margin-top:10%;">
              <progress-bar size="large" bar-color="#dc720f" val="98" text="98%"></progress-bar>
          </div>
       </div>


       <div class="columns">
         
                <b-tabs v-model="activeTab">
                    <b-tab-item label="Personal Data">
                       <div class="box-header with-border headerr">
                           <h1 style="font-weight:bold;">Employee Profile</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">More Information</h3><hr>
                        </div>

                         <div class="inner-box-body">
                                 <div class="columns is-multiline">
                                     <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                First Name [EN]:
                                                <span v-if="!edit.en_first_name" id="en_first_name" class="">
                                                    {{ employees.en_first_name }}
                                                </span>
                                                <i v-if="!edit.en_first_name" @click="fn_edit('en_first_name')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="en_first_name"
                                                    id="first_name_btn"></i>
                                                <i v-if="edit.en_first_name" @click="fn_edit('en_first_name')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="en_first_name"
                                                    id="first_name_save"></i>
                                                <span v-if="edit.en_first_name" id="first_name_input" class="">
                                                    <input type="text" class="update_input" v-model="employees.en_first_name" 
                                                        id="first_name_update">
                                                </span>
                                            </div>
                                        </div>
                                        
                                     <div class="column is-1 border_right"> </div>
                                        
                                        <div class="column is-5 head_margin_top">
                                            Middle Name [EN] : 
                                             <span v-if="!edit.en_middle_name" id="en_middle_name" class="">
                                                {{ employees.en_middle_name }}
                                            </span> 
                                            <i v-if="!edit.en_middle_name" @click="fn_edit('en_middle_name')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="en_middle_name"
                                                id="middle_name_btn"></i>

                                            <i v-if="edit.en_middle_name" @click="fn_edit('en_middle_name')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="en_middle_name"
                                                id="middle_name_save"></i>

                                            <span v-if="edit.en_middle_name" id="middle_name_input" class="hidden">
                                                <input type="text" class="update_input" value="mohamed"
                                                    id="middle_name_update"  v-model="employees.en_middle_name">
                                            </span>
                                        </div>

                                         <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Last Name [EN] :
                                                 <span v-if="!edit.en_last_name" id="last_name" class="">
                                                    {{ employees.en_last_name }}
                                                 </span> 
                                                <i v-if="!edit.en_last_name" @click="fn_edit('en_last_name')"
                                                   class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="en_last_name"
                                                    id="last_name_btn"></i>
                                                <i v-if="edit.en_last_name" @click="fn_edit('en_last_name')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="en_last_name"
                                                    id="last_name_save"></i>
                                                <span v-if="edit.en_last_name" id="last_name_input" class="hidden">
                                                    <input type="text" v-model="employees.en_last_name" class="update_input" value="hassan"
                                                        id="last_name_update">
                                                </span>
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>

                                         <div class="column is-5 head_margin_top">
                                            Arabic First Name :
                                             <span v-if="!edit.ar_first_name" id="ar_first_name" class="">
                                                {{ employees.ar_first_name }}
                                             </span>  
                                            <i v-if="!edit.ar_first_name" @click="fn_edit('ar_first_name')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="ar_first_name"
                                                id="ar_first_name"></i>

                                            <i v-if="edit.ar_first_name" @click="fn_edit('ar_first_name')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="ar_first_name"
                                                id="ar_first_name"></i>
                                            <span v-if="edit.ar_first_name" id="ar_first_name" class="">
                                                <input type="text" v-model="employees.ar_first_name" class="update_input" value="arabic first name"
                                                    id="ar_first_name">
                                            </span>
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Arabic Middle Name :
                                                 <span v-if="!edit.ar_middle_name" id="ar_middle_name" class="">
                                                    {{ employees.ar_middle_name }}
                                                 </span> 
                                                <i v-if="!edit.ar_middle_name" @click="fn_edit('ar_middle_name')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="ar_middle_name"
                                                    id="ar_middle_name_btn"></i>
                                                <i v-if="edit.ar_middle_name" @click="fn_edit('ar_middle_name')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="ar_middle_name"
                                                    id="ar_middle_name_save"></i>
                                                <span v-if="edit.ar_middle_name" id="ar_middle_name_input" class="">
                                                    <input type="text" class="update_input" value="arabic middle name"
                                                        id="ar_middle_name_update" v-model="employees.ar_middle_name">
                                                </span>
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 head_margin_top">
                                            Arabic Last Name :
                                             <span v-if="!edit.ar_last_name" id="ar_last_name" class="">
                                                {{ employees.ar_last_name }}
                                             </span> 
                                            <i v-if="!edit.ar_last_name" @click="fn_edit('ar_last_name')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="ar_last_name"
                                                id="ar_last_name_btn"></i>
                                            <i v-if="edit.ar_last_name" @click="fn_edit('ar_last_name')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="ar_last_name"
                                                id="ar_last_name_save"></i>
                                            <span v-if="edit.ar_last_name" id="ar_last_name_input" class="">
                                                <input type="text" v-model="employees.ar_last_name" class="update_input" value="arabic last name"
                                                    id="ar_last_name_update">
                                            </span>
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Nationality :
                                                 <span v-if="!edit.nationality" id="nationality" class="">
                                                    {{ employees.nationality }}
                                                 </span> 
                                                <i v-if="!edit.nationality" @click="fn_edit('nationality')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="nationality"
                                                    id="nationality_btn"></i>
                                                <i v-if="edit.nationality" @click="fn_edit('nationality')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="nationality"
                                                    id="nationality_save"></i>
                                                <span v-if="edit.nationality" id="nationality_input" class="">
                                                    <!-- <b-select placeholder="Select nationality">
                                                        <option>
                                                            all nationalities
                                                        </option>
                                                    </b-select> -->
                                                    <input type="text" v-model="employees.national_id" class="update_input" value="national_id"
                                                    id="national_id">
                                                    
                                                </span>
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 head_margin_top">
                                            Religion :
                                             <span v-if="!edit.religion" id="religion" class="">
                                                {{ employees.religion}}
                                             </span> 
                                            <i v-if="!edit.religion" @click="fn_edit('religion')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="religion"
                                                id="religion_btn"></i>
                                            <i v-if="edit.religion" @click="fn_edit('religion')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="religion"
                                                id="religion_save"></i>
                                            <span v-if="edit.religion" id="religion_input" class="">
                                                <b-select v-model="employees.religion" placeholder="Select religion">
                                                    <option value="muslim">muslim</option>
                                                    <option value="christian">christian</option>
                                                    <option value="jewish">jewish</option>
                                                    <option value="other">other</option>
                                                </b-select>
                                            </span>
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Country :
                                                 <span v-if="!edit.country" id="country_id" class="">
                                                    {{ employeeData.countryName }}
                                                 </span> 
                                                <i v-if="!edit.country" @click="fn_edit('country')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="country_id"
                                                    id="country_id_btn"></i>
                                                <i v-if="edit.country" @click="fn_edit('country')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="country_id"
                                                    id="country_id_save"></i>
                                                <span v-if="edit.country" id="country_id_input" class="">
                                                    <b-select v-model="employeeData.countryName" placeholder="Select country">
                                                        <option v-for="country in countries" :key="country.id" :value="country.id"> {{ country.name }} </option>
                                                    </b-select>
                                                    <!-- <input type="text" v-model="employeeData.countryName" class="update_input" value="countryName"
                                                    id="country_id"> -->
                                                </span>
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>
 
                                        <div class="column is-5 head_margin_top">
                                            City :
                                             <span v-if="!edit.city" id="city_id" class="">
                                                {{ employeeData.cityName }}
                                             </span> 
                                            <i v-if="!edit.city" @click="fn_edit('city')"
                                               class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="city_id"
                                                id="city_id_btn"></i>
                                            <i v-if="edit.city" @click="fn_edit('city')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="city_id"
                                                id="city_id_save"></i>
                                            <span v-if="edit.city" id="city_id_input" class="hidden">
                                                <b-select v-model="employeeData.cityName" placeholder="Select city">
                                                    <option v-for="city in citeis" :key="city.id" :value="city.id">{{ city.name }}</option>
                                                </b-select>
                                            </span>
                                        </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Birth Date:
                                                 <span v-if="!edit.birth_date" id="birth_date" class="">
                                                    {{ employees.birth_date }}
                                                 </span>
                                                <i v-if="!edit.birth_date" @click="fn_edit('birth_date')" 
                                                   class="fa fa-edit pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="birth_date"
                                                    id="birth_date_btn"></i>
                                                <i v-if="edit.birth_date" @click="fn_edit('birth_date')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="birth_date"
                                                    id="birth_date_save"></i>
                                                <span v-if="edit.birth_date" id="birth_date_input" class="hidden">
                                                    <input type="text" class="update_input datepicker1" value="date"
                                                        id="birth_date_update" v-model="employees.birth_date">
                                                </span>
                                            </div>
                                        </div> 

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Job Title:
                                                 <span v-if="!edit.jobtitle" id="jobtitle" class="">
                                                    {{ employeeData.jobtitle }}
                                                 </span> 
                                                <i v-if="!edit.jobtitle" @click="fn_edit('jobtitle')"
                                                    class="fa fa-edit pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="jobtitle"
                                                    id="birth_date_btn"></i>
                                                <i v-if="edit.jobtitle" @click="fn_edit('jobtitle')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="jobtitle"
                                                    id="birth_date_save"></i>
                                                <span v-if="edit.jobtitle" id="jobtitle" class="hidden">
                                                  <b-select expanded v-model="employeeData.jobtitle">
                                                        <option v-for="jobTitle in jobTitles" :value="jobTitle.id" >
                                                                {{ jobTitle.en_name }} 
                                                        </option>
                                                  </b-select>
                                                </span>
                                            </div>
                                        </div> 

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Company :
                                                 <span v-if="!edit.company" id="company" class="">
                                                    {{ employees.company }}
                                                 </span> 
                                                <i v-if="!edit.company" @click="fn_edit('company')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="company"
                                                    id="company_btn"></i>
                                                <i v-if="edit.company" @click="fn_edit('company')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="company"
                                                    id="company_save"></i>
                                                <span v-if="edit.company" id="company_input" class="">
                                                    <input type="text" class="update_input" value="company"
                                                        id="company_update" v-model="employees.company">
                                                </span>
                                            </div>
                                        </div> 

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 head_margin_top">
                                            School :
                                             <span v-if="!edit.school" id="school" class="">
                                                {{ employees.school }}
                                             </span> 
                                            <i v-if="!edit.school" @click="fn_edit('school')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="school"
                                                id="school_btn"></i>
                                            <i v-if="edit.school" @click="fn_edit('school')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="school"
                                                id="school_save"></i>
                                            <span v-if="edit.school" id="school_input" class="hidden">
                                                <input type="text" class="update_input" value="school"
                                                    id="school_update" v-model="employees.school">
                                            </span>
                                        </div> 

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Club :
                                                 <span v-if="!edit.club" id="club" class="">
                                                    {{ employees.club }}
                                                 </span> 
                                                <i v-if="!edit.club" @click="fn_edit('club')"
                                                   class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="club"
                                                    id="club_btn"></i>
                                                <i v-if="edit.club" @click="fn_edit('club')"
                                                    class="fa fa-check pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="club"
                                                    id="club_save"></i>
                                                <span v-if="edit.club" id="club_input" class="">
                                                    <input type="text" class="update_input" value="Club name"
                                                        id="club_update" v-model="employees.club">
                                                </span>
                                            </div>
                                        </div> 

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 border_right">
                                            <div class="head_margin_top">
                                                Address :
                                                 <span v-if="!edit.address" id="address" class="">
                                                    {{ employees.address }}
                                                 </span> 
                                                <i v-if="!edit.address" @click="fn_edit('address')"
                                                   class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="address"
                                                    id="club_btn"></i>
                                                <i v-if="edit.address" @click="fn_edit('address')"
                                                    class="fa fa-check pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="address"
                                                    id="club_save"></i>
                                                <span v-if="edit.address" id="address_input" class="">
                                                    <input type="text" class="update_input" value="address"
                                                        id="address_update" v-model="employees.address">
                                                </span>
                                            </div>
                                        </div> 

                                        <div class="column is-5  border_right">
                                            <div class="head_margin_top">
                                                Facebook :
                                                 <span v-if="!edit.facebook" id="facebook" class="">
                                                    <a href="#" target="_blank"><b><i
                                                                class="fab fa-facebook-f"></i></b></a>
                                                 </span> 
                                                <i v-if="!edit.facebook" @click="fn_edit('facebook')"
                                                   class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="facebook"
                                                    id="facebook_btn"></i>
                                                <i v-if="edit.facebook" @click="fn_edit('facebook')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="facebook"
                                                    id="facebook_save"></i>
                                                <span v-if="edit.facebook" id="facebook_input" class="hidden">
                                                    <input v-model="employees.facebook" type="text" class="update_input"
                                                        value="face account" id="facebook_update">
                                                </span>
                                            </div>
                                        </div>

                                         <div class="column is-1 border_right"> </div>

                                        <div class="column is-5 head_margin_top">
                                            Notes :
                                              <span v-if="!edit.notes" id="notes" class="">
                                                  {{ employees.notes }}
                                              </span>
                                                <i v-if="!edit.notes" @click="fn_edit('notes')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="notes"
                                                    id="notes_btn"></i>
                                                <i v-if="edit.notes" @click="fn_edit('notes')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="notes"
                                                    id="notes_save"></i>
                                                <span v-if="edit.notes" id="notes_input" class="hidden">
                                                    <input v-model="employees.notes" type="text" class="update_input"
                                                        value="notes" id="notes_update">
                                                </span>
                                        </div>
 

                                        
                                 </div>
                                    
                         </div>
                  
                    
                    </b-tab-item>

                    <b-tab-item label="Salary">
                        <div class="box-header with-border headerr">
                           <h1 style="font-weight:bold;">Salary</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">Salary</h3><hr>
                             <div class="search">
                                    <label>Search: </label>
                                    <input type="text" class="inputSearch">
                             </div>

                            <b-table
                            :data="DtailsSalary"
                            bordered
                            checkable
                            narrowed
                            hoverable

                            paginated
                            backend-pagination

                            :current-page="page"
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"

                            :default-sort-direction="defaultSortDirection"
                            >


                            <template slot-scope="props">
                            
                                <b-table-column class="width" field="id" label="" sortable>
                                    {{ props.row.id }}
                                </b-table-column>
                            
                                <b-table-column class="width" field="title" label="Paid Dt" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <!-- <b-table-column class="width" field="title" label="Employee" sortable>
                                    {{ props.row.title }}
                                </b-table-column> -->

                                <b-table-column class="width" field="title" label="Basic Salary">
                                    {{ props.row.salary }}
                                </b-table-column>

                                <b-table-column class="width" field="title" label="Gross Salary" sortable>
                                    {{ props.row.allowanes }}
                                </b-table-column>

                                <!-- <b-table-column class="width" field="title" label="Net Salary" sortable>
                                    {{ props.row.title }}
                                </b-table-column> -->

                                <b-table-column class="width" field="title" label="Details" sortable>
                                    {{ props.row.details }}
                                </b-table-column>

                                <b-table-column class="width" field="date" label="Date" sortable>
                                    {{ props.row.date }}
                                </b-table-column>

                            </template>


                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                            </template>

                        </b-table>
                        <b-button type="is-info" style="margin-bottom:2%;">Salary Slip</b-button>
                        <div class="field">
                            <b-checkbox :value="true"
                            type="is-info">
                                Select All
                            </b-checkbox>
                        </div>
                     </div>

                      <!-- Salary Update -->
                    

                     <!-- <div class="box-header with-border headerr">
                           <h1 style="font-weight:bold;">Salary Update</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">Salary</h3><hr>
                             <div class="search">
                                    <label>Search: </label>
                                    <input type="text" class="inputSearch">
                             </div>

                            <b-table
                            :data="actionLogs"
                            bordered
                            checkable
                            narrowed
                            hoverable

                            paginated
                            backend-pagination

                            :current-page="page"
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"

                            :checked-rows.sync="selectedLogs"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >


                            <template slot-scope="props">
                            
                                <b-table-column class="width" field="id" label="Full Salary" sortable>
                                    {{ props.row.id }}
                                </b-table-column>
                            
                                <b-table-column class="width" field="title" label="Allowances" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" field="title" label="Deductions" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" field="title" label="Details" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" field="title" label="Status" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" field="title" label="Ordered By" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" field="title" label="Ordered Time" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                            </template>


                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                            </template> -->



                    </b-tab-item>

                    <b-tab-item  label="Time">
                        <div class="box-header with-border headerr">
                           <h1 style="font-weight:bold;border-bottom: 3px solid #b07d12;">Vacation Request</h1><br>
                           <b-button type="is-success" style="margin-left:50%" @click="openModal">
                               Request Vacation
                           </b-button>

                           <b-modal :active.sync="isComponentModalActive" has-modal-card>
                            <div class="modal-card" style="width: auto">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Request Vacation</p>
                                </header>
                                <section class="modal-card-body">
                                <b-field label="Number Of Days">
                                   <b-input type="number" placeholder="Number Of Days"></b-input>
                                </b-field>

                                <b-field label="Reason">
                                   <b-input type="text" placeholder="Reason"></b-input>                                    
                                </b-field>

                                <b-field label="Start date">
                                   <b-input type="date"></b-input>
                                </b-field>

                                <b-field label="End Type">
                                   <b-input type="date"></b-input> 
                                </b-field>
                                
                                 <div class="block">
                                    <b-radio v-model="radio"
                                        name="name"
                                        native-value="Annaul Vacation">
                                        Annaul Vacation
                                    </b-radio>
                                    <b-radio v-model="radio"
                                        name="name"
                                        native-value="Unscheduled Vacation">
                                        Unscheduled Vacation
                                    </b-radio>
                                    <b-radio v-model="radio"
                                        name="name"
                                        native-value="Free">
                                        Free
                                    </b-radio>
                                </div>
                            </section>
                                <footer class="modal-card-foot">
                                    <button class="button" type="button" @click="isComponentModalActive = false">Close</button>
                                    <b-button class="is-danger">Remove</b-button>
                                </footer>
                            </div>
                        </b-modal>
                           
                        
                         <div class="search" style="margin-top:3%;">
                            <label>Search: </label>
                            <b-input type="text" style="display:inline-flex;"></b-input>
                         </div>

                         <b-button class="is-info">Upload Request</b-button>

                         <!-- table Request Vacation -->

                          <b-table
                            :data="actionLogs"
                            bordered
                            checkable
                            narrowed
                            hoverable

                            paginated
                            backend-pagination

                            :current-page="page"
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"

                            :checked-rows.sync="selectedLogs"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >


                            <template slot-scope="props">
                            
                                <b-table-column class="width" label="Reason" sortable>
                                    {{ props.row.id }}
                                </b-table-column>
                            
                                <b-table-column class="width" label="Number Of Days" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width"  label="Start Date" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="End Date" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="Approval" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="Vacation Payment" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                            </template>


                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                            </template>

                        </b-table>

                     </div>

                     <!-- Attendance -->

                    <div class="box-header with-border headerr">
                       <h1 style="font-weight:bold">Attendance</h1><br>
                       <h3 class="box-title" style="border-top: 3px solid #b07d12;">Attendance</h3><hr>
                    </div>

                    <div class="search" style="margin-top:3%;">
                        <label>Search: </label>
                        <b-input type="text" style="display:inline-flex;"></b-input>
                    </div>

                    <!-- table attendance -->

                     <b-table
                            :data="actionLogs"
                            bordered
                            checkable
                            narrowed
                            hoverable

                            paginated
                            backend-pagination

                            :current-page="page"
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"

                            :checked-rows.sync="selectedLogs"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >


                            <template slot-scope="props">
                            
                                <b-table-column class="width" label="Status" sortable>
                                    {{ props.row.id }}
                                </b-table-column>
                            
                                <b-table-column class="width" label="Working Hours" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="Check In" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="Check Out" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                            </template>


                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                            </template>

                        </b-table>

                    </b-tab-item>

                    <!-- End Time -->

                    <b-tab-item label="ER Contact">
                        <div class="box-header with-border headerr">
                            <h1 style="font-weight:bold">ER Contact</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">ER Contact</h3><hr>
                       </div>

                       <div class="search" style="margin-top:3%;">
                        <label>Search: </label>
                        <b-input type="text" style="display:inline-flex;"></b-input>
                    </div>

                    <!-- table ER Contact -->

                     <b-table
                            :data="actionLogs"
                            bordered
                            checkable
                            narrowed
                            hoverable

                            paginated
                            backend-pagination

                            :current-page="page"
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"

                            :checked-rows.sync="selectedLogs"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="created_at"
                            >


                            <template slot-scope="props">
                            
                                <b-table-column class="width" label="Name" sortable>
                                    {{ props.row.id }}
                                </b-table-column>
                            
                                <b-table-column class="width" label="Phone" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="Relation" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                                <b-table-column class="width" label="Mail" sortable>
                                    {{ props.row.title }}
                                </b-table-column>

                            </template>


                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                            </template>

                        </b-table>

                        <b-button type="is-success" style="margin-left:40%;" @click="openModal">Add Contact</b-button>
                    
                        <b-modal :active.sync="isComponentModalActive" has-modal-card>
                            <div class="modal-card" style="width: 160%">
                                <header class="modal-card-head">
                                    <p class="modal-card-title">Add Contact</p>
                                </header>
                                <section class="modal-card-body">
                                <b-field label="Name">
                                   <b-input type="text" v-model="contactName" placeholder="Name"></b-input>
                                </b-field>

                                <b-field label="Relation">
                                   <b-input type="text" v-modal="contactrelation" placeholder="Relation"></b-input>
                                </b-field>

                                 <div class="card">
                                    <header class="card-header cardHeader">
                                        <p class="card-header-title">Phone</p>
                                        <i
                                        class="fas fa-plus-circle"
                                        @click="Addphonefield"
                                        style="font-size: 1.75rem;
                                        right: 2%;
                                        position: absolute;
                                        top: 15px;
                                        color: #6eb165;
                                        cursor: pointer;"
                                        ></i>
                                    </header>

                                   <b-collapse class="card" v-for="(data, index) in phones" :key="index">
                                        <div slot="trigger" class="card-header">
                                            <p class="card-header-title">Other Phone {{ index+1 }}</p>
                                            <i
                                            class="fas fa-trash"
                                            @click="RemovePhone(index)"
                                            style="font-size: 22px; cursor: pointer; margin-right: 2%; margin-top: 1%"
                                            ></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="content">
                                                <div class="columns is-multiline is-mobile">
                                                    <div class="column is-12">
                                                    <b-field label="Number">
                                                        <b-input v-model="phones[index].phone" :disabled="disabled"></b-input>
                                                    </b-field>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-collapse>
                                 </div>

                               <div class="card">
                                    <header class="card-header cardHeader">
                                        <p class="card-header-title">Email</p>
                                        <i
                                        class="fas fa-plus-circle"
                                        @click="Addemailfield"
                                        style="font-size: 1.75rem;
                                        right: 2%;
                                        position: absolute;
                                        top: 15px;
                                        color: #6eb165;
                                        cursor: pointer;"
                                        ></i>
                                    </header>

                                   <b-collapse class="card" v-for="(data, index) in emails" :key="index">
                                        <div slot="trigger" class="card-header">
                                            <p class="card-header-title">Other Email {{ index+1 }}</p>
                                            <i
                                            class="fas fa-trash"
                                            @click="RemoveEmail(index)"
                                            style="font-size: 22px; cursor: pointer; margin-right: 2%; margin-top: 1%"
                                            ></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="content">
                                                <div class="columns is-multiline is-mobile">
                                                    <div class="column is-12">
                                                    <b-field label="Email">
                                                        <b-input v-model="emails[index].email" :disabled="disabled"></b-input>
                                                    </b-field>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-collapse>
                                 </div>

                                <b-field label="Job Title">
                                    <b-select  expanded>
                                        <!-- <option>CEO</option> -->
                                    </b-select>
                                </b-field>
                                
                                <b-field label="Nationality">
                                    <b-select  expanded>
                                        <!-- <option>CEO</option> -->
                                    </b-select>
                                </b-field>
                                
                            </section>
                                <footer class="modal-card-foot">
                                    <button class="button" type="button" @click="isComponentModalActive = false">Close</button>
                                    <b-button @click="StoreContact" class="is-success">Add</b-button>
                                </footer>
                            </div>
                        </b-modal>

                       <b-button class="is-info" style="display:-webkit-box;">Upload ER Contact</b-button>                        
                    </b-tab-item>

                    <b-tab-item label="Custody">
                        <div class="box-header with-border headerr">
                           <h1 style="font-weight:bold;">Custody</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">Custody</h3><hr>
                             <div class="search">
                                    <label>Search: </label>
                                    <input type="text" class="inputSearch">
                             </div>

                        <b-table
                        :data="callstatus"
                        :paginated="isPaginated"
                        :per-page="perPage"
                        :current-page.sync="currentPage"
                        :pagination-simple="isPaginationSimple"
                        :pagination-position="paginationPosition"
                        :default-sort-direction="defaultSortDirection"
                        default-sort="user.first_name"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">

                        <template slot-scope="props">
                            <b-table-column field="id" label="ID"  sortable numeric style="margin-right:20px;">
                                {{ props.row.id }}
                            </b-table-column>

                            <b-table-column class="padding" field="callstatus.name" label="Title" sortable>
                                {{ props.row.name }}
                            </b-table-column>

                            <b-table-column class="padding" field="callstatus.name" label="Received In" sortable>
                                {{ props.row.has_next_action }}
                            </b-table-column>

                            <b-table-column class="padding" field="callstatus.name" label="QR Code" sortable>
                                {{ props.row.has_next_action }}
                            </b-table-column>

                            <b-table-column class="padding" field="callstatus.name" label="Status" sortable>
                                {{ props.row.has_next_action }}
                            </b-table-column>

                            <b-table-column class="padding" field="callstatus.name" label="Delivered" sortable>
                                {{ props.row.has_next_action }}
                            </b-table-column>

                            <b-table-column class="padding" field="callstatus.name" label="Delivered In" sortable>
                                {{ props.row.has_next_action }}
                            </b-table-column>

                        </template>
                        <template slot="empty" v-if="!isLoading && isEmpty">
                                    <section class="section">
                                        <div class="content has-text-grey has-text-centered">
                                            <p>
                                                <b-icon
                                                icon="emoticon-sad"
                                                size="is-large">
                                            </b-icon>
                                        </p>
                                        <p>Nothing here.</p>
                                    </div>
                                </section>
                                <hr>
                            </template>
                      </b-table>
                    </div>
 
                       <h3 class="box-title" style="border-top: 3px solid #b07d12;">Upload Custody</h3><hr>
                       <div class="columns">
                           <div class="column is-6" style="margin-left:1%;">
                                <b><label>Title : </label></b>
                                <b-input type="text"></b-input>
                           </div>

                           <div class="column is-6">
                               <b><label>QR Code : </label></b>
                               <b-input type="text"></b-input>
                           </div>
                       </div>

                       <div class="columns">
                           <div class="column is-6" style="margin-left:1%;">
                              <b><label>Status: </label></b>
                            <b-field>
                                    <b-select placeholder="Choose Options" expanded>
                                        <option value="new">New</option>
                                        <option value="normal">Normal</option>
                                        <option value="old">Old</option>
                                    </b-select>
                            </b-field>
                           </div>

                             <div class="column is-6">
                                <b><label>From Date : </label></b>
                                <b-input type="date"></b-input>
                             </div>
                       </div>

                       <div class="columns">
                           <div class="column is-6">
                               <b-button type="is-info" style="margin-bottom:2%;">Upload Custody</b-button>
                           </div>
                       </div>
                
                    </b-tab-item>

                    <b-tab-item label="Master Data">

                        <div class="box-header with-border headerr">
                           <h1 style="font-weight:bold;">Master Data</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">Master Data</h3><hr>
                             <div class="search">
                                    <label>Search: </label>
                                    <input type="text" class="inputSearch">
                             </div>

                       <b-table
                            :data="meetingStatus"
                            :paginated="isPaginated"
                            :per-page="perPage"
                            :current-page.sync="currentPage"
                            :pagination-simple="isPaginationSimple"
                            :pagination-position="paginationPosition"
                            :default-sort-direction="defaultSortDirection"
                            default-sort="user.first_name"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page">

                            <template slot-scope="props">
                                <b-table-column style="float:left;" field="id" label="Image" width="40" sortable numeric>
                                    {{ props.row.id }}
                                </b-table-column>

                                <b-table-column class="padding" field="user.name" label="Type" sortable>
                                    {{ props.row.name }}
                                </b-table-column>

                            </template>
                            <template slot="empty" v-if="!isLoading && isEmpty">
                                        <section class="section">
                                            <div class="content has-text-grey has-text-centered">
                                                <p>
                                                    <b-icon
                                                    icon="emoticon-sad"
                                                    size="is-large">
                                                </b-icon>
                                            </p>
                                            <p>Nothing here.</p>
                                        </div>
                                    </section>
                                    <hr>
                                </template>
                         </b-table>

                         <h1 style="font-weight:bold;">Master Data</h1><br>
                    <h3 class="box-title" style="border-top: 3px solid #b07d12;">Master Data</h3><hr>

                       <div class="columns">
                           <div class="column is-6" style="margin-left:1%;">
                               <b><label>Image : </label></b>
                                <b-field class="file">
                                    <b-upload v-model="file">
                                        <a class="button is-primary">
                                            <b-icon icon="upload"></b-icon>
                                            <span>Click to upload</span>
                                        </a>
                                    </b-upload>
                                        <span class="file-name" v-if="file">
                                            {{ file.name }}
                                        </span>
                                </b-field>
                           </div>

                           <div class="column is-6">
                               <b><label>Type: </label></b>
                                <b-field>
                                        <b-select placeholder="Choose Options" expanded>
                                            <option value="id">ID</option>
                                            <option value="certification">Certification</option>
                                            <option value="military">Military</option>
                                            <option value="other">Other</option>
                                        </b-select>
                                </b-field>
                           </div>
                       </div>


                       <div class="columns">
                           <div class="column is-6">
                               <b-button type="is-info" style="margin-top:5%;">Upload Master Data</b-button>
                           </div>
                       </div>

                        </div>
                    </b-tab-item>

                    <b-tab-item label="KPI Rating">
                        <p style="font-size:35px;margin-bottom:2%;font-weight:bold">KPI Rating</p>
                          <div class="box-header with-border headerr">
                            <h1 style="font-weight:bold;">Rates</h1><br>
                            <h3 class="box-title" style="border-top: 3px solid #b07d12;">Rates</h3><hr>
                          </div>
                          <!-- el mafroud Alert -->
                          <div>There is no employeers to rate right now</div>
                    </b-tab-item>
                     
                    
                </b-tabs>
           </div>
       
     </section>
  
               
</template>

<script>

import Vue from 'vue'
import Slider from '@jeremyhamm/vue-slider'
import VueApexCharts from 'vue-apexcharts'
import ProgressBar from 'vue-simple-progress'
Vue.use(Slider)


import {showThisEmployee,deleteThisEmployee,filterEmployees,action_logs,callstatus,getMeetingStatus,updateEmployees
     ,getcities,getCountries,getVacancyInputs,EmployeeSalaryDetails,storeEmployeeContact} from './../../calls'
export default {
    data() {
            return {

                el: '#chart',
                series: [44, 55, 13, 43, 22],
                chartOptions: {
                labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]},
                file: null,
                contactName:null,
                contactrelation:null,
                name: null,
                has_next_action: null,
                isSwitched: false,
                isSwitchedCustom: 'Yes',
                activeTab: 0,
                showBooks: false,
                logsCurrentNumber: 0,
                logsTotalNumber: 0,
                actionLogs: [],
                selectedLogs: [],
                callstatus: [],
                meetingStatus: [],
                isEmpty: false,
                isPaginated: true,
                isPaginationSimple: false,
                defaultSortDirection: 'desc',
                total: 0,
                page: parseInt(this.$route.hash.split('/')[1]),
                perPage: 100,
                isLoading: true,
                isFullPage: true,

                selectedagent_type: [],
                token: window.auth_user.csrf,
                userType: window.auth_user.type,
               paginationPosition: 'bottom',
               currentPage: 1,
               isComponentModalActive: false,
               phones:[],
               radio:'',
               emails:[],
               citeis:[],
               countries:[],
               jobTitles:[],
               employees:{},
               employeeData:{},
                edit: {
                    en_first_name: false,
                    en_middle_name: false,
                    en_last_name: false,
                    ar_first_name: false,
                    ar_middle_name: false,
                    ar_last_name: false,
                    nationality: false,
                    religion: false,
                    country: false,
                    city: false,
                    jobtitle:false,
                    birth_date: false,
                    company: false,
                    school: false,
                    club: false,
                    address:false,
                    id_number: false,
                    facebook: false,
                    notes:false
                },
                employees:[],
                DtailsSalary:[],
                employee_id:null
            }
        },
        mounted() {
            this.getEmployeesData()
            // this.getData()
            // this.getData2()
            // this.getData3()
        },
        components: {
            'slider': Slider,
            apexchart: VueApexCharts,
            ProgressBar,
        },
        created() {
            // this.$router.replace({hash: '#/1'});
            this.id = this.$route.params.id;
            this.getSalarydetails()
            // this.Allcities();
            // this.Allcountries();
            // this.AllJobTitles()
         },
         methods:{
            getEmployeesData(){
                this.isLoading = true
                this.page = parseInt(this.$route.hash.split('/')[1]),
                showThisEmployee(this.id).then(response=>{
                console.log('thiiiiiis emp',response)
                this.perPage = response.data.per_page
                this.employees = response.data.employee
                this.employeeData = response.data.employeeData[0]
                this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
                this.logsTotalNumber = response.data.total
                this.total = response.data.total

                if(this.employees.length == 0){
                    this.isEmpty = true
                }
                // let currentTotal = response.data.total
                // if (response.data.total / this.perPage > 1000) {
                //     currentTotal = this.perPage * 1000
                // }

                // this.total = currentTotal
                this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })
        },
        getSalarydetails(){
            EmployeeSalaryDetails(this.id).then(response=>{
                this.DtailsSalary = response.data
            }).catch(error=>{
                console.log(error)
            })
        },
        Allcities(){
            getcities().then(response=>{
                this.citeis = response.data.data
                // console.log('cities response',this.citeis)
            }).catch(error => {
                console.log(error)
            })
        },
        Allcountries(){
            getCountries().then(response=>{
                this.countries = response.data.data
                // console.log('all countries',this.countries)
            }).catch(error => {
                console.log(error)
            })
        },
         AllJobTitles(){
            this.isLoading = true
            getVacancyInputs().then(response=>{
                console.log(response)
                this.jobTitles = response.data
            })
            .catch(error => {
                console.log(error)
            })
            this.isLoading = false
         },
        getData(){
        this.isLoading = true
            action_logs(this.page).then(response=>{
            console.log("TEST",response)
            // this.perPage = response.data.per_page
            this.actionLogs = response.data.data
            this.logsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            this.logsTotalNumber = response.data.total
            this.total = response.data.total
            
            // if(this.allAgent_type.length == 0){
            //     this.isEmpty = true
            // }
            // let currentTotal = response.data.total
            // if (response.data.total / this.perPage > 1000) {
            //     currentTotal = this.perPage * 1000
            // }

            // this.total = currentTotal
            this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })
     },
     StoreContact(){
         const bodyFormData = new FormData;
        for (const key in this.emails) {
         bodyFormData.append('emails[]',JSON.stringify(this.emails))
        }
        for (const key in this.phones) {
         bodyFormData.append('phones[]',JSON.stringify(this.phones))
        }
         bodyFormData.append('ContactName',this.contactName)
         bodyFormData.append('contactrelation',this.contactrelation)
        storeEmployeeContact(bodyFormData).then(response=>{

        }).catch(error=>{
            console.log(error)
        })
     },
     onPageChange(page) {
            // this.page = page
            // this.$router.replace({ name: "logs", params: {page: page} })
            // this.getData()
    },
    getData2(){
        this.isLoading = true
            callstatus(this.page).then(response=>{
            console.log("TEST",response)
            this.perPage = response.data.per_page
            this.callstatus = response.data.data
            this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            this.leadsTotalNumber = response.data.total
            this.total = response.data.total
            
            if(this.callstatus.length == 0){
                this.isEmpty = true
            }
            let currentTotal = response.data.total
            if (response.data.total / this.perPage > 1000) {
                currentTotal = this.perPage * 1000
            }

            this.total = currentTotal
            this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })
    },
    getData3(){
        this.isLoading = true
            getMeetingStatus(this.page).then(response=>{
            console.log("TEST",response)
            this.perPage = response.data.per_page
            this.meetingStatus = response.data
            this.leadsCurrentNumber = Math.min(response.data.total,this.page * this.perPage)
            this.leadsTotalNumber = response.data.total
            this.total = response.data.total
            
            if(this.agents.length == 0){
                this.isEmpty = true
            }
            let currentTotal = response.data.total
            if (response.data.total / this.perPage > 1000) {
                currentTotal = this.perPage * 1000
            }

            this.total = currentTotal
            this.isLoading = false
            })
        .catch(error => {
            console.log(error)
        })
            this.isLoading = false
    },
    openModal(){
        this.isComponentModalActive = true
    },
    fn_edit(value) {
        console.log('ddddddd',value);
        console.log(this.edit[value]);
        if (this.edit[value] == true) {
            const bodyFormData = new FormData();
            for (const key in this.employees) {
                const value = this.employees[key];
                bodyFormData.set(key, value);
            }
            for (const key in this.employeeData) {
                const value = this.employeeData[key];
                bodyFormData.set(key, value);
            }
            bodyFormData.append('employee_id',this.id)
            updateEmployees(bodyFormData).then(response=>{
                console.log('employee update success')
                this.$toast.open({
                    message: 'employee is updated now!',
                    position: 'is-bottom',
                    type: 'is-success'
                })
                this.isLoading = false
                // window.location.reload()
                getEmployeesData()
            }).catch(error => {
                console.log(error)
            })
        }
        this.edit[value] = !this.edit[value];
    },
    Addphonefield: function() {
        var id =
            Math.max.apply(
            Math,
            this.phones.map(function(o) {
                return o.id;
            })
            ) + 1;
        this.phones.push({ id, field: null, value: null });
    },
        RemovePhone(){
            alert('DELETE PHONE')
        },
        RemoveEmail(){
            alert('DElETE EMIAL')
        },
        Addemailfield: function() {
            var id =
                Math.max.apply(
                Math,
                this.emails.map(function(o) {
                    return o.id;
                })
                ) + 1;
            this.emails.push({ id, field: null, value: null });
       },
    },
}
</script>
            
<style>
.headerr{
    margin-bottom: 3%;
}
.container{
    background-color: #fff;
}
.columns:last-child{
    margin-bottom: 0%;
    margin-left: 0%;
}
.column.is-5, .column.is-5-tablet{
    margin-bottom: 2%;
}
.search{
      float: right;
  }
.inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
</style>
