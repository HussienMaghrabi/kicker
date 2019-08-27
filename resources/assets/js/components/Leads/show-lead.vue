<template>
    <div style="background-color: #ffffff">
        <Header style="padding-bottom: 22px" />
        <div class="box">
            <div class="columns is-multiline" style="margin: 0">
                <div class="box-body column is-12">
                    <div class="columns is-multiline" style="margin: 0">
                        <div class="column is-1" style="margin-right: 100px;">
                            <div class="columns is-multiline" style="margin: 0;">
                                
                                <!-- v-if has image -->
                                <div class="column is-12">
                                    <img src="" class="img-circle lead_image" alt="" width="130px" height="130px">
                                </div>
                                <!-- end if  -->
                                <!-- else -->
                                <div class="column is-12"
                                    style="border-radius: 50px; border:3px solid #666;height: 80px;">
                                    <h3 style="text-align: center; font-size: 24px; position: relative; top: 25%;"><span> {{ getleads.lead.first_name[0] }} </span>.{{ getleads.lead.last_name[0] }}.
                                    </h3>
                                </div>
                                <!-- end else -->
                            </div>
                        </div>
                        <div class="column is-4">
                            <div class="columns is-multiline" style="margin: 0; position: relative;
                        top: 22%;">
                                <div class="column is-12 user-info">
                                    <i class="far fa-user"></i>
                                    <span>{{ getleads.lead.first_name }}</span>
                                </div>
                                <div class="column is-12 user-email">
                                    @ <a href="mailto:#">{{ getleads.lead.email }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="column is-2">
                            <div class="columns is-multiline" style="margin: 0; position: relative;
                        top: 22%;">
                                <div class="column is-12 user-phone">
                                    <span> Phone:{{ getleads.lead.phone }}</span>
                                </div>
                                <div class="column is-12 user-created">
                                    <span> Created:{{ getleads.lead.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="column is-2">
                            <div class="columns is-multiline" style="margin: 0; position: relative;
                            top: 22%;">
                                <div class="column is-12 user-phone">
                                    <span> Address:{{ getleads.lead.address }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="column is-2">
                            <div class="columns is-multiline" style="margin: 0; position: relative;
                                top: 22%;">
                                <!-- if agent -->
                                <div class="column is-12">
                                    <a href="#">
                                        <!-- @if ($agent->image =='') -->
                                        <img :src="'/uploads/lead.png'" class="img-circle lead_image" alt="image"
                                            width="70px" height="70px" style="z-index: 4;position: relative;">
                                        <!-- @else -->
                                        <!-- <img src="{{ url('uploads/'.$agent->image) }}" class="img-circle lead_image"
                                        alt="{{ __('admin.lead') }}" width="70px" height="70px"
                                        style="z-index: 4;position: relative;"> -->
                                        <!-- @endif -->
                                        <span class="agent-name">{{ getleads.lead.created_by }}</span>

                                    </a>
                                </div>
                                <div class="column is-12">
                                    <div v-if="getleads.lead.seen == 3">
                                        <i class="fa fa-circle" aria-hidden="true" style="color: #ccffcc"></i>
                                        <span> this lead has actions </span>
                                    </div>
                                    <div v-else>
                                        <i class="fa fa-circle" aria-hidden="true" style="color: red"></i>
                                        <span> no action yet </span>
                                    </div>
                                </div>
                                <!-- end if -->

                                <!-- if commercial_agent -->
                                <!-- <div class="column is-12">
                                    <a href="#"> -->
                                <!-- @if ($agent->image =='') -->
                                <!-- <img :src="'/uploads/lead.png'"
                                            class="img-circle lead_image" alt="image" width="70px" height="70px"
                                            style="z-index: 4;position: relative;"> -->
                                <!-- @else -->
                                <!-- <img src="{{ url('uploads/'.$agent->image) }}" class="img-circle lead_image"
                                            alt="{{ __('admin.lead') }}" width="70px" height="70px"
                                            style="z-index: 4;position: relative;"> -->
                                <!-- @endif -->
                                <!-- <span class="agent-name">hussien</span> -->

                                <!-- </a>
                                </div>
                                <div class="column is-12">
                                        <i class="fa fa-circle" aria-hidden="true" style="color: red"></i>
                                        <span> no action yet  </span>
                                </div> -->
                                <!-- end if -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-multiline" style="margin: 0">
                <div class="box-body column is-12 head_margin_top" style="margin-top: 160px;">
                    <div class="columns is-multiline" style="margin: 0">
                        <!-- information dev -->
                        <div class="column is-6">
                            <div class="inner-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">More Information</h3>
                                    <a href="#" style="color: rgb(200, 166, 48)">
                                        Send CIL</a>
                                </div>
                                <div class="inner-box-body">
                                    <div class="columns is-multiline" style="margin: 0">
                                        <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                First Name [EN]:
                                                <span v-if="!edit.first_name" id="first_name" class="">
                                                    {{ getleads.lead.first_name }}
                                                </span>
                                                <i v-if="!edit.first_name" @click="fn_edit('first_name')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="first_name"
                                                    id="first_name_btn"></i>
                                                <i v-if="edit.first_name" @click="fn_edit('first_name')"
                                                    class="fa fa-check save pull-right "
                                                    style="font-size: 20px; cursor: pointer" type="first_name"
                                                    id="first_name_save"></i>
                                                <span v-if="edit.first_name" id="first_name_input" class="">
                                                    <input type="text" class="update_input" v-model="updatelead.first_name" 
                                                        id="first_name_update">
                                                </span>
                                            </div>
                                        </div>
                                        <!-- <div class="column is-6 head_margin_top">
                                            Middle Name [EN] :
                                            <span v-if="!edit.middle_name" id="middle_name" class="">
                                                Mohamed
                                            </span>
                                            <i v-if="!edit.middle_name" @click="fn_edit('middle_name')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="middle_name"
                                                id="middle_name_btn"></i>
                                            <i v-if="edit.middle_name" @click="fn_edit('middle_name')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="middle_name"
                                                id="middle_name_save"></i>

                                            <span v-if="edit.middle_name" id="middle_name_input" class="hidden">
                                                <input type="text" class="update_input" value="mohamed"
                                                    id="middle_name_update">
                                            </span>
                                        </div> -->
                                        <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Last Name [EN] :
                                                <span v-if="!edit.last_name" id="last_name" class="">
                                                    {{ getleads.lead.last_name }}
                                                </span>
                                                <i v-if="!edit.last_name" @click="fn_edit('last_name')"
                                                    class="fa fa-edit update pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="last_name"
                                                    id="last_name_btn"></i>
                                                <i v-if="edit.last_name" @click="fn_edit('last_name')"
                                                    class="fa fa-check save pull-right"
                                                    style="font-size: 20px; cursor: pointer" type="last_name"
                                                    id="last_name_save"></i>
                                                <span v-if="edit.last_name" id="last_name_input" class="hidden">
                                                    <input type="text" v-model="updatelead.last_name" class="update_input" value="hassan"
                                                        id="last_name_update">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="column is-6 head_margin_top">
                                            Arabic First Name :
                                            <span v-if="!edit.ar_first_name" id="ar_first_name" class="">
                                                {{ getleads.lead.first_name_ar }}
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
                                                <input type="text" v-model="updatelead.ar_first_name" class="update_input" value="arabic first name"
                                                    id="ar_first_name">
                                            </span>
                                        </div>

                                        <!-- <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Arabic Middle Name :
                                                <span v-if="!edit.ar_middle_name" id="ar_middle_name" class="">
                                                    arabic middle name
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
                                                        id="ar_middle_name_update">
                                                </span>
                                            </div>
                                        </div>
 -->

                                        <div class="column is-6 head_margin_top">
                                            Arabic Last Name :
                                            <span v-if="!edit.ar_last_name" id="ar_last_name" class="">
                                                {{ getleads.lead.ar_last_name }}
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
                                                <input type="text" v-model="updatelead.ar_last_name" class="update_input" value="arabic last name"
                                                    id="ar_last_name_update">
                                            </span>
                                        </div>

                                        <!-- <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Nationality :
                                                <span v-if="!edit.nationality" id="nationality" class="">
                                                    {{ getleads.lead.nationality }}
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
                                                    <b-select placeholder="Select nationality">
                                                        <option>
                                                            all nationalities
                                                        </option>
                                                    </b-select>
                                                </span>
                                            </div>
                                        </div> -->

                                        <div class="column is-6 head_margin_top">
                                            Religion :
                                            <span v-if="!edit.religion" id="religion" class="">
                                                my religion
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
                                                <b-select v-model="updatelead.religion" placeholder="Select religion">
                                                    <option value="muslim">muslim</option>
                                                    <option value="christian">christian</option>
                                                    <option value="jewish">jewish</option>
                                                    <option value="other">other</option>
                                                </b-select>
                                            </span>
                                        </div>

                                        <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Country :
                                                <span v-if="!edit.country" id="country_id" class="">
                                                    CountryName
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
                                                    <b-select v-model="updatelead.country_id" placeholder="Select country">
                                                        <option v-for="country in countries" :key="country.id" :value="country.id"> {{ country.name }} </option>
                                                    </b-select>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="column is-6 head_margin_top">
                                            City :
                                            <span v-if="!edit.city" id="city_id" class="">
                                                city
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
                                                <b-select v-model="updatelead.city_id" placeholder="Select city">
                                                    <option v-for="city in citeis" :key="city.id" :value="city.id">{{ city.name }}</option>
                                                </b-select>
                                            </span>
                                        </div>
                                        <!-- <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Birth Date:
                                                <span v-if="!edit.birth_date" id="birth_date" class="">
                                                    birth date
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
                                                        id="birth_date_update">
                                                </span>
                                            </div>
                                        </div> -->
                                        <!-- <div class="column is-6 head_margin_top">
                                            Industry :
                                            <span v-if="!edit.industry" id="industry_id" class="">
                                                industry
                                            </span>
                                            <i v-if="!edit.industry" @click="fn_edit('industry')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="industry_id"
                                                id="industry_id_btn"></i>
                                            <i v-if="edit.industry" @click="fn_edit('industry')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="industry_id"
                                                id="industry_id_save"></i>
                                            <span v-if="edit.industry" id="industry_id_input" class="">
                                                <b-select placeholder="Select industry">
                                                    <option>
                                                        industry
                                                    </option>
                                                </b-select>
                                            </span>
                                        </div> -->
                                        <!-- <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Company :
                                                <span v-if="!edit.company" id="company" class="">
                                                    company
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
                                                        id="company_update">
                                                </span>
                                            </div>
                                        </div> -->
                                        <!-- <div class="column is-6 head_margin_top">
                                            School :
                                            <span v-if="!edit.school" id="school" class="">
                                                school
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
                                                    id="school_update">
                                            </span>
                                        </div> -->
                                        <!-- <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Club :
                                                <span v-if="!edit.club" id="club" class="">
                                                    Club name
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
                                                        id="club_update">
                                                </span>
                                            </div>
                                        </div> -->
                                        <!-- <div class="column is-6 head_margin_top">
                                            ID Number :
                                            <span v-if="!edit.id_number" id="id_number" class="">
                                                id number
                                            </span>
                                            <i v-if="!edit.id_number" @click="fn_edit('id_number')"
                                                class="fa fa-edit update pull-right"
                                                style="font-size: 20px; cursor: pointer" type="id_number"
                                                id="id_number_btn"></i>
                                            <i v-if="edit.id_number" @click="fn_edit('id_number')"
                                                class="fa fa-check save pull-right"
                                                style="font-size: 20px; cursor: pointer" type="id_number"
                                                id="id_number_save"></i>
                                            <span v-if="edit.id_number" id="id_number_input" class="">
                                                <input type="text" class="update_input" value="id number"
                                                    id="id_number_update">
                                            </span>
                                        </div> -->
                                        <div class="column is-6  border_right">
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
                                                    <input v-model="facebook" type="text" class="update_input"
                                                        value="face account" id="facebook_update">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="column is-6 head_margin_top">
                                            Notes :
                                            <span id="newComment">notes</span>
                                        </div>
                                        <div class="column is-6 border_right">
                                            <div class="head_margin_top">
                                                Reference :
                                                <span id="newComment">Reference</span>
                                            </div>
                                        </div>
                                        <div class="column is-6  head_margin_top">
                                            Lead Source :
                                            <span id="newComment">Lead Source name</span>
                                        </div>
                                        <div class="column is-6 border_right">
                                            <div class="head_margin_top">

                                                &nbsp;
                                                <span id="newComment"></span>
                                            </div>
                                        </div>
                                        <div class="column is-6 head_margin_top">
                                            Form Source :
                                            <span id="newComment">form source</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- div information from website -->
                                <div class="card">
                                <header class="card-header cardHeader"><p class="card-header-title">Intrest</p></header>
                                    <div class="card-content">
                                        <b-collapse class="card">
                                        <div slot="trigger" class="card-header">
                                            <p class="card-header-title"><span class="fa fa-star"></span> <strong>Intrest</strong></p>
                                        </div>
                                        <div class="card-content">
                                            <div class="content">
                                                <div class="columns is-multiline is-mobile">
                                                    <div class="column is-12">
                                                        <table class="table">
                                                            <thead>
                                                                <th>#</th>
                                                                <th>Type</th>
                                                                <th>Name</th>
                                                                <th>Date</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(data, index) in InterestArray" :key="index">
                                                                    <td>{{ index+1 }}</td>
                                                                    <td>{{ data.type }}</td>
                                                                    <td>{{ data.en_name }}</td>
                                                                    <td>{{ data.created_at }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </b-collapse>
                                    </div>
                                </div>
                                <div class="card">
                                <header class="card-header cardHeader"><p class="card-header-title">Favorit</p></header>
                                    <div class="card-content">
                                        <b-collapse class="card">
                                        <div slot="trigger" class="card-header">
                                            <p class="card-header-title"><span class="fa fa-star"></span> <strong>Favorit</strong></p>
                                        </div>
                                        <div class="card-content">
                                            <div class="content">
                                                <div class="columns is-multiline is-mobile">
                                                    <div class="column is-12">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Property</th>
                                                                    <th>Title</th>
                                                                    <th>Type</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(data, index) in favoriteArray" :key="index">
                                                                    <td>{{ index+1 }}</td>
                                                                    <td>{{ data.id }}</td>
                                                                    <td>{{ data.en_name }}</td>
                                                                    <td>{{ data.type }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </b-collapse>
                                    </div>
                                </div>
                                <div class="card">
                                <header class="card-header cardHeader"><p class="card-header-title">Request unit</p></header>
                                    <div class="card-content">
                                        <b-collapse class="card">
                                        <div slot="trigger" class="card-header">
                                            <p class="card-header-title"><span class="fa fa-star"></span> <strong>Request unit</strong></p>
                                        </div>
                                        <div class="card-content">
                                            <div class="content">
                                                <div class="columns is-multiline is-mobile">
                                                    <div class="column is-12">
                                                        <table class="table">
                                                            <thead>
                                                                <th>#</th>
                                                                <th>Location</th>
                                                                <th>Unit type</th>
                                                                <th>Created at</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(data, index) in requestLeadArray" :key="index">
                                                                    <td> {{ index+1 }} </td>
                                                                    <td> {{ data.location_name }} </td>
                                                                    <td> {{ data.unit_name }} </td>
                                                                    <td> {{ data.created_at }} </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </b-collapse>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action dev -->
                        <div class="column is-6">
                            <div class="inner-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Actions </h3>
                                </div>
                                <div class="inner-box-body">
                                    <div class="columns is-multiline" style="margin: 0">
                                        <b-tabs class="block" expanded type="is-toggle">
                                            <!-- <b-tab-item label="Actions"> -->
                                            <section>
                                                <b-tabs v-model="activeTabActions" position="is-centered" class="block">
                                                    <b-tab-item label="Add Call">
                                                        <div class="columns is-multiline is-mobile">
                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Call In Or Out ?</label>
                                                                    <div class="control">
                                                                        <b-radio v-model="phone_in_out"
                                                                            native-value="out">
                                                                            Call Out
                                                                        </b-radio>
                                                                        <b-radio v-model="phone_in_out"
                                                                            native-value="in">
                                                                            Call In
                                                                        </b-radio>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Contact</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newCallData.contact_id">
                                                                                <option value="0" selected>Lead
                                                                                </option>
                                                                                <option v-for="contact in contacts"
                                                                                    :key="contact.id"
                                                                                    :value="contact.id">
                                                                                    {{contact.name}}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Phone</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newCallData.phone">
                                                                                <option :value="leadData.phone"
                                                                                    selected>{{leadData.phone}}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Call Status</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="call_status_id">
                                                                                <option v-for="status in callStatus"
                                                                                    :key="status.id" :value="status.id">
                                                                                    {{status.name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Date">
                                                                        <b-datepicker placeholder="Click to select..."
                                                                            :date-formatter="dateFormatter"
                                                                            position="is-bottom-left"
                                                                            v-model="newCallData.date">
                                                                        </b-datepicker>
                                                                    </b-field>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12" v-if="showDueCard">
                                                                <div class="card mb-8">
                                                                    <header class="card-header">
                                                                        <p class="card-header-title">
                                                                            Next Action Data
                                                                        </p>
                                                                    </header>
                                                                    <div class="card-content cardContentDue">
                                                                        <div class="content">
                                                                            <div class="columns is-multiline is-mobile">
                                                                                <div class="column is-6">
                                                                                    <div class="field">
                                                                                        <label class="label">To-Do
                                                                                            Type</label>
                                                                                        <div class="control">
                                                                                            <div
                                                                                                class="select is-fullwidth">
                                                                                                <select
                                                                                                    v-model="newCallData.to_do_type">
                                                                                                    <option
                                                                                                        value="call">
                                                                                                        Call
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="meeting">
                                                                                                        Meeting
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="other">
                                                                                                        Other
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="column is-6">
                                                                                    <div class="field">
                                                                                        <b-field label="Due Date">
                                                                                            <datetime type="datetime"
                                                                                                v-model="newCallData.to_do_due_date"
                                                                                                input-class="input"
                                                                                                value-zone="Africa/Cairo"
                                                                                                zone="Africa/Cairo"
                                                                                                :phrases="{ok: 'Confirm', cancel: 'Cancel'}"
                                                                                                format="yyyy-MM-dd HH:mm:ss"
                                                                                                :hour-step="1"
                                                                                                :minute-step="1"
                                                                                                :week-start="7"
                                                                                                use12-hour auto>
                                                                                            </datetime>
                                                                                            <!--<b-datepicker
                                                                                                placeholder="Click to select..."
                                                                                                :date-formatter="dateFormatter2"
                                                                                                position="is-bottom-left" v-model="newCallData.to_do_due_date">
                                                                                            </b-datepicker>-->
                                                                                        </b-field>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="column is-12">
                                                                                    <div class="field">
                                                                                        <label
                                                                                            class="label">Description</label>
                                                                                        <div class="control">
                                                                                            <textarea class="textarea"
                                                                                                placeholder=""
                                                                                                v-model="newCallData.to_do_description"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Duration">
                                                                        <b-input v-model="newCallData.duration">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>

                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Probability</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newCallData.probability">
                                                                                <option value="Followup">Followup
                                                                                </option>
                                                                                <option value="On going">On going
                                                                                </option>
                                                                                <option value="Expected Closing">
                                                                                    Expected Closing</option>
                                                                                <option value="Closed">Closed
                                                                                </option>
                                                                                <option value="Routation">Routation
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Budget">
                                                                        <b-input v-model="newCallData.budget">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Location</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newCallData.location"
                                                                                @change="selectEvent">
                                                                                <option v-for="location in locations"
                                                                                    :key="location.id"
                                                                                    :value="location.id">
                                                                                    {{location.en_name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Projects</label>
                                                                    <div class="control">
                                                                        <div class="is-fullwidth">
                                                                            <!-- <select v-model="newCallData.projects" multiple>
                                                                                    <option v-for="project in projects" v-if="newCallData.location == project.location_id" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                                                </select> -->
                                                                            <multiselect :close-on-select="false"
                                                                                v-model="newCallData.projects"
                                                                                tag-placeholder="Add this as new tag"
                                                                                placeholder="Select Projects"
                                                                                label="en_name" track-by="id" value="id"
                                                                                :options="options" :multiple="true"
                                                                                :taggable="true"
                                                                                style="z-index: 1000000000;">
                                                                            </multiselect>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-12" style="margin-top: 25px;">
                                                                <div class="field">
                                                                    <label class="label">Description</label>
                                                                    <div class="control">
                                                                        <textarea class="textarea" placeholder=""
                                                                            v-model="newCallData.description"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <div class="control">
                                                                    <button class="button is-link mr-10"
                                                                        @click="addNewCall">Submit</button>
                                                                    <a class="button is-danger is-meduim mr-10"
                                                                        v-if="showDueCard"
                                                                        @click="showDueCard = !showDueCard">Remove
                                                                        Next
                                                                        Actions</a>
                                                                    <a class="button is-success is-meduim mr-10" v-else
                                                                        @click="showDueCard = !showDueCard">Next
                                                                        Actions</a>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </b-tab-item>

                                                    <b-tab-item label="Add Meeting">
                                                        <div class="columns is-multiline is-mobile">

                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Contact</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newMeetingData.contact_id">
                                                                                <option value="0">Lead</option>
                                                                                <option v-for="contact in contacts"
                                                                                    :key="contact.id"
                                                                                    :value="contact.id">
                                                                                    {{contact.name}}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Meeting Status</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="meeting_status_id">
                                                                                <option v-for="status in meetingStatus"
                                                                                    :key="status.id" :value="status.id">
                                                                                    {{status.name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-12" v-if="showDueCard">
                                                                <div class="card mb-8">
                                                                    <header class="card-header">
                                                                        <p class="card-header-title">
                                                                            Next Action Data
                                                                        </p>
                                                                    </header>
                                                                    <div class="card-content cardContentDue">
                                                                        <div class="content">
                                                                            <div class="columns is-multiline is-mobile">
                                                                                <div class="column is-6">
                                                                                    <div class="field">
                                                                                        <label class="label">To-Do
                                                                                            Type</label>
                                                                                        <div class="control">
                                                                                            <div
                                                                                                class="select is-fullwidth">
                                                                                                <select
                                                                                                    v-model="newMeetingData.to_do_type">
                                                                                                    <option
                                                                                                        value="call">
                                                                                                        Call
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="meeting">
                                                                                                        Meeting
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="other">
                                                                                                        Other
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="column is-6">
                                                                                    <div class="field">
                                                                                        <b-field label="Due Date">
                                                                                            <datetime type="datetime"
                                                                                                v-model="newMeetingData.to_do_due_date"
                                                                                                input-class="input"
                                                                                                value-zone="Africa/Cairo"
                                                                                                zone="Africa/Cairo"
                                                                                                :phrases="{ok: 'Confirm', cancel: 'Cancel'}"
                                                                                                format="yyyy-MM-dd HH:mm:ss"
                                                                                                :hour-step="1"
                                                                                                :minute-step="1"
                                                                                                :week-start="7"
                                                                                                use12-hour auto>
                                                                                            </datetime>
                                                                                            <!--<b-datepicker
                                                                                                placeholder="Click to select..."
                                                                                                :date-formatter="dateFormatter2"
                                                                                                position="is-bottom-left" v-model="newMeetingData.to_do_due_date">
                                                                                            </b-datepicker>-->
                                                                                        </b-field>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="column is-12">
                                                                                    <div class="field">
                                                                                        <label
                                                                                            class="label">Description</label>
                                                                                        <div class="control">
                                                                                            <textarea class="textarea"
                                                                                                placeholder=""
                                                                                                v-model="newMeetingData.to_do_description"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Duration">
                                                                        <b-input v-model="newMeetingData.duration">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Date">
                                                                        <b-datepicker placeholder="Click to select..."
                                                                            :date-formatter="dateFormatter"
                                                                            position="is-bottom-left"
                                                                            v-model="newMeetingData.date">
                                                                        </b-datepicker>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Time">
                                                                        <b-timepicker placeholder="Select Time"
                                                                            :hour-format="format"
                                                                            v-model="newMeetingData.time"
                                                                            :time-formatter="timeFormater">
                                                                        </b-timepicker>
                                                                    </b-field>
                                                                </div>
                                                            </div>

                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Probability</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select
                                                                                v-model="newMeetingData.probability">
                                                                                <option value="highest">Highest
                                                                                </option>
                                                                                <option value="high">High</option>
                                                                                <option value="normal">Normal
                                                                                </option>
                                                                                <option value="low">Low</option>
                                                                                <option value="lowest">Lowest
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Budget">
                                                                        <b-input v-model="newMeetingData.budget">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="column is-6">
                                                                    <div class="field">
                                                                        <label class="label">Projects</label>
                                                                        <div class="control">
                                                                            <div class="select is-fullwidth">
                                                                                <select v-model="newMeetingData.projects">
                                                                                    <option v-for="project in projects" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->

                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Location</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newMeetingData.location"
                                                                                @change="selectEvent">
                                                                                <option v-for="location in locations"
                                                                                    :key="location.id"
                                                                                    :value="location.id">
                                                                                    {{location.en_name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Projects</label>
                                                                    <div class="control">
                                                                        <div class="is-fullwidth">
                                                                            <!-- <select v-model="newMeetingData.projects" multiple>
                                                                                    <option v-for="project in projects" v-if="newMeetingData.location == project.location_id" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                                                </select> -->
                                                                            <multiselect :close-on-select="false"
                                                                                v-model="newMeetingData.projects"
                                                                                tag-placeholder="Add this as new tag"
                                                                                placeholder="Select Projects"
                                                                                label="en_name" track-by="id" value="id"
                                                                                :options="options" :multiple="true"
                                                                                :taggable="true"
                                                                                style="z-index: 1000000000;">
                                                                            </multiselect>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Description</label>
                                                                    <div class="control">
                                                                        <textarea class="textarea" placeholder=""
                                                                            v-model="newMeetingData.description"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <div class="control">
                                                                    <button class="button is-link mr-10"
                                                                        @click="addNewMeeting">Submit</button>
                                                                    <a class="button is-danger is-meduim mr-10"
                                                                        v-if="showDueCard"
                                                                        @click="showDueCard = !showDueCard">Remove
                                                                        Next
                                                                        Actions</a>
                                                                    <a class="button is-success is-meduim mr-10" v-else
                                                                        @click="showDueCard = !showDueCard">Next
                                                                        Actions</a>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </b-tab-item>

                                                    <b-tab-item label="Add Request">
                                                        <div class="columns is-multiline is-mobile">
                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Buyer Or Seller</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select
                                                                                v-model="newRequestData.buyer_seller">
                                                                                <option value="buyer">Buyer</option>
                                                                                <option value="seller">Seller
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="column is-6">
                                                                    <div class="field">
                                                                        <label class="label">Location</label>
                                                                        <div class="control">
                                                                            <div class="select is-fullwidth">
                                                                                <select v-model="newRequestData.location">
                                                                                    <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                 <div class="column is-6">
                                                                    <div class="field">
                                                                        <label class="label">Projects</label>
                                                                        <div class="control">
                                                                            <div class="select is-fullwidth">
                                                                                <select v-model="newRequestData.projects">
                                                                                    <option v-for="project in projects" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Location</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newRequestData.location"
                                                                                @change="selectEvent">
                                                                                <option v-for="location in locations"
                                                                                    :key="location.id"
                                                                                    :value="location.id">
                                                                                    {{location.en_name}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Projects</label>
                                                                    <div class="control">
                                                                        <div class="is-fullwidth">
                                                                            <!-- <select v-model="newRequestData.projects" multiple>
                                                                                    <option v-for="project in projects" v-if="newRequestData.location == project.location_id" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                                                </select> -->
                                                                            <multiselect :close-on-select="false"
                                                                                v-model="newRequestData.projects"
                                                                                tag-placeholder="Add this as new tag"
                                                                                placeholder="Select Projects"
                                                                                label="en_name" track-by="id" value="id"
                                                                                :options="options" :multiple="true"
                                                                                :taggable="true"
                                                                                style="z-index: 1000000000;">
                                                                            </multiselect>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Type</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newRequestData.unit_type"
                                                                                @change="unitsTypes">
                                                                                <option value="commercial">
                                                                                    Commercial
                                                                                </option>
                                                                                <option value="residential">
                                                                                    Residential
                                                                                </option>
                                                                                <option value="land">Land</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Unit Type</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select
                                                                                v-model="newRequestData.unit_type_id">
                                                                                <option :value="type.id"
                                                                                    v-for="type in unitTypes"
                                                                                    :key="type.id">{{type.en_name}}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Type</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="request_type">
                                                                                <option value="resale">Resale
                                                                                </option>
                                                                                <option value="rental">Rental
                                                                                </option>
                                                                                <option value="new_home">New Home
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12" v-if="showFullDataCard">
                                                                <div class="card mb-8">

                                                                    <div class="card-content cardContentDue">
                                                                        <div class="content">
                                                                            <div class="columns is-multiline is-mobile">
                                                                                <div class="column is-6">
                                                                                    <b-field label="Bathrooms From">
                                                                                        <b-input
                                                                                            v-model="newRequestData.bathrooms_from">
                                                                                        </b-input>
                                                                                    </b-field>
                                                                                </div>
                                                                                <div class="column is-6">
                                                                                    <b-field label="Bathrooms To">
                                                                                        <b-input
                                                                                            v-model="newRequestData.bathrooms_to">
                                                                                        </b-input>
                                                                                    </b-field>
                                                                                </div>
                                                                                <div class="column is-6">
                                                                                    <b-field label="Rooms From">
                                                                                        <b-input
                                                                                            v-model="newRequestData.rooms_from">
                                                                                        </b-input>
                                                                                    </b-field>
                                                                                </div>
                                                                                <div class="column is-6">
                                                                                    <b-field label="Rooms To">
                                                                                        <b-input
                                                                                            v-model="newRequestData.rooms_to">
                                                                                        </b-input>
                                                                                    </b-field>
                                                                                </div>



                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Price From">
                                                                        <b-input v-model="newRequestData.price_from">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Price To">
                                                                        <b-input v-model="newRequestData.price_to">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Area From">
                                                                        <b-input v-model="newRequestData.area_from">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Area To">
                                                                        <b-input v-model="newRequestData.area_to">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>
                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <label class="label">Date</label>
                                                                    <div class="control">
                                                                        <div class="select is-fullwidth">
                                                                            <select v-model="newRequestData.date">
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
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-6">
                                                                <div class="field">
                                                                    <b-field label="Down Payment">
                                                                        <b-input v-model="newRequestData.down_payment">
                                                                        </b-input>
                                                                    </b-field>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Notes</label>
                                                                    <div class="control">
                                                                        <textarea class="textarea" placeholder=""
                                                                            v-model="newRequestData.notes"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <div class="control">
                                                                    <button class="button is-link mr-10"
                                                                        @click="addNewRequest">Submit</button>
                                                                    <button class="button is-success is-meduim mr-10"
                                                                        @click="getSuggestionsNew">Suggestions</button>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <!-- <div v-html="suggestions" id="suggestions"></div> -->
                                                                <div id="suggestions">
                                                                    <b-table v-if="suggestionsActive == true"
                                                                        :data="units" bordered checkable narrowed
                                                                        hoverable
                                                                        :checked-rows.sync="selectedSuggestions">
                                                                        <template slot-scope="props">
                                                                            <b-table-column field="id" label="ID"
                                                                                sortable>
                                                                                {{props.row.id}}
                                                                            </b-table-column>
                                                                            <b-table-column
                                                                                v-if="suggestions_request_type == 'new_home'"
                                                                                field="meter_price"
                                                                                label="Price / Meter" sortable>
                                                                                {{props.row.meter_price}}
                                                                            </b-table-column>
                                                                            <b-table-column
                                                                                v-if="suggestions_request_type == 'resale'"
                                                                                field="price" label="Price" sortable>
                                                                                {{props.row.price}}
                                                                            </b-table-column>
                                                                            <b-table-column
                                                                                v-if="suggestions_request_type == 'rental'"
                                                                                field="value_of_rent"
                                                                                label="Value Of Rent" sortable>
                                                                                {{props.row.value_of_rent}}
                                                                            </b-table-column>
                                                                            <b-table-column field="area" label="Area"
                                                                                sortable>
                                                                                {{props.row.area}}
                                                                            </b-table-column>
                                                                            <b-table-column
                                                                                v-if="suggestions_request_type == 'new_home'"
                                                                                field="en_name" label="Name" sortable>
                                                                                {{props.row.en_name}}
                                                                            </b-table-column>
                                                                            <b-table-column
                                                                                v-if="suggestions_request_type != 'new_home'"
                                                                                field="title" label="Title" sortable>
                                                                                {{props.row.en_title}}
                                                                            </b-table-column>
                                                                        </template>
                                                                    </b-table>
                                                                </div>

                                                                <button v-if="suggestionsActive == true"
                                                                    class="button is-success is-meduim mr-10"
                                                                    @click="addSuggestions">Add Suggestions</button>
                                                            </div>

                                                        </div>
                                                    </b-tab-item>
                                                    <b-tab-item label="Add Note">
                                                        <div class="columns is-multiline is-mobile">


                                                            <div class="column is-12">
                                                                <div class="field">
                                                                    <label class="label">Note</label>
                                                                    <div class="control">
                                                                        <textarea class="textarea" placeholder=""
                                                                            v-model="newNote"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="column is-12">
                                                                <div class="control">
                                                                    <button class="button is-link mr-10"
                                                                        @click="addNewNote">Add</button>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </b-tab-item>
                                                    <b-tab-item label="Add Unit">
                                                        <div class="columns is-multiline is-mobile">
                                                            <createUnitHintSection :hintLeadData="leadData" />
                                                            <!-- <div class="column is-12">
                                                                    <div class="control">
                                                                        <button class="button is-link mr-10" @click="addNewNote">Add</button>
                                                                    </div>
                                                                </div> -->


                                                        </div>
                                                    </b-tab-item>
                                                </b-tabs>
                                            </section>
                                            <!-- </b-tab-item> -->
                                        </b-tabs>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
    import {
        updatelead,
        getCountries,
        getcities,
        getSuggestionsNew,
        getUnitTypes,
        addMeeting,
        addCall,
        addRequest,
        getLeadData,
        addNote,
        GetFavoriteLead,
        GetleadInterest,
        FromrequestPage,
        getPublicData,
    } from "./../../calls"
    import Multiselect from 'vue-multiselect'
    import createUnitHintSection from "../Resale/createUnitHintSection";
    // import Header from '../Layout/Header'
    // import Footer from '../Layout/Footer'
    export default {
        data() {
            return {
                userId: window.auth_user.id,
                favoriteArray: [],
                InterestArray: [],
                requestLeadArray: [],
                getleads:[],
                countries:[],
                citeis:[],
                updatelead:[],
                lead_id:null,
                phone_in_out: 'out',
                newCallData: {
                    date: new Date()
                },
                newMeetingData: {
                    date: new Date()
                },
                contacts: [],
                isLoading: true,
                activeTabActions: 0,
                leadData: {},
                newRequestData: {},
                call_status_id: '',
                meeting_status_id: '',
                callStatus: [],
                showDueCard: false,
                locations: [],
                options: [],
                meetingStatus: [],
                unitTypes: [],
                request_type: '',
                showFullDataCard: false,
                suggestionsActive: false,
                newNote: '',
                first_name_value: null,
                edit: {
                    first_name: false,
                    middle_name: false,
                    last_name: false,
                    ar_first_name: false,
                    ar_middle_name: false,
                    ar_last_name: false,
                    nationality: false,
                    religion: false,
                    country: false,
                    city: false,
                    birth_date: false,
                    industry: false,
                    company: false,
                    school: false,
                    club: false,
                    id_number: false,
                    facebook: false
                }

            };
        },
        created(){
            this.getuserid()
            this.getData()
            this.Allcountries()
            this.Allcities()
        },
        mounted() {
        },
        computed: {
            format() {
                return this.formatAmPm ? '12' : '24'
            }
        },
        components: {
            // Header: Header,
            // Footer: Footer,
            Multiselect,
            createUnitHintSection : createUnitHintSection,
        },
        methods: {
            getPublic(){
                getPublicData().then(response=>{
                    //console.log(response)
                    this.callStatus = response.data.callStatus
                    this.projects = response.data.projects
                    //console.log('this.projectssssssss');
                    //console.log(this.projects);
                    this.meetingStatus = response.data.meetingStatus
                    this.locations = response.data.locations
                    this.developers = response.data.developers
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getuserid(){
                var url = window.location.pathname
                var stuff = url.split('/');
                this.lead_id = stuff[stuff.length-1];
                console.log('lead_id',this.lead_id)
            },
            getData(loading = true) {
                getLeadData(this.lead_id).then(response=>{
                    this.getleads = response.data
                    console.log('this get lead var',this.getleads)
                    this.first_name_value = response.data.lead.first_name
                    console.log('test response get lead',this.getleads)
                    // new get lead data
                    this.leadData = response.data.lead
                    this.contacts = response.data.contacts
                    this.newCallData.contact_id = 0
                    this.newMeetingData.contact_id = 0
                    this.newCallData.phone = this.leadData.phone
                    this.selectedTags = response.data.lead.tags
                // end new get lead data
                    this.isLoading = false;
                    this.LeadInterest()
                    this.LeadInterest()
                    this.getPublic()
                    this.favoriteLead()
                    this.getNewRequestData()
                }).catch(error => {
                    console.log(error)
                })
            },
            getNewRequestData(){
                const data = this.getleads.lead
                FromrequestPage(data).then(response=>{
                    this.requestLeadArray = response.data
                    console.log('Lead request from get function request',requestLeadArray)
                }).catch(error=>{
                    console.log(error)
                })
            },
            favoriteLead(){
            const data = this.getleads.lead
            console.log('test for data',this.getleads)
                GetFavoriteLead(data).then(response=>{
                    console.log(response)
                    this.favoriteArray = response.data
                    // console.log('favoriteArray',this.favoriteArray)
                })
                .catch(error => {
                    console.log(error)
                })
                this.OpenFavorite = true
            },
            LeadInterest(){
                console.log("taaaaaaaaaaaabs inter")
                let data = this.getleads.lead
                console.log('data intrest',data)
                GetleadInterest(data).then(response=>{
                    console.log(response)
                    this.InterestArray = response.data
                    console.log('Lead-intrest',this.InterestArray)
                })
                .catch(error => {
                    console.log(error)
                })
                this.OpenInterest =true
            },
            getRequestPageData(){
            },
            Allcountries(){
                getCountries().then(response=>{
                    this.countries = response.data.data
                    // console.log('all countries',this.countries)
                }).catch(error => {
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
            dateFormatter(dt) {
                var date = dt.toLocaleDateString();
                const [month, day, year] = date.split('/')
                this.parsedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                return date
            },
            timeFormater(dt) {
                var time = dt.toLocaleTimeString();
                this.time = time
                return time
            },
            selectEvent() {
                console.clear()
                let payload = [];
                this.projects.map(project => {
                    if (this.newCallData.location == project.location_id)
                        payload.push(project);
                    if (this.newMeetingData.location == project.location_id)
                        payload.push(project);
                    if (this.newRequestData.location == project.location_id)
                        payload.push(project);
                });
                this.options = payload;
            },
            unitsTypes(event) {
                var usage = event.target.value
                getUnitTypes({
                        usage: usage,
                        _token: this.token
                    }).then(response => {
                        console.log(response)
                        this.unitTypes = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            addNewMeeting() {
                this.isLoading = true
                var data = {
                    "_token": this.token,
                    "user_id": this.userId,
                    'lead_id': this.leadData.id,
                    "contact_id": this.newMeetingData.contact_id,
                    "phone": this.newMeetingData.phone,
                    "meeting_status_id": this.meeting_status_id,
                    "duration": this.newMeetingData.duration,
                    "date": this.parsedDate,
                    "time": this.time,
                    "location": this.newMeetingData.location,
                    "probability": this.newMeetingData.probability ? this.newMeetingData.probability : 'normal',
                    "budget": this.newMeetingData.budget,
                    "projects": this.mapProjects(this.newMeetingData.projects),
                    "description": this.newMeetingData.description,
                    "to_do_type": this.newMeetingData.to_do_type,
                    "to_do_due_date": this.newMeetingData.to_do_due_date,
                    "to_do_description": this.newMeetingData.to_do_description,
                };
                console.log(data)
                addMeeting(data).then(response => {
                        console.log(response)
                        console.log(response)
                        if (response.data.status == 501) {
                            this.error('Meeting')
                            this.isLoading = false
                        } else {
                            this.newMeetingData = {}
                            this.meeting_status_id = 0
                            this.$emit("changeHint", null)
                            this.getData()
                            this.success('Meeting')
                        }
                        //this.isLoading = false

                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            addNewCall() {
                this.isLoading = true
                let data = {
                    "_token": this.token,
                    "user_id": this.userId,
                    'lead_id': this.leadData.id,
                    "phone_in_out": this.phone_in_out,
                    "contact_id": this.newCallData.contact_id,
                    "phone": this.newCallData.phone,
                    "call_status_id": this.call_status_id,
                    "duration": this.newCallData.duration,
                    "date": this.parsedDate,
                    "probability": this.newCallData.probability ? this.newCallData.probability : 'normal',
                    "budget": this.newCallData.budget,
                    "location_id": this.newCallData.location,
                    "projects": this.mapProjects(this.newCallData.projects),
                    "description": this.newCallData.description,
                    "to_do_type": this.newCallData.to_do_type,
                    "to_do_due_date": this.newCallData.to_do_due_date,
                    "to_do_description": this.newCallData.to_do_description,
                };
                console.log(data)
                addCall(data).then(response => {
                        console.log(response)
                        if (response.data.status == 501) {
                            this.error('Call')
                            this.isLoading = false
                        } else {
                            //this.isLoading = false
                            if (this.call_status_id == 6 && (this.tab == 'cold_calls' || this.tab ==
                                    'today_cold_calls')) {
                                console.log("TRUEEEEEEEEEEEEEEEEEEEE")
                                this.convertLeadCC();
                            }
                            this.newCallData = {}
                            this.call_status_id = 0
                            this.$emit("changeHint", null)
                            this.getData()
                            this.success('Call')
                        }

                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            addNewRequest() {
                console.clear()
                this.isLoading = true
                var data = {
                    'lead_id': this.leadData.id,
                    "buyer_seller": this.newRequestData.buyer_seller,
                    "location": this.newRequestData.location,
                    "unit_type": this.newRequestData.unit_type,
                    "unit_type_id": this.newRequestData.unit_type_id ? this.newRequestData.unit_type_id : 0,
                    "request_type": this.request_type,
                    "bathrooms_from": this.newRequestData.bathrooms_from,
                    "bathrooms_to": this.newRequestData.bathrooms_to,
                    "rooms_from": this.newRequestData.rooms_from,
                    "rooms_to": this.newRequestData.rooms_to,
                    "price_from": this.newRequestData.price_from,
                    "price_to": this.newRequestData.price_to,
                    "area_from": this.newRequestData.area_from,
                    "area_to": this.newRequestData.area_to,
                    "date": this.newRequestData.date,
                    "down_payment": this.newRequestData.down_payment,
                    "notes": this.newRequestData.notes,
                    "project_id": this.mapProjects(this.newRequestData.projects),
                };
                console.log(data)
                addRequest(data).then(response => {
                        console.log(response)
                        //this.isLoading = false
                        this.newRequestData = {}
                        this.getData()
                        if (response.data.status == 'error')


                            this.error('Please Fille Required Date')
                        else
                            this.success('Request')

                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            getSuggestionsNew() {
                //this.isLoading = true
                var data = {
                    'lead_id': this.leadData.id,
                    "buyer_seller": this.newRequestData.buyer_seller,
                    "location": this.newRequestData.location,
                    "unit_type": this.newRequestData.unit_type,
                    "unit_type_id": this.newRequestData.unit_type_id ? this.newRequestData.unit_type_id : 0,
                    "request_type": this.request_type,
                    "bathrooms_from": this.newRequestData.bathrooms_from,
                    "bathrooms_to": this.newRequestData.bathrooms_to,
                    "rooms_from": this.newRequestData.rooms_from,
                    "rooms_to": this.newRequestData.rooms_to,
                    "price_from": this.newRequestData.price_from,
                    "price_to": this.newRequestData.price_to,
                    "area_from": this.newRequestData.area_from,
                    "area_to": this.newRequestData.area_to,
                    "date": this.newRequestData.date,
                    "down_payment": this.newRequestData.down_payment,
                    "notes": this.newRequestData.notes,
                    "project_id": this.mapProjects(this.newRequestData.projects),
                };
                if (data['project_id'].length > 0) {
                    if (data['request_type'] == "new_home") {
                        this.suggestionsActive = false
                        console.log("No Suggestions when there are projects selected")
                        return;
                    }
                }
                console.log(data)
                this.suggestions_request_type = this.request_type
                // $("#suggestions").html("");            
                getSuggestionsNew(data).then(response => {
                        console.log(response)
                        // this.suggestions = response.data;
                        this.units = response.data
                        this.suggestionsActive = true
                        //$('#suggestions').html(response.data);
                        // this.leadData = response.data.lead
                        // this.contacts = response.data.contacts
                        // this.newCallData.contact_id = 0
                        // this.newMeetingData.contact_id = 0
                        // this.newCallData.phone = this.leadData.phone
                        /*if(this.contacts.length > 0){
                            this.newCallData.contact_id = this.contacts[0].id
                        }*/
                        this.isLoading = false
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            addNewNote() {
                this.isLoading = true
                var data = {
                    lead_id: this.leadData.id,
                    user_id: this.userId,
                    note: this.newNote,
                    _token: this.token

                };
                console.log(data)
                addNote(data).then(response => {
                        console.log(response)
                        //this.isLoading = false
                        this.newRequestData = {}
                        this.getData()
                        this.success('Note')
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            mapProjects(projects = [], id = null) {
                let payload = [];
                projects.map(project => {
                    payload.push(project.id);
                });

                return payload;
            },
            fn_edit(value) {
                console.log(value);
                console.log(this.edit[value]);
                if (this.edit[value] == true) {
                    const bodyFormData = new FormData();
                    for (const key in this.updatelead) {
                        const value = this.updatelead[key];
                        bodyFormData.set(key, value);
                    }
                    bodyFormData.append('lead_id',this.lead_id)
                    updatelead(bodyFormData).then(response=>{
                        console.log('lead update success')
                        this.$toast.open({
                            message: 'Vote is deleted now!',
                            position: 'is-bottom',
                            type: 'is-success'
                        })
                        this.isLoading = false
                        // window.location.reload()
                        getData()
                    }).catch(error => {
                        console.log(error)
                    })
                }
                this.edit[value] = !this.edit[value];
            },
            success(action) {
                this.$toast.open({
                    message: action+' Added Successfully',
                    type: 'is-success',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
            error(action) {
                this.$toast.open({
                    message: action+' Adding Error, Check missing data',
                    type: 'is-danger',
                    position: 'is-bottom',
                    duration: 5000,
                })
            },
        }
    };
</script>


<style scoped>
    * {
        font-family: 'Lato', sans-serif !important;
        /* color: #161616 !important; */
    }

    .box {
        justify-content: center !important;
        background-color: #ffffff !important;
    }

    .box-body {
        padding: 0px 64px;
        /* font-size: 1em; */
        /* background: red; */
        /* border-radius: 3px; */
        /* box-shadow: 0 0px 20px rgba(0, 0, 0, 0.1); */
    }

    .user-info {
        font-size: 21px;
        letter-spacing: 2px;
        color: #b07d12;
        font-weight: 700;
        /* margin-left: 80px;
        margin-top: 44px; */
    }

    .user-email {
        font-size: 16px;
        letter-spacing: 2px;
        color: #b07d12;
        font-weight: 700;
        /* margin-left: 80px;
        margin-top: 5px; */
    }

    .user-info span {
        font-size: 16px;
    }

    .user-phone,
    .user-created {
        font-size: 16px;
        letter-spacing: 2px;
        font-weight: 500;
        /* margin-left: 80px; */
    }

    .img-circle {
        border-radius: 50%;
    }

    .lead_image {
        border: solid #b07d12 4px;
    }

    .agent-name {
        background: #161616;
        color: #fff;
        padding: 5px 20px;
        border-radius: 30px;
        margin-left: -18px;
        font-size: 16px;
        z-index: 0;
        position: relative;
        top: -29%;
    }

    .head_margin_top {
        margin-top: 30px;
        padding-left: 12px;
    }

    .inner-box {
        position: relative;
        border-radius: 3px;
        background: #ffffff;
        border-top: 3px solid #b07d12;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 0px 20px rgba(0, 0, 0, 0.1)
    }

    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
    }

    .box-header {
        color: #444;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        padding: 10px;
        position: relative;
        font-size: 18px;
        margin: 0;
        line-height: 1;
    }

    .inner-box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
    }

    .border_right {
        border-right: solid 1px rgb(179, 179, 179);
    }

    .fab {
        font-family: "Font Awesome 5 Brands" !important;
    }

    .fa,
    .far,
    .fas {
        font-family: "Font Awesome 5 Free" !important;
    }
</style>
<style>
.multiselect__tag,
.multiselect__option--highlight{
    background: #b07d12 !important;
}

.multiselect__tag-icon:hover{
    background: #b07d12 !important;
}
</style>
