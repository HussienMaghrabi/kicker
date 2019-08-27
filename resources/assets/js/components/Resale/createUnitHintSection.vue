<template>
    <div>
        <vue-good-wizard :steps="steps" :onNext="nextClicked" :onBack="backClicked">
            <div slot="page1">

                <div class="columns is-multiline is-mobile" style="padding-top: 1%;">
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Add Unit Type</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newUnitData.uniteAddType" required="" :class="{'input is-danger':  errors.uniteAddType}">
                                        <option value="resale">Resale Unit</option>
                                        <option value="rentel">Rentel Unit</option>
                                    </select>
                                    <p class="help is-danger" v-if="errors.uniteAddType">This field is required</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Privacy</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.privacy}" v-model="newUnitData.privacy">
                                        <option value="only_me">Only Me</option>
                                        <option value="team_only">Team Only</option>
                                        <option value="public">Public</option>
                                    </select>
                                    <p class="help is-danger" v-if="errors.privacy">This field is required</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-12">
                        <div class="field">
                            <b-field label="Key Holder Phone">
                                <b-input v-model="newUnitData.phone" class="input" required="" :class="['input', {'input is-danger': errors.phone}]"></b-input>
                            </b-field>
                        </div>
                        <!-- <p class="help is-danger" v-if="errors.phone">This field is required</p> -->
                    </div>
                   
                    <div class="column is-6">
                        <div class="field">
                            <b-field label="English Title">
                                <b-input v-model="newUnitData.en_title" :class="['input', {'is-danger':  errors.en_title}]"></b-input>
                            </b-field>
                            <p class="help is-danger" v-if="errors.en_title === true">This field is required</p>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <b-field label="Arabic Title">
                                <b-input v-model="newUnitData.ar_title" :class="['input']"></b-input>
                            </b-field>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">English Description</label>
                            <div class="control">
                                <textarea :class="['textarea', {'input is-danger':  errors.en_description}]" required=""
                                    placeholder="" v-model="newUnitData.en_description"></textarea>
                                <p class="help is-danger" v-if="errors.en_description === true">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Arabic Description</label>
                            <div class="control">
                                <textarea class="textarea" required="" placeholder="" v-model="newUnitData.ar_description"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="column is-6">
                        <div class="field">
                            <label class="label">English Notes</label>
                            <div class="control">
                                <textarea class="textarea" placeholder="" v-model="newUnitData.en_notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Arabic Notes</label>
                            <div class="control">
                                <textarea class="textarea" placeholder="" v-model="newUnitData.ar_notes"></textarea>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div slot="page2">
                <div class="columns is-multiline is-mobile">
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">Type</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.type}" v-model="newUnitData.type" @change="unitsTypes">
                                        <option value="commercial">Commercial</option>
                                        <option value="personal">Residential</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.type">This field is required</p>
                            </div>
                        </div>
                    </div>


                    <div class="column is-3">
                        <div class="field">
                            <label class="label">Unit Type</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.unit_type_id}" required="" v-model="newUnitData.unit_type_id">
                                        <option :value="type.id" v-for="type in unitTypes" :key="type.id">{{type.en_name}}</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.unit_type_id">This field is required</p>
                            </div>
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">Project</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newUnitData.project_id">
                                        <option :value="project.id" v-for="project in projects" v-if="project.type == newUnitData.type"
                                            :key="project.id">{{project.en_name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">View</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.view}" v-model="newUnitData.view">
                                        <option v-for="view in views" :key="view.id" :value="view.id">{{view.name}}</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.view">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-3" style="display: none">
                        <div class="field">
                            <b-field label="Area">
                                <b-input v-model="newUnitData.area" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-3">
                        <div class="field">
                            <b-field label="Rooms">
                                <b-input v-model="newUnitData.rooms" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-3">
                        <div class="field">
                            <b-field label="Bathrooms">
                                <b-input v-model="newUnitData.bathrooms" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-3">
                        <div class="field">
                            <b-field label="Floors">
                                <b-input v-model="newUnitData.floors" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>


                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Bua">
                                <b-input placeholder="Click to select..." position="is-bottom-left" :class="{'input is-danger':  errors.bua}"
                                    v-model="newUnitData.bua" class="input"></b-input>
                                <!-- <b-datepicker
                            placeholder="Click to select..."
                            :date-formatter="dateFormatter2"
                            position="is-bottom-left" v-model="newUnitData.bua">
                        </b-datepicker> -->
                            </b-field>
                        </div>
                        <p class="help is-danger" v-if="errors.bua">This field is required</p>
                    </div>

                    <div class="column is-3">
                        <div class="field">
                            <b-field label="Land Area">
                                <b-input v-model="newUnitData.area" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>



                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Delivery Date</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newUnitData.delivery_date" :class="{'input is-danger':  errors.delivery_date}"
                                        required="">
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2033">2033</option>
                                        <option value="2034">2034</option>
                                        <option value="2035">2035</option>
                                        <option value="2036">2036</option>
                                        <option value="2037">2037</option>
                                        <option value="2038">2038</option>
                                        <option value="2039">2039</option>
                                        <option value="2040">2040</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.delivery_date">This field is required</p>
                            </div>
                        </div>
                    </div>


                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Finishing</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.finishing}" v-model="newUnitData.finishing">
                                        <option value="finished">Finished</option>
                                        <option value="semi_finished">Semi Finished</option>
                                        <option value="not_finished">Not Finished</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.finishing">This field is required</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div slot="page3">
                <div class="columns is-multiline is-mobile">


                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Country</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.country}" v-model="newUnitData.country">
                                        <option value="64">Egypt</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.country">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <label class="label">City</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newUnitData.city">
                                        <option v-for="city in cities" :key="city.id" :value="city.id" v-if="city.country_id == newUnitData.country">{{city.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="column is-4">
                        <div class="field">
                            <label class="label">District</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.district}" v-model="newUnitData.district">
                                        <option v-for="district in districts" :key="district.id" :value="district.id"
                                            v-if="district.city_id == newUnitData.city">{{district.en_name}}</option>
                                        <option>mass</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.district">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Location</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="{'input is-danger':  errors.location}" v-model="newUnitData.location" @change="locationChange">
                                        <option v-for="location in locations" :key="location.id" :value="location">{{location.en_name}}</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.location">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-3">
                        <div class="field">
                            <b-field label="Unit Number">
                                <b-input v-model="newUnitData.loc_num" class="input" required="" :class="['input', {'input is-danger': errors.loc_num}]"></b-input>
                            </b-field>
                        </div>
                        <p class="help is-danger" v-if="errors.loc_num">This field is required</p>
                    </div>

                    <div class="column is-6">
                        <div class="field">
                            <b-field label="English Address">
                                <b-input v-model="newUnitData.en_address" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="field">
                            <b-field label="Arabic Address">
                                <b-input v-model="newUnitData.ar_address" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-12">
                        <!-- <googlemaps-map
                :center.sync="center"
                :zoom.sync="zoom"
                @click="onMapClick" style="width: 100%; height: 500px">
                <googlemaps-map
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :clickable="true"
                        :draggable="true"
                        @click="center=m.position"
                      />
                <gmap-marker
                        v-bind:key="index"
                        v-for="(m, index) in markers"
                        v-bind:position="m.position"
                        v-bind:clickable="true"
                        @click="center=m.position"
                      >
                </gmap-marker>

                </googlemaps-map> -->
                    </div>

                </div>
            </div>
            <div slot="page4">
                <div class="columns is-multiline is-mobile" style="padding-top: 30px;">

                    <div class="column is-6 text-center">
                        <label class="label">Upload main image</label>
                        <b-field>
                            <b-upload v-model="dropFiles1" @input="handleImage" multiple drag-drop accept="image/*" name="files">
                                <section class="section">
                                    <div class="content has-text-centered">
                                        <p>
                                            <b-icon icon="upload" size="is-large">
                                            </b-icon>
                                        </p>
                                        <p>Drop your files here or click to upload</p>
                                    </div>
                                </section>
                            </b-upload>
                        </b-field>

                        <div class="tags">
                            <span v-for="(file, index) in dropFiles1" :key="index" class="tag is-primary">
                                {{file.name}}
                                <button class="delete is-small" type="button" @click="deleteDropFile(index)">
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="column is-6 text-center">
                        <h5 class="label">Upload other images</h5>
                        <b-field>
                            <b-upload v-model="dropFiles2" @input="handleImage1" multiple drag-drop accept="image/*"
                                name="files">
                                <section class="section">
                                    <div class="content has-text-centered">
                                        <p>
                                            <b-icon icon="upload" size="is-large">
                                            </b-icon>
                                        </p>
                                        <p>Drop your files here or click to upload</p>
                                    </div>
                                </section>
                            </b-upload>
                        </b-field>

                        <div class="tags">
                            <span v-for="(file, index) in dropFiles2" :key="index" class="tag is-primary">
                                {{file.name}}
                                <button class="delete is-small" type="button" @click="deleteDropFile(index)">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>



            <div slot="page5" v-if="newUnitData.uniteAddType == 'resale'">
                <div class="columns is-multiline is-mobile">

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Original Price">
                                <b-input :class="['input', {'input is-danger':  errors.originalPrice}]" required=""
                                    v-model="newUnitData.originalPrice"></b-input>
                            </b-field>
                        </div>
                        <p class="help is-danger" v-if="errors.originalPrice">This field is required</p>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Paid">
                                <b-input :class="['input', {'input is-danger':  errors.paid}]" required=""
                                    v-model.number="newUnitData.paid" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Rest">
                                <b-input :class="['input', {'input is-danger':  errors.rest}]" required="" v-model="newUnitData.rest"
                                    class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Over">
                                <b-input :class="['input', {'input is-danger':  errors.total}]" required=""
                                    v-model.number="newUnitData.total" class="input"></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Selling Price">
                                <b-input :class="['input', {'input is-danger':  errors.price}]" required="" v-model="newUnitData.price "></b-input>
                            </b-field>
                        </div>
                        <p class="help is-danger" v-if="errors.price">This field is required</p>
                    </div>




                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Payment Method</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newUnitData.payment_method" :class="{'input is-danger':  errors.payment_method}"
                                        required="">
                                        <option value="cash">Cash</option>
                                        <option value="installment">Installment</option>
                                        <option value="cash_or_installment">Cash Or Installment</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.payment_method">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Due Now">
                                <b-input :class="['input', {'input is-danger':  errors.due_now}]" required=""
                                    placeholder="Click to select..." position="is-bottom-left" class="input" v-model="newUnitData.due_now  = newUnitData.paid + newUnitData.total"></b-input>
                                <!-- <b-datepicker
                            placeholder="Click to select..."
                            :date-formatter="dateFormatter2"
                            position="is-bottom-left" v-model="newUnitData.due_now">
                        </b-datepicker> -->
                            </b-field>
                        </div>
                    </div>



                </div>
            </div>
            <div slot="page5" v-if="newUnitData.uniteAddType == 'rentel'">
                <div class="columns is-multiline is-mobile">

                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Period Type</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select :class="['input', {'input is-danger':  errors.periodType}]" required=""
                                        v-model="newUnitData.periodType">
                                        <option value="long">long</option>
                                        <option value="short">short</option>
                                    </select>
                                </div>
                                <p class="help is-danger" v-if="errors.periodType">This field is required</p>
                            </div>
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="Value of insurance">
                                <b-input :class="['input', {'input is-danger':  errors.valueEnsure}]" required=""
                                    v-model="newUnitData.valueEnsure"></b-input>
                            </b-field>
                        </div>
                        <p class="help is-danger" v-if="errors.valueEnsure">This field is required</p>

                    </div>

                    <div class="column is-4">
                        <div class="field">
                            <b-field label="value of Rent">
                                <b-input :class="['input', {'input is-danger':  errors.valueOfRent}]" required=""
                                    v-model="newUnitData.valueOfRent"></b-input>
                            </b-field>
                        </div>
                        <p class="help is-danger" v-if="errors.valueOfRent">This field is required</p>
                    </div>



                </div>
            </div>
            <div slot="page6">
                <h4>Success</h4>
                <p>Congratulations you Have Just Saved A New Unit </p>
                <br>
                <router-link to="/admin/vue/resale_units" class="button is-success">Resale UNITS</router-link>
                <router-link to="/admin/vue/rental_units" class="button is-success">Rental UNITS</router-link>
            </div>
        </vue-good-wizard>
        <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
        <b-modal v-model="showAddLead" hide-footer hide-header>
            <!-- id="modal1" ref="myModalRef" :active.sync="showAddLead" has-modal-card -->
            <div class="modal-card" style="width: auto">

                <header class="modal-card-head">
                    <p class="modal-card-title">Add Lead</p>
                </header>
                <section class="modal-card-body">
                    <div class="columns is-multiline is-mobile">
                        <div class="column is-6">
                            <b-field label="First Name">
                                <b-input v-model="newLeadData.leadFirstName"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="Last Name">
                                <b-input v-model="newLeadData.leadLastName"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <b-field label="phone">
                                <b-input v-model="newLeadData.phone"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6">
                            <label class="label">Lead source</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newLeadData.sourceId">
                                        <option v-for="source in leadSources" :key="source.id" :value="source.id">{{source.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="column is-6">
                            <b-field label="Reference">
                                <b-input v-model="newLeadData.reference"></b-input>
                            </b-field>
                        </div>
                        <div class="column is-6" v-if="auth_user.type !== 'agent'">
                            <label class="label">Residencial Agent</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newLeadData.r_agent">
                                        <option v-for="agent in residentialAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="column is-6" v-if="auth_user.type !== 'agent'">
                            <label class="label">Commercial Agent</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="newLeadData.c_agent">
                                        <option v-for="agent in commercialAgents" :key="agent.id" :value="agent.id">{{agent.name}}</option><!-- v-if="window.auth_user.type == 'admin'" -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot" style="justify-content: flex-end;">
                    <button class="button is-primary" @click="addLead">Add Lead</button>
                </footer>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { GoodWizard } from 'vue-good-wizard';

    import {
        getUnitTypes,
        getPublicData,
        storeUnitResale,
        getAllLeads,
        getAgents,
        getLeadSources,
        leadShortAdding,
        getDistruct,
        getAllLeadsAutocompleteList,
    } from './../../calls'
    export default {
        name: 'demo',
        props: ['hintLeadData'],
        data() {
            return {
                auth_user: window.auth_user,
                isLoading: false,
                loading: false,
                check: 0,
                errors: {
                    titleAr: false,
                    titleEn: false,
                    phone: false,
                    lead_id: false,
                    uniteAddType: false,
                    en_description: false,
                    ar_description: false,
                    unit_type_id: false,
                    bua: false,
                    delivery_date: false,
                    finishing: false,
                    district: false,
                    originalPrice: false,
                    Price: false,
                    price: false,
                    payment_method: false,
                    originalPrice: false,
                    paid: false,
                    rest: false,
                    total: false,
                    due_now: false,
                    periodType: false,
                    valueEnsure: false,
                    valueOfRent: false,
                    loc_num: false,
                },
                steps: [{
                        label: 'Description & Privacy',
                        slot: 'page1',
                    },
                    {
                        label: 'Unit Information',
                        slot: 'page2',
                    },
                    {
                        label: 'Location',
                        slot: 'page3',
                    },
                    {
                        label: 'Images',
                        slot: 'page4',
                        //options:{nextDisabled: true,}
                    },
                    {
                        label: 'Payments',
                        slot: 'page5',
                    },
                    {
                        label: 'save',
                        slot: 'page6',
                        options: {
                            nextDisabled: true, // control whether next is disabled or not
                        },
                    }

                ],
                dropzoneOptions: {
                    url: 'https://httpbin.org/post',
                    thumbnailWidth: 100,
                    maxFilesize: 3.0,
                    headers: {
                        "My-Awesome-Header": "header value"
                    },
                    dictDefaultMessage: "<i class='fa fa-cloud-upload mr-1'></i> Upload Other Images",
                    addRemoveLinks: true,
                },
                center: {
                    lat: 30.0595581,
                    lng: 31.2233591
                },
                zoom: 13,
                markers: {
                    position: {
                        lat: 30.0595581,
                        lng: 31.2233591
                    }
                },
                newUnitData: {},
                privacyArray: ['Only Me', 'Team Only', 'Public'],
                views: [{
                        id: "main_street",
                        name: "Main Street"
                    },
                    {
                        id: "bystreet",
                        name: "By Street"
                    },
                    {
                        id: "garden",
                        name: "Garden"
                    },
                    {
                        id: "corner",
                        name: "Corner"
                    },
                    {
                        id: "sea_or_river",
                        name: "Sea Or River"
                    }
                ],
                leads: [],
                lead_id:null,
                locations: [],
                districts: [],
                cities: [],
                projects: [],
                unitTypes: [],
                allAgents: [],
                leadSources: [],
                openOnFocus: true,
                name: '',
                uniteAddType: 'resale',
                showAddLead: false,
                newLeadData: {},
                commercialAgents: [],
                residentialAgents: [],
                dropFiles1: [],
                dropFiles2: [],
                mainPhoto: '',
                other_images: [],
            }
        },
        components: {
            'vue-good-wizard': GoodWizard,
        },
        created() {

            this.getPublic()
            this.getCompanyAgents()
            // this.getLeads()
            this.getSources()
        },
        mounted() {
            // console.log(this.$refs)
        },
        computed: {
            filteredDataArray() {
                // console.clear()
                // console.log('sssssssssssssssssssssssssssssssssssssss')
                let soso;
                soso = this.leads.filter((option) => {
                    // console.log(this.newUnitData.lead_id)
                    let str = ""
                    // console.log('sssssssssssssssssssssssssssssssssssssss')
                    // console.log(this.newUnitData.lead_id)
                    if (this.newUnitData.lead_id != undefined) {
                        str = this.newUnitData.lead_id
                    }
                    return option.value.toString().toLowerCase().indexOf(str.toLowerCase()) >= 0 // .toLowerCase()
                })
                // console.log(soso)
                return soso;
            }
        },
        methods: {
            getLeadsAutocomplete(usrInput) {
                getAllLeadsAutocompleteList(usrInput)
                .then((response) => {
                    this.leads = response.data.map((lead) => {
                        return {
                            value: `${lead.first_name} ${lead.last_name} / ${lead.phone}`,
                            key: lead.id,
                        };
                    });
                })
                .catch((e) => {
                    console.error(e);
                })
            },
            locationChange() {
                // this.newUnitData.location.lat = this.newUnitData.location.lat
                this.zoom = parseInt(this.newUnitData.location.zoom);
                this.center.lng = parseInt(this.newUnitData.location.lng);
                this.center.lat = parseInt(this.newUnitData.location.lat);
                // this.markers = [{position:{lng: parseInt(this.newUnitData.location.lng), lat: parseInt(this.newUnitData.location.lat)}};
                // this.newUnitData.location = this.newUnitData.location.en_name;
            },
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1)
            },
            saveUnit() {
                console.clear()
                if (this.newUnitData.uniteAddType == 'resale') {
                    if (this.newUnitData.price && this.newUnitData.payment_method && this.newUnitData.originalPrice &&
                        this.newUnitData.paid && this.newUnitData.rest && this.newUnitData.total && this.newUnitData.due_now
                    ) {
                        this.errors.price = false;
                        this.errors.payment_method = false;
                        this.errors.originalPrice = false;
                        this.errors.paid = false;
                        this.errors.rest = false;
                        this.errors.total = false;
                        this.errors.due_now = false;
                        this.newUnitData.lat = this.center.lat;
                        this.newUnitData.lng = this.center.lng;
                        this.newUnitData.zoom = this.zoom;
                        this.newUnitData.locationId = this.newUnitData.location.id;
                        // this.newUnitData.landArea = this.landArea
                        // this.newUnitData.bua = this.bua
                        this.newUnitData.image = this.mainPhoto;
                        // this.newUnitData.other_images = this.other_images;
                        this.newUnitData.other_images = this.other_images;
                        let leadName = this.newUnitData.lead_id
                        let leadId
                        this.leads.forEach(function (element) {
                            // console.log(element);
                            if (element.value == leadName)
                                leadId = element.key
                        });
                        this.newUnitData.lead_id = leadId
                        // console.log('lead_id',this.newUnitData.lead_id);
                        storeUnitResale(this.newUnitData).then(response => {
                                // console.log(response)
                                // console.log(response.status);
                                // return true;
                            })
                            .catch(error => {
                                console.log(error)
                            })
                        // this.newUnitData.lead_id = leadName
                        return true;
                    }
                    if (!this.newUnitData.price)
                        this.errors.price = true;
                    if (!this.newUnitData.payment_method)
                        this.errors.payment_method = true;
                    if (!this.newUnitData.originalPrice)
                        this.errors.originalPrice = true;
                    if (!this.newUnitData.paid)
                        this.errors.paid = true;
                    if (!this.newUnitData.rest)
                        this.errors.rest = true;
                    if (!this.newUnitData.total)
                        this.errors.total = true;
                    if (!this.newUnitData.due_now)
                        this.errors.due_now = true;
                    return false;
                } else if (this.newUnitData.uniteAddType == 'rentel') {
                    if (this.newUnitData.periodType && this.newUnitData.valueEnsure && this.newUnitData.valueOfRent) {
                        this.errors.periodType = false;
                        this.errors.valueEnsure = false;
                        this.errors.valueOfRent = false;
                        this.newUnitData.lat = this.center.lat;
                        this.newUnitData.lng = this.center.lng;
                        this.newUnitData.zoom = this.zoom;
                        // this.newUnitData.landArea = this.landArea
                        // this.newUnitData.bua = this.bua
                        this.newUnitData.image = this.mainPhoto;
                        // this.newUnitData.other_images = this.other_images;
                        this.newUnitData.other_images = this.other_images;
                        this.newUnitData.locationId = this.newUnitData.location.id;
                        storeUnitResale(this.newUnitData).then(response => {
                                // console.log(response)
                                // return true;
                            })
                            .catch(error => {
                                console.log(error)
                            })
                    }
                    if (!this.newUnitData.periodType)
                        this.errors.periodType = true;
                    if (!this.newUnitData.valueEnsure)
                        this.errors.valueEnsure = true;
                    if (!this.newUnitData.valueOfRent)
                        this.errors.valueOfRent = true;
                    // return false;
                }
                /*if (this.newUnitData.periodType && this.newUnitData.valueEnsure && this.newUnitData.valueOfRent) {
                    // if(this.newUnitData.uniteAddType === 'resale'){
                        // this.newUnitData.landArea = this.landArea
                        // this.newUnitData.bua = this.bua
                        this.newUnitData.image = this.mainPhoto;
                        // this.newUnitData.other_images = this.other_images;
                        this.newUnitData.other_images = this.other_images;

                    // }
                    // else if(this.newUnitData.uniteAddType === 'rentel'){

                    //      //this.newUnitData.bua = this.bua
                    //     // this.newUnitData.due_now = this.due_now
                    //     storeUnitResale(this.newUnitData).then(response=>{
                    //         console.log(response)
                    //     })
                    //     .catch(error => {
                    //         console.log(error)
                    //     })
                    // }
                }*/
            },
            addLead() {
                leadShortAdding(this.newLeadData).then(response => {
                    // console.log(response)
                    this.lead_id=response.data.id;
                    this.leads.push({
                        value: response.data.first_name + ' ' + response.data.last_name,
                        key: "" + response.data.id
                    })
                    // console.log(this.leads);
                    this.newUnitData.lead_id = response.data.first_name + ' ' + response.data.last_name
                    this.showAddLead = false
                }).catch(error => {
                    console.log(error)
                })
            },
            unitsTypes(event) {
                var usage = event.target.value
                getUnitTypes({
                        usage: usage,
                        _token: this.token
                    }).then(response => {
                        // console.log(response)
                        this.unitTypes = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            getSources() {
                getLeadSources().then(response => {
                        this.leadSources = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            getPublic() {
                getPublicData().then(response => {
                        this.locations = response.data.locations
                        this.projects = response.data.projects
                        // console.log("response.data.projectssssss")
                        // console.log(response.data.projects)
                        this.districts = response.data.districts
                        this.cities = response.data.cities
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            getCompanyAgents() {
                getAgents().then(response => {
                        this.commercialAgents = response.data.commercialAgents
                        this.residentialAgents = response.data.residentialAgents
                        this.commercialAgents.forEach(element => {
                            this.allAgents.push(element)
                        });
                        this.residentialAgents.forEach(element => {
                            this.allAgents.push(element)
                        });
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            getLeads() {
                this.loading = true
                getAllLeads().then(response => {
                        // console.log('All leadsssssssssssss')
                        // console.log(response.data)
                        let array = [];
                        Object.keys(response.data).forEach(function (key, index) {
                            array.push({
                                value: response.data[key],
                                key
                            })
                        })
                        // console.log(array)
                        this.leads = array
                    })
                    .catch(error => {
                        console.log(error)
                    })
                this.loading = false
            },
            onMapClick() {},
            handleImage(event) {
                const files = event
                if (!/\.(gif|jpg|jpeg|png|webp)$/i.test(files[0].name)) {
                    alert('Your choice is not a picture')
                    return prevent()
                }
                var reader = new FileReader
                reader.addEventListener('load', () => {
                    this.mainPhoto = reader.result
                    // console.log(reader.result);
                })
                reader.readAsDataURL(files[0])
                // console.log(reader.result);
            },
            handleImage1(event) {
                const files = event
                files.forEach(img => {
                    if (!/\.(gif|jpg|jpeg|png|webp)$/i.test(img.name)) {
                        alert('Your choice is not a picture')
                        return prevent()
                    }
                    var reader = new FileReader
                    reader.addEventListener('load', () => {
                        this.other_images.push(reader.result)
                        // console.log(reader.result);
                    })
                    reader.readAsDataURL(img)
                });

            },
            dateFormatter2(dt) {
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.bua = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            nextClicked(currentPage) {
                // console.log(currentPage)
                // console.log(this.hintLeadData)
                if (currentPage == 0) {
                    if (
                        // this.newUnitData.lead_id &&
                        this.newUnitData.uniteAddType &&
                        this.newUnitData.en_description &&
                        this.newUnitData.en_title && 
                        this.newUnitData.privacy
                    ) {
                        // console.log(this.newUnitData.lead_id)
                        // this.errors.phone = false;
                        this.errors.uniteAddType = false;
                        this.errors.en_description = false;
                        this.errors.privacy = false;
                        this.errors.en_title = false;
                        this.errors.lead_id = false;
                        return true; //return false if you want to prevent moving to next page
                    }
                    // if (!this.newUnitData.phone)
                    //     this.errors.phone = true;
                    if (!this.newUnitData.uniteAddType){
                        this.errors.uniteAddType = true;
                    }else{
                        this.errors.uniteAddType = false;
                    }           
                    if (!this.newUnitData.en_description){
                        this.errors.en_description = true;
                    }else{
                        this.errors.en_description = false;
                    }
                    if (!this.newUnitData.en_title){
                        this.errors.en_title = true;
                    }else{
                        this.errors.en_title = false;
                    }
                    if (!this.newUnitData.privacy){
                        this.errors.privacy = true;
                    }   
                    // if (!this.newUnitData.lead_id)
                    //     this.errors.lead_id = true;
                    return false;
                } else if (currentPage == 1) {
                    if (this.newUnitData.bua &&
                        this.newUnitData.unit_type_id &&
                        this.newUnitData.delivery_date && this.newUnitData.finishing && this.newUnitData.view && this.newUnitData.type) {
                        this.errors.bua = false;
                        this.errors.unit_type_id = false;
                        this.errors.delivery_date = false;
                        this.errors.finishing = false;
                        this.errors.view = false;
                        this.errors.type = false;
                        return true; //return false if you want to prevent moving to next page
                    }
                    if (!this.newUnitData.bua)
                        this.errors.bua = true;
                    if (!this.newUnitData.unit_type_id)
                        this.errors.unit_type_id = true;
                    if (!this.newUnitData.delivery_date)
                        this.errors.delivery_date = true;
                    if (!this.newUnitData.finishing)
                        this.errors.finishing = true;
                    if (!this.newUnitData.view)
                        this.errors.view = true;
                    if (!this.newUnitData.type)
                        this.errors.type = true;
                    return false;
                } else if (currentPage == 2) {
                    if (this.newUnitData.district && this.newUnitData.location && this.newUnitData.country) {
                        this.errors.district = false;
                        this.errors.location = false;
                        this.errors.country = false;

                        return true; //return false if you want to prevent moving to next page
                    }
                    if (!this.newUnitData.district)
                        this.errors.district = true;
                    if (!this.newUnitData.location)
                        this.errors.location = true;
                    if (!this.newUnitData.country)
                        this.errors.country = true;
                    return false;
                } else if (currentPage == 3) {
                    // console.log('unit data', this.newUnitData);

                    return true;
                } else if (currentPage == 4) {
                    if (this.newUnitData.uniteAddType == 'resale') {
                        if (this.newUnitData.price && this.newUnitData.payment_method && this.newUnitData.originalPrice &&
                            this.newUnitData.paid && this.newUnitData.rest && this.newUnitData.total && this.newUnitData
                            .due_now) {
                            this.errors.price = false;
                            this.errors.payment_method = false;
                            this.errors.originalPrice = false;
                            this.errors.paid = false;
                            this.errors.rest = false;
                            this.errors.total = false;
                            this.errors.due_now = false;
                            this.newUnitData.lat = this.center.lat;
                            this.newUnitData.lng = this.center.lng;
                            this.newUnitData.zoom = this.zoom;
                            this.newUnitData.locationId = this.newUnitData.location.id;
                            // this.newUnitData.landArea = this.landArea
                            // this.newUnitData.bua = this.bua
                            this.newUnitData.image = this.mainPhoto;
                            // this.newUnitData.other_images = this.other_images;
                            this.newUnitData.other_images = this.other_images;
                            let leadName = this.newUnitData.lead_id
                            let leadId
                            this.leads.forEach(function (element) {
                                // console.log(element);
                                if (element.value == leadName)
                                    leadId = element.key
                            });
                            this.newUnitData.lead_id = this.hintLeadData.id
                            // var check = 0
                            // console.log('test_id',this.newUnitData)
                            // console.log('leads',this.leads)
                            // this.newUnitData.lead_id=this.leads[0].key;
                            var store = () => {
                                this.isLoading = true
                                return storeUnitResale(this.newUnitData).then(response => {
                                        if (response && response.data.agent_id) {
                                            this.isLoading = false
                                            // console.log('res', response);
                                            this.check = 1
                                            return 2;
                                        }

                                    })
                                    .catch(error => {
                                        console.log(error)
                                    })
                            }
                            // this.newUnitData.lead_id = leadName
                            // console.log( 'check' )
                            // console.log( res )
                            // console.log( check )
                            // var soso = await res;
                            return store().then((returnVal) => {
                                console.log(' true ');
                                return true;
                            })
                            /*
                            console.log(this.check)
                            if (  == 1 )
                                return true;
                            */
                        }
                        if (!this.newUnitData.price)
                            this.errors.price = true;
                        if (!this.newUnitData.payment_method)
                            this.errors.payment_method = true;
                        if (!this.newUnitData.originalPrice)
                            this.errors.originalPrice = true;
                        if (!this.newUnitData.paid)
                            this.errors.paid = true;
                        if (!this.newUnitData.rest)
                            this.errors.rest = true;
                        if (!this.newUnitData.total)
                            this.errors.total = true;
                        if (!this.newUnitData.due_now)
                            this.errors.due_now = true;
                        return false;
                    } else if (this.newUnitData.uniteAddType == 'rentel') {
                        if (this.newUnitData.periodType && this.newUnitData.valueEnsure && this.newUnitData.valueOfRent) {
                            this.errors.periodType = false;
                            this.errors.valueEnsure = false;
                            this.errors.valueOfRent = false;
                            this.newUnitData.lat = this.center.lat;
                            this.newUnitData.lng = this.center.lng;
                            this.newUnitData.zoom = this.zoom;
                            // this.newUnitData.landArea = this.landArea
                            // this.newUnitData.bua = this.bua
                            this.newUnitData.image = this.mainPhoto;
                            // this.newUnitData.other_images = this.other_images;
                            this.newUnitData.other_images = this.other_images;
                            this.newUnitData.locationId = this.newUnitData.location.id;
                            this.isLoading = true
                            storeUnitResale(this.newUnitData).then(response => {
                                    // console.log(response)
                                    this.isLoading = false
                                })
                                .catch(error => {
                                    console.log(error)
                                })
                            return true;
                        }
                        if (!this.newUnitData.periodType)
                            this.errors.periodType = true;
                        if (!this.newUnitData.valueEnsure)
                            this.errors.valueEnsure = true;
                        if (!this.newUnitData.valueOfRent)
                            this.errors.valueOfRent = true;
                        return false;
                    }
                } else if (currentPage == 5) {
                    // this.saveUnit();
                    //return false;
                }

            },
            backClicked(currentPage) {
                console.log('back clicked', currentPage);
                return true; //return false if you want to prevent moving to previous page
            }
        },
    };
</script> 