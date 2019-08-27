<template>
    <div class="side-pop">
        <nav class="level is-mobile">
            <div class="level-left">
                <a class="level-item" aria-label="like" @click="sideClose">
                    <span class="icon is-small">
                        <i class="fa fa-close hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            <div class="level-right">
                <a class="level-item" aria-label="like">
                    <span class="icon is-small">
                        <i class="fa fa-cloud hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
                <a class="level-item" aria-label="like">
                    <span class="icon is-small">
                        <i class="fa fa-trash-o hintIcont" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
        </nav>
        <div class="box" v-if="leadData.first_name" style="position: relative">
            <article class="media">
                <div class="media-left">
                    <figure class="image avatarImage"  v-if="leadData.image">
                        <img :src="'https://theaddress-eg.com/uploads/'+leadData.image">
                    </figure>
                    <span class="nameSpan" v-else>{{getShortName()}}</span>
                </div>
                <div class="media-content">
                <div class="content">
                    <div class="columns is-mobile">
                        <div class="column is-6 respo-header" style="display: block; margin-top: 0; margin-left: 0">
                            <h3>{{leadData.first_name}} {{leadData.last_name}}</h3>
                            <h5>Lead Source  : {{leadData.lead_source_name}} </h5>
                            <p>Reference  : {{leadData.reference}}</p>
                            <p>Creation Date  : {{leadData.created_at}}</p>
                            <!-- <p>
                            <strong><h3>{{leadData.first_name}} {{leadData.last_name}}</h3></strong>
                            <h5>Lead Source  : {{leadData.lead_source_name}} </h5>
                            Reference  : {{leadData.reference}}<br>
                            Creation Date  : {{leadData.created_at}}
                        </p> -->
                        </div>
                        <div class="column is-6" style="margin-top: 0">
                            <div class="columns is-mobile" style="margin-top: 0; margin-left: 0">
                                <div class="column is-6 sespo-icons-header" style="margin-left: 2rem;">
                                </div>
                                <div class="column is-6">
                                    <div class="is-12">
                                        
                                    </div>
                                    <div class="is-12">
                                        <a @click="website" title="Website"> <i class="fa fa-globe hintIcont"></i>
                                            <!--red point  -->
                                        </a>
                                        <a @click="HistoryLeadModel" title="History"> <i class="fa fa-history hintIcont"></i></a>
                                    </div>
                                    <div class="is-12">
                                        <a @click="LeadContact" title="Contacts"> <i class="fa fa-user-plus hintIcont"></i></a>
                                        <a @click="ContractsData"> <i class="fa fa-file-signature hintIcont"></i></a>
                                    </div>
                                    <!-- <i class=""></i><a @click="HistoryLeadModel">History</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-6">
                        
                        </div>
                        <div class="col-6">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div> -->
                </div>
                <nav class="level is-mobile">
                    <div class="level-left">
                    <a class="level-item" aria-label="reply">
                        <span class="icon is-small">
                            <i class="fa fa-phone hintIcont" aria-hidden="true" @click="showPhone = !showPhone"></i>

                        </span>
                    </a>
                    <a class="level-item" aria-label="reply"  v-if="showPhone">
                        <span><a :href="'tel:'+leadData.phone">{{leadData.phone}}</a></span>
                    </a>
                    <b-dropdown  class="level-item">
                        <i class="fa fa-envelope hintIcont" aria-hidden="true" slot="trigger"></i>
                        <b-dropdown-item custom paddingless>
                                <div class="modal-card" style="width:300px;">
                                    <header class="card-header">
                                        <p class="card-header-title">
                                            Send CIL Request
                                        </p>
                                    </header>
                                    <section class="modal-card-body">
                                        <div class="field">
                                            <label class="label">Developer</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="cilData.dev" @change="getDevPro">
                                                        <option v-for="dev in developers" :key="dev.id" :value="dev.id">{{dev.en_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="label">Project</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="cilData.project">
                                                        <option v-for="devPro in devProjects" :key="devPro.id" :value="devPro.id">{{devPro.en_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!--<div class="field">
                                            <label class="label">File</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="todo.to_do_type">
                                                        <option value="call">Call</option>
                                                        <option value="meeting">Meeting</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->

                                    </section>
                                    <footer class="modal-card-foot">
                                        <button class="button is-link" @click="addNewCILRequest">Send</button>
                                    </footer>
                                </div>
                        </b-dropdown-item>
                    </b-dropdown>
                    <b-dropdown  class="level-item">
                        <i class="fa fa-bell hintIcont" aria-hidden="true" slot="trigger"></i>
                        <b-dropdown-item custom paddingless>
                                <div class="modal-card" style="width:300px;">
                                    <header class="card-header">
                                        <p class="card-header-title">
                                            Add To Do
                                        </p>
                                    </header>
                                    <section class="modal-card-body">
                                         <div class="field">
                                            <label class="label">To-Do Type</label>
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select v-model="todo.to_do_type">
                                                        <option value="call">Call</option>
                                                        <option value="meeting">Meeting</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <b-field label="Due Date">
                                                <datetime
                                                type="datetime"
                                                v-model="todo.to_do_due_date"
                                                input-class="input"
                                                value-zone="Africa/Cairo"
                                                zone="Africa/Cairo"
                                                :phrases="{ok: 'Confirm', cancel: 'Cancel'}"
                                                format="yyyy-MM-dd HH:mm:ss"
                                                :hour-step="1"
                                                :minute-step="1"
                                                :week-start="7"
                                                use12-hour
                                                auto
                                                ></datetime>
                                            </b-field>
                                        </div>

                                        <div class="field">
                                            <label class="label">Description</label>
                                            <div class="control">
                                                <textarea class="textarea" placeholder="" v-model="todo.to_do_description"></textarea>
                                            </div>
                                        </div>

                                    </section>
                                    <footer class="modal-card-foot">
                                        <button class="button is-link" @click="addNewToDo">Save</button>
                                    </footer>
                                </div>
                        </b-dropdown-item>
                    </b-dropdown>

                    </div>
                </nav>
                <div style="width: fit-content; position: absolute; right: 6%; bottom: 13%; font-size: 25px;">
                    <i class="fa fa-star" id="fav" aria-hidden="true" @click="changeLeadStatus('fav',hintId)"></i>
                    <!-- <i class="fa fa-star" aria-hidden="true"  v-else @click="changeLeadStatus('fav',hintId)"></i> -->
                    <!-- <i class="fa fa-fire" aria-hidden="true"  style="color: #caa42d" v-if="Number(hot)" @click="changeLeadStatus('hot',hintId)"></i> -->
                    <i class="fa fa-fire" id="hot" aria-hidden="true" @click="changeLeadStatus('hot',hintId)"></i>
                </div>
                </div>
            </article>
        </div>
        <div class="columns is-multiline is-mobile">
            <div class="column is-10">
                <multiselect :disabled="disabled" :close-on-select="false" v-model="selectedTags"  tag-placeholder="Add this as new tag" placeholder="Select Tags" label="en_name" track-by="id" value="id" :options="hintTags" :multiple="true" :taggable="true" style="z-index: 1000000000;"></multiselect>
            </div>
            <div class="column is-1">
                <i style="color: #724a03; font-size: 1.5rem; cursor: pointer" id="editTag" class="fas fa-edit" @click="editTags"></i>
                <i style="color: #724a03; font-size: 1.5rem; cursor: pointer; display: none" id="saveTag" class="fas fa-save" @click="storeMultipleTags"></i>
            </div>
            <div class="column is-1">
                <i style="color: #724a03; font-size: 1.5rem; cursor: pointer; display: none" id="ignoreSaveTag" class="fas fa-ban" @click="ignoreSaveTags"></i>
            </div>

        </div>
        <section>
            <b-tabs v-model="activeTab" position="is-centered" class="block">
                <b-tab-item label="Information" v-if="leadData">
                    <div class="mb-20">
                        <h3>{{ $t('header.Notes') }} :</h3>
                        <p>{{leadData.lead_note}}</p>
                        <h3>{{ $t('header.agent') }}</h3>
                        <ul v-if="leadData.r_agent && leadData.r_agent.name != null">
                            <li><strong>Name:</strong> {{leadData.r_agent.name}}</li>
                            <li><strong>Position:</strong> {{leadData.r_agent.type}}</li>
                            <li><strong>Type:</strong> {{leadData.r_agent.residential_commercial}}</li>
                        </ul>
                        <ul v-if="leadData.c_agent && leadData.c_agent.name != null">
                            <li><strong>Name:</strong> {{leadData.c_agent.name}}</li>
                            <li><strong>Position:</strong> {{leadData.c_agent.type}}</li>
                            <li><strong>Type:</strong> {{leadData.c_agent.residential_commercial}}</li>
                        </ul>
                    </div>
                    <div v-if="leadData.calls">
                        <h3>Statistics and Logs</h3>

                        <b-tabs class="block" expanded type="is-toggle">
                            <b-tab-item label="Calls">
                                <div class="card" v-for="call in leadData.calls" :key="call.id" v-if="leadData.calls.length > 0">
                                    <div class="card-content">
                                        <ul>
                                            <li>
                                                <a @click="ShowEditCallsModel"> Edit Call </a>
                                                <!-- <a :href="'/admin/calls/'+call.id+'/edit'">Edit Call: {{call.id}}</a> -->
                                            </li>
                                            <li><strong>Call Status:</strong> {{call.call_status.name}}</li>
                                            <li><strong>Budget:</strong> {{call.budget}}</li>
                                            <li><strong>Project:</strong>
                                                <span v-for="project in call.project">
                                                    {{ project.en_name }}
                                                    {{project.id == call.project[call.project.length - 1 ].id ? '' : '---' }}
                                                </span>
                                            </li>
                                            <li><strong>Probability:</strong> {{call.probability.charAt(0).toUpperCase() + call.probability.slice(1) }}</li>
                                            <li><strong>Date:</strong> {{call.created_at}}</li>
                                            <li><strong>description:</strong> {{call.description}}</li>
                                            <li><strong>Called By:</strong> {{call.user.name}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="notification" v-if="leadData.calls.length == 0">
                                    No Calls Added
                                </div>
                            </b-tab-item>
                            <b-tab-item label="Meetings">
                                <div class="card" v-for="meeting in leadData.meetings" :key="meeting.id" v-if="leadData.meetings.length > 0">
                                    <div class="card-content">
                                        <ul>
                                            <li><strong>Budget:</strong> {{meeting.budget}}</li>
                                            <li><strong>Project:</strong>
                                                <span v-for="project in meeting.project">
                                                    {{ project.en_name }}
                                                    {{project.id == meeting.project[meeting.project.length - 1 ].id ? '' : '---' }}
                                                </span>
                                            </li>
                                            <li><strong>Probability:</strong> {{meeting.probability.charAt(0).toUpperCase() + meeting.probability.slice(1) }}</li>
                                            <li><strong>Date:</strong> {{meeting.created_at}}</li>
                                            <li><strong>description:</strong> {{meeting.description}}</li>
                                            <li><strong>Met By:</strong> {{meeting.user.name}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="notification" v-if="leadData.meetings.length == 0">
                                    No Meetings Added
                                </div>
                            </b-tab-item>
                            <b-tab-item label="Voice Notes">
                                <div class="card" v-for="voiceNote in leadData.voice_notes" :key="voiceNote.id" v-if="leadData.voice_notes.length > 0">
                                    <div class="card-content">
                                        <ul>
                                            <li><strong>Date/Time:</strong> {{voiceNote.created_at}}</li>
                                            <li><strong>Duration:</strong> {{voiceNote.duration}}</li>
                                            <li><strong>Location:</strong> {{voiceNote.location}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="notification" v-if="leadData.voice_notes.length == 0">
                                    No Voice Notes Added
                                </div>
                            </b-tab-item>
                            <b-tab-item label="Notes">
                                <div class="card" v-for="note in leadData.notes" :key="note.id" v-if="leadData.notes.length > 0">
                                    <div class="card-content">
                                        <ul>
                                            <li><strong>Date:</strong> {{note.date}}</li>
                                            <li><strong>Note:</strong> {{note.note}}</li>
                                            <li><strong>By:</strong> {{note.user_name}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="notification" v-if="leadData.notes.length == 0">
                                    No Notes Added
                                </div>
                            </b-tab-item>
                        </b-tabs>
                    </div>



                    <!--<ul v-if="leadData.calls">
                        <li><strong>Calls:</strong> {{leadData.calls.length}}</li>
                        <li><strong>Meetings:</strong> {{leadData.meetings.length}}</li>
                        <li><strong>Voice Notes:</strong> {{leadData.voice_notes.length}}</li>
                        <li><strong>Notes:</strong> {{leadData.notes.length}}</li>
                        <li><strong>Requests:</strong> {{leadData.requests.length}}</li>
                    </ul>-->
                </b-tab-item>

                <b-tab-item label="Actions">
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
                                                    <option value="0" selected>Lead</option>
                                                    <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{contact.name}}</option>
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
                                                    <option :value="leadData.phone" selected>{{leadData.phone}}</option>
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
                                                    <option v-for="status in callStatus" :key="status.id" :value="status.id">{{status.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Date">
                                            <b-datepicker
                                                placeholder="Click to select..."
                                                :date-formatter="dateFormatter"
                                                 position="is-bottom-left" v-model="newCallData.date">
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
                                                        <label class="label">To-Do Type</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select v-model="newCallData.to_do_type">
                                                                    <option value="call">Call</option>
                                                                    <option value="meeting">Meeting</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <b-field label="Due Date">
                                                            <datetime
                                                            type="datetime"
                                                            v-model="newCallData.to_do_due_date"
                                                            input-class="input"
                                                            value-zone="Africa/Cairo"
                                                            zone="Africa/Cairo"
                                                            :phrases="{ok: 'Confirm', cancel: 'Cancel'}"
                                                            format="yyyy-MM-dd HH:mm:ss"
                                                            :hour-step="1"
                                                            :minute-step="1"
                                                            :week-start="7"
                                                            use12-hour
                                                            auto
                                                            ></datetime>
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
                                                        <label class="label">Description</label>
                                                        <div class="control">
                                                            <textarea class="textarea" placeholder="" v-model="newCallData.to_do_description"></textarea>
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
                                            <b-input v-model="newCallData.duration"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="column is-6">
                                    <div class="field">
                                        <label class="label">Probability</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="newCallData.probability">
                                                    <option value="Follow Up">Follow Up</option>
                                                    <option value="On going">On going</option>
                                                    <option value="Expected Closing">Expected Closing</option>
                                                    <option value="Closed">Closed</option>
                                                    <option value="Rotation">Rotation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Budget">
                                            <b-input v-model="newCallData.budget"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <label class="label">Location</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="newCallData.location" @change="selectEvent">
                                                    <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
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
                                                <multiselect :close-on-select="false" v-model="newCallData.projects"  tag-placeholder="Add this as new tag" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="options" :multiple="true" :taggable="true"></multiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-12" style="margin-top: 25px;">
                                    <div class="field">
                                        <label class="label">Description</label>
                                        <div class="control">
                                            <textarea class="textarea" placeholder="" v-model="newCallData.description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <div class="control">
                                        <button class="button is-link mr-10" @click="addNewCall">Submit</button>
                                        <a class="button is-danger is-meduim mr-10" v-if="showDueCard" @click="showDueCard = !showDueCard">Remove Next Actions</a>
                                        <a class="button is-success is-meduim mr-10" v-else  @click="showDueCard = !showDueCard">Next Actions</a>
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
                                                    <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{contact.name}}</option>
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
                                                    <option v-for="status in meetingStatus" :key="status.id" :value="status.id">{{status.name}}</option>
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
                                                        <label class="label">To-Do Type</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select v-model="newMeetingData.to_do_type">
                                                                    <option value="call">Call</option>
                                                                    <option value="meeting">Meeting</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <b-field label="Due Date">
                                                            <datetime
                                                            type="datetime"
                                                            v-model="newMeetingData.to_do_due_date"
                                                            input-class="input"
                                                            value-zone="Africa/Cairo"
                                                            zone="Africa/Cairo"
                                                            :phrases="{ok: 'Confirm', cancel: 'Cancel'}"
                                                            format="yyyy-MM-dd HH:mm:ss"
                                                            :hour-step="1"
                                                            :minute-step="1"
                                                            :week-start="7"
                                                            use12-hour
                                                            auto
                                                            ></datetime>
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
                                                        <label class="label">Description</label>
                                                        <div class="control">
                                                            <textarea class="textarea" placeholder="" v-model="newMeetingData.to_do_description"></textarea>
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
                                            <b-input v-model="newMeetingData.duration"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Date">
                                            <b-datepicker
                                                placeholder="Click to select..."
                                                :date-formatter="dateFormatter"
                                                position="is-bottom-left" v-model="newMeetingData.date">
                                            </b-datepicker>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Time">
                                            <b-timepicker
                                                placeholder="Select Time"
                                                :hour-format="format" v-model="newMeetingData.time" :time-formatter="timeFormater">
                                            </b-timepicker>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="column is-6">
                                    <div class="field">
                                        <label class="label">Probability</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="newMeetingData.probability">
                                                    <option value="Follow Up">Follow Up</option>
                                                    <option value="On going">On going</option>
                                                    <option value="Expected Closing">Expected Closing</option>
                                                    <option value="Closed">Closed</option>
                                                    <option value="Rotation">Rotation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Budget">
                                            <b-input v-model="newMeetingData.budget"></b-input>
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
                                                <select v-model="newMeetingData.location" @change="selectEvent">
                                                    <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
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
                                                <multiselect :close-on-select="false" v-model="newMeetingData.projects"  tag-placeholder="Add this as new tag" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="options" :multiple="true" :taggable="true"></multiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <div class="field">
                                        <label class="label">Description</label>
                                        <div class="control">
                                            <textarea class="textarea" placeholder="" v-model="newMeetingData.description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <div class="control">
                                        <button class="button is-link mr-10" @click="addNewMeeting">Submit</button>
                                        <a class="button is-danger is-meduim mr-10" v-if="showDueCard" @click="showDueCard = !showDueCard">Remove Next Actions</a>
                                        <a class="button is-success is-meduim mr-10" v-else  @click="showDueCard = !showDueCard">Next Actions</a>
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
                                                <select v-model="newRequestData.buyer_seller">
                                                    <option value="buyer">Buyer</option>
                                                    <option value="seller">Seller</option>
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
                                                <select v-model="newRequestData.location" @change="selectEvent">
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
                                            <div class="is-fullwidth">
                                                <!-- <select v-model="newRequestData.projects" multiple>
                                                    <option v-for="project in projects" v-if="newRequestData.location == project.location_id" :key="project.id" :value="project.id">{{project.en_name}}</option>
                                                </select> -->
                                                <multiselect :close-on-select="false" v-model="newRequestData.projects"  tag-placeholder="Add this as new tag" placeholder="Select Projects" label="en_name" track-by="id" value="id" :options="options" :multiple="true" :taggable="true" style="z-index: 1000000000;"></multiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <label class="label">Type</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select v-model="newRequestData.unit_type" @change="unitsTypes">
                                                    <option value="commercial">Commercial</option>
                                                    <option value="residential">Residential</option>
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
                                                <select v-model="newRequestData.unit_type_id">
                                                    <option :value="type.id" v-for="type in unitTypes" :key="type.id">{{type.en_name}}</option>
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
                                                    <option value="resale">Resale</option>
                                                    <option value="rental">Rental</option>
                                                    <option value="new_home">New Home</option>
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
                                                        <b-input v-model="newRequestData.bathrooms_from"></b-input>
                                                    </b-field>
                                                </div>
                                                <div class="column is-6">
                                                    <b-field label="Bathrooms To">
                                                        <b-input v-model="newRequestData.bathrooms_to"></b-input>
                                                    </b-field>
                                                </div>
                                                <div class="column is-6">
                                                    <b-field label="Rooms From">
                                                        <b-input v-model="newRequestData.rooms_from"></b-input>
                                                    </b-field>
                                                </div>
                                                <div class="column is-6">
                                                    <b-field label="Rooms To">
                                                        <b-input v-model="newRequestData.rooms_to"></b-input>
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
                                            <b-input v-model="newRequestData.price_from"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Price To">
                                            <b-input v-model="newRequestData.price_to"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Area From">
                                            <b-input v-model="newRequestData.area_from"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <b-field label="Area To">
                                            <b-input v-model="newRequestData.area_to"></b-input>
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
                                            <b-input v-model="newRequestData.down_payment"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <div class="field">
                                        <label class="label">Notes</label>
                                        <div class="control">
                                            <textarea class="textarea" placeholder="" v-model="newRequestData.notes"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <div class="control">
                                        <button class="button is-link mr-10" @click="addNewRequest">Submit</button>
                                        <button class="button is-success is-meduim mr-10" @click="getSuggestionsNew">Suggestions</button>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <!-- <div v-html="suggestions" id="suggestions"></div> -->
                                    <div id="suggestions">
                                        <b-table
                                            v-if="suggestionsActive == true"
                                            :data="units"
                                            bordered
                                            checkable
                                            narrowed
                                            hoverable
                                            :checked-rows.sync="selectedSuggestions"
                                        >
                                            <template slot-scope="props">
                                                <b-table-column field="id" label="ID" sortable>
                                                    {{props.row.id}}
                                                </b-table-column>
                                                <b-table-column v-if="suggestions_request_type == 'new_home'" field="meter_price" label="Price / Meter" sortable>
                                                    {{props.row.meter_price}}
                                                </b-table-column>
                                                <b-table-column v-if="suggestions_request_type == 'resale'" field="price" label="Price" sortable>
                                                    {{props.row.price}}
                                                </b-table-column>
                                                <b-table-column v-if="suggestions_request_type == 'rental'" field="value_of_rent" label="Value Of Rent" sortable>
                                                    {{props.row.value_of_rent}}
                                                </b-table-column>
                                                <b-table-column field="area" label="Area" sortable>
                                                    {{props.row.area}}
                                                </b-table-column>
                                                <b-table-column v-if="suggestions_request_type == 'new_home'" field="en_name" label="Name" sortable>
                                                    {{props.row.en_name}}
                                                </b-table-column>
                                                <b-table-column v-if="suggestions_request_type != 'new_home'" field="title" label="Title" sortable>
                                                    {{props.row.en_title}}
                                                </b-table-column>
                                            </template>    
                                        </b-table>
                                    </div>
                                    
                                    <button v-if="suggestionsActive == true" class="button is-success is-meduim mr-10" @click="addSuggestions">Add Suggestions</button>
                                </div>

                            </div>
                        </b-tab-item>
                        <b-tab-item label="Add Note">
                            <div class="columns is-multiline is-mobile">


                                <div class="column is-12">
                                    <div class="field">
                                        <label class="label">Note</label>
                                        <div class="control">
                                            <textarea class="textarea" placeholder="" v-model="newNote"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-12">
                                    <div class="control">
                                        <button class="button is-link mr-10" @click="addNewNote">Add</button>
                                    </div>
                                </div>


                            </div>
                        </b-tab-item>
                        <b-tab-item label="Add Unit">
                            <div class="columns is-multiline is-mobile">
                                <createUnitHintSection :hintLeadData="leadData"/>
                                <!-- <div class="column is-12">
                                    <div class="control">
                                        <button class="button is-link mr-10" @click="addNewNote">Add</button>
                                    </div>
                                </div> -->


                            </div>
                        </b-tab-item>
                        </b-tabs>
                    </section>
                </b-tab-item>

                <b-tab-item label="Requests">
                    <div v-if="leadData.requests">
                        <nav class="panel" v-if="leadData.requests.length > 0"  v-for="(req,i) in leadData.requests" :key="req.id">
                            <p class="panel-heading">
                                Request {{i+1}}
                            </p>

                            <div class="panel-block">
                                <ul>
                                    <li><strong>Date:</strong> {{req.created_at}}</li>
                                    <li><strong>Location:</strong> {{req.loc ? req.loc.en_name : ''}}</li>
                                    <li><strong>Time from:</strong>{{req.contact_time_from}} : <strong>To:</strong> {{req.contact_time_to}}</li>
                                    <li><strong>Down Payment:</strong> {{req.down_payment}}</li>
                                    <li><strong>Price from:</strong> {{req.price_from}} <strong>To:</strong>{{req.price_to}}</li>
                                    <li><strong>Unit Type:</strong> {{req.unittype ? req.unittype.en_name : ''}}</li>
                                    <li><strong>Project:</strong>
                                        <span v-for="project in req.project">
                                            {{ project.en_name }}
                                            {{project.id == req.project[req.project.length - 1 ].id ? '' : '---' }}
                                        </span>
                                    </li> <!-- {{req.project ? req.project.en_name : ''}} -->
                                    <li><strong>Area from:</strong> {{req.area_from}} <strong>To:</strong> {{req.area_to}}</li>
                                    <li><strong>Requested By:</strong> {{(req.user || {}).name}}</li>
                                    <li><strong>Note:</strong> {{req.notes}}</li>
                                </ul>
                            </div>
                        </nav>
                        <div class="notification" v-if="leadData.requests.length == 0">
                            No Requests Added
                        </div>
                    </div>

                </b-tab-item>
                <b-tab-item label="Suggested Units">
                    <section>
                        <b-tabs v-model="activeTabActions" position="is-centered" class="block">
                            <b-tab-item label="Resale">
                                    <div class="column is-12">
                                        <b-table
                                        v-if="leadResaleSuggestions.length > 0"   
                                        :data="leadResaleSuggestions"
                                        bordered
                                        narrowed
                                        hoverable
                                        :default-sort-direction="defaultSortDirection"
                                        default-sort="price"
                                        >
                                            <template slot-scope="props">
                                                <b-table-column field="id" label="ID" sortable>
                                                    {{props.row.id}}
                                                </b-table-column>
                                                <b-table-column field="title" label="Title" sortable>
                                                    {{props.row.title}}
                                                </b-table-column>
                                                <b-table-column field="price" label="Price" sortable>
                                                    {{props.row.price}}
                                                </b-table-column>
                                                <b-table-column field="area" label="Area" sortable>
                                                    {{props.row.area}}
                                                </b-table-column>
                                                <b-table-column field="location" label="Location" sortable>
                                                    {{props.row.location}}
                                                </b-table-column>
                                                <b-table-column field="type" label="Type" sortable>
                                                    {{props.row.type}}
                                                </b-table-column>
                                            </template>    
                                        </b-table>
                                    </div>
                             </b-tab-item>
                            <b-tab-item label="Rental">
                                    <div class="column is-12">
                                        <b-table
                                        v-if="leadRentalSuggestions.length > 0"   
                                        :data="leadRentalSuggestions"
                                        bordered
                                        narrowed
                                        hoverable
                                        :default-sort-direction="defaultSortDirection"
                                        default-sort="price"
                                        >
                                            <template slot-scope="props">
                                                <b-table-column field="id" label="ID" sortable>
                                                    {{props.row.id}}
                                                </b-table-column>
                                                <b-table-column field="title" label="Title" sortable>
                                                    {{props.row.title}}
                                                </b-table-column>
                                                <b-table-column field="price" label="Price" sortable>
                                                    {{props.row.price}}
                                                </b-table-column>
                                                <b-table-column field="area" label="Area" sortable>
                                                    {{props.row.area}}
                                                </b-table-column>
                                                <b-table-column field="location" label="Location" sortable>
                                                    {{props.row.location}}
                                                </b-table-column>
                                                <b-table-column field="type" label="Type" sortable>
                                                    {{props.row.type}}
                                                </b-table-column>
                                            </template>    
                                        </b-table>
                                    </div>
                             </b-tab-item>
                             <b-tab-item label="New Home">
                                    <div class="column is-12">
                                        <b-table
                                        v-if="leadNewHomeSuggestions.length > 0"   
                                        :data="leadNewHomeSuggestions"
                                        bordered
                                        narrowed
                                        hoverable
                                        :default-sort-direction="defaultSortDirection"
                                        default-sort="price"
                                        >
                                            <template slot-scope="props">
                                                <b-table-column field="id" label="ID" sortable>
                                                    {{props.row.id}}
                                                </b-table-column>
                                                <b-table-column field="title" label="Title" sortable>
                                                    {{props.row.title}}
                                                </b-table-column>
                                                <b-table-column field="price" label="Price" sortable>
                                                    {{props.row.price}}
                                                </b-table-column>
                                                <b-table-column field="area" label="Area" sortable>
                                                    {{props.row.area}}
                                                </b-table-column>
                                                <b-table-column field="location" label="Location" sortable>
                                                    {{props.row.location}}
                                                </b-table-column>
                                                <b-table-column field="type" label="Type" sortable>
                                                    {{props.row.type}}
                                                </b-table-column>
                                            </template>    
                                        </b-table>
                                    </div>
                             </b-tab-item>
                             
                        </b-tabs>   
                    </section>
                </b-tab-item>
                <b-tab-item label="Owned Units">
                    <section>
                        <b-tabs v-model="activeTabActions" position="is-centered" class="block">
                            <b-tab-item label="Resale">
                                <div class="columns is-multiline is-mobile" v-for="resale in resales" :key="resale.id" v-if="resales.length > 0">
                                     <div class="column is-4">
                                        <img :src="'/'+resale.image" width="110px">
                                     </div>
                                     <div class="column is-8">
                                        <p style="margin-bottom:0.2rem;color:#000"> {{ resale.en_title }} </p>
                                        <small> {{ resale.project == null ? "" : resale.project.en_name }} </small>
                                        <p style="margin-bottom:0.2rem;color:#000"> {{ resale.location == null ? "" : resale.location.en_name }} </p>
                                        <div class="column is-12">
                                            <div class="column is-6">
                                                <p style="display:inline-block"> Price : {{ resale.price }} </p>
                                            </div>
                                            <div class="column is-6">
                                                <!-- <button style="background: #b07d12;" class="button is-link mr-10">View Unit</button> -->
                                                <router-link :to="'/admin/vue/showResaleUnit/'+resale.id" style="background: #b07d12;" class="button is-link mr-10">View Unit</router-link>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </b-tab-item>
                            <b-tab-item label="Rental">
                                <div class="columns is-multiline is-mobile" v-for="rental in rentals" :key="rental.id" v-if="rentals.length > 0">
                                    <div class="column is-4">
                                        <img :src="'/'+rental.image" width="110px">
                                     </div>
                                     <div class="column is-8">
                                        <p style="margin-bottom:0.2rem;color:#000"> {{ rental.en_title }} </p>
                                        <small> {{ rental.project == null ? "" : rental.project.en_name }} </small>
                                        <p style="margin-bottom:0.2rem;color:#000"> {{ rental.location == null ? "" : rental.location.en_name }} </p>
                                        <div class="column is-12">
                                            <div class="column is-6">
                                                <p style="display:inline-block"> Price : {{ rental.value_of_rent }} </p>
                                            </div>
                                            <div class="column is-6">
                                                <!-- <button style="background: #b07d12;" class="button is-link mr-10" @click="viewRentalUnit(rental.id)">View Unit</button> -->
                                                <router-link :to="'/admin/vue/showRentalUnit/'+rental.id" style="background: #b07d12;" class="button is-link mr-10">View Unit</router-link>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </b-tab-item>
                        </b-tabs>   
                    </section>
                </b-tab-item>  
            </b-tabs>
        </section>

<!-- // tabs website model -->
    <b-modal :active.sync="siteiconsmodel">
        <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
        </header>
        <section class="modal-card-body">
            <b-tabs type="is-toggle" v-model="activeTab2" expanded @change="testtabs">
                <b-tab-item label="Interest" icon="star">
            <section :active.sync="OpenInterest" class="modal-card-body">
                <table class="table">
                    <thead>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </thead>
                    <tbody>
                        <tr v-for="interest in InterestArray" :key="interest.id">
                            <td>{{ interest.type }}</td>
                            <td>{{ interest.name }}</td>
                            <td>{{ interest.created_at }}</td>
                            <td>{{ interest.time }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
                </b-tab-item>
                <b-tab-item label="Massege" icon="comment">
                    <section :active.sync="OpenMassegeData" class="modal-card-body">
                        <div class="container">
                            <table>
                                <thead>
                                    <tr class="text-center">
                                        <th>The massege : </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="massege in massegeArray" :key="massege.id">
                                        <td><textarea class="form-control" rows="5">{{ massege.massage }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </b-tab-item>
                <b-tab-item label="Favorite" icon="heart">
                    <section :active.sync="OpenFavorite" class="modal-card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="favorite in favoriteArray" :key="favorite">
                                    <td>{{ favorite.id }}</td>
                                    <td>{{ favorite.en_name }}</td>
                                    <td>{{ favorite.type }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </b-tab-item>
                <!-- request page -->
                <b-tab-item label="Requet page" icon="at">
                    <div class="modal-card" style="width: auto">
                    <section :active.sync="requestPage" class="modal-card-body">
                            <table class="table">
                                <thead>
                                    <th>id</th>
                                    <th>Location</th>
                                    <th>Unit type</th>
                                    <th>Created at</th>
                                </thead>
                                <tbody>
                                    <tr v-for="requestUnit in requestLeadArray" :key="requestUnit">
                                        <td>{{ requestUnit.id }}</td>
                                        <td>{{ requestUnit.location_name }}</td>
                                        <td>{{ requestUnit.unit_name }}</td>
                                        <td>{{ requestUnit.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </b-tab-item>
            </b-tabs>
            <!-- // model lead intrest -->
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="siteiconsmodel = false">Close</button>
          <!-- <button class="button is-info" @click="">Add</button> -->
        </footer>
      </div>
    </b-modal>

    <!-- tabs history model -->
    <b-modal :active.sync="leadhistorymodel">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
            </header>

            <section class="modal-card-body">
                <b-tabs type="is-toggle" v-model="activeTabsHistory" expanded @change="HistoryTabs">
                    <b-tab-item label="History" icon="history">
                        <section :active.sync="OpenHistory" class="modal-card-body">
                            <table class="table">
                                <thead>
                                    <th> Action </th>
                                    <th> title </th>
                                    <th>By</th>
                                    <th> Created at </th>
                                </thead>
                                <tbody>
                                    <tr v-for="history in AppendHistoryArray" :key="history.id">
                                        <td>{{ history.type }}</td>
                                        <td>{{ history.en_title }}</td>
                                        <td>{{ history.name }}</td>
                                        <td>{{ history.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </b-tab-item>
                    <b-tab-item label="Cils" icon="bookmark">
                        <section :active.sync="openclis" class="modal-card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Developer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cli in cilsArray" :key="cli.id">
                                        <td>{{ cli.en_name }}</td>
                                        <td>{{ cli.status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </b-tab-item>
                    <b-tab-item label="History switch" icon="arrows">
                        <section :active.sync="openHistorySwitch" class="modal-card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>To</th>
                                        <th>By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="switched in switchLeadArray" :key="switched.id">
                                        <td>{{ switched.id }}</td>
                                        <td>{{ switched.first_name }} {{ switched.last_name }}</td>
                                        <td>{{ switched.name }}</td>
                                        <td>{{ switched.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </b-tab-item>
                </b-tabs>

            </section>

            <footer class="modal-card-foot">
                <button class="button" type="button" @click="leadhistorymodel = false">Close</button>
            </footer>

        </div>
    </b-modal>


<!-- // model lead massege  -->
    <!-- <b-modal :active.sync="OpenMassegeData">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Massege</p>
          <i
            class="fas fa-plus-circle"
            @click=""
            style="font-size: 2rem;
        right: 2%;
        position: absolute;
        top: 15px;
        color: #6eb165;
        cursor: pointer;"
          ></i>
        </header>
        <section class="modal-card-body">
            <div class="container">
                <table>
                    <thead>
                        <tr class="text-center">
                            <th>The massege : </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="massege in massegeArray" :key="massege.id">
                            <td>{{ massege.massage }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="OpenMassegeData = false">Close</button>
        </footer>
      </div>
    </b-modal> -->
<!-- // model lead contract -->
    <b-modal :active.sync="OpenContracts">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Contracts</p>
          <i
            class="fas fa-plus-circle"
            @click=""
            style="font-size: 2rem;
        right: 2%;
        position: absolute;
        top: 15px;
        color: #6eb165;
        cursor: pointer;"
          ></i>
        </header>
        <section class="modal-card-body">
            <b-table class="table">
                <thead>
                    <th>Agent</th>
                    <th>Date</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <tr v-for="contract in AppendContractsData" :key="contract.id">
                        <td>{{ contract.name }}</td>
                        <td>{{ contract.created_at }}</td>
                        <td v-if="contract.status === 0"> Pending </td>
                        <td v-if="contract.status === 1"> Done </td>
                    </tr>
                </tbody>
            </b-table>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="OpenContracts = false">Close</button>
          <!-- <button class="button is-info" @click="">Add</button> -->
        </footer>
      </div>
    </b-modal>

    <!-- // lead come from request page -->
<!-- // model lead favorite -->
    <!-- <b-modal :active.sync="OpenFavorite">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Favorite</p>
          <i
            class="fas fa-plus-circle"
            @click=""
            style="font-size: 2rem;
        right: 2%;
        position: absolute;
        top: 15px;
        color: #6eb165;
        cursor: pointer;"
          ></i>
        </header>
        <section class="modal-card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Title</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="favorite in favoriteArray" :key="favorite">
                        <td>{{ favorite.id }}</td>
                        <td>{{ favorite.en_name }}</td>
                        <td>{{ favorite.type }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="OpenFavorite = false">Close</button>
        </footer>
      </div>
    </b-modal> -->
<!-- // model lead history -->
    <!-- <b-modal :active.sync="OpenHistory">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title"> History</p>
        </header>
        <section class="modal-card-body">
            <table class="table">
                <thead>
                    <th> Action </th>
                    <th> title </th>
                    <th>By</th>
                    <th> Created at </th>
                </thead>
                <tbody>
                    <tr v-for="history in AppendHistoryArray" :key="history.id">
                        <td>{{ history.type }}</td>
                        <td>{{ history.en_title }}</td>
                        <td>{{ history.name }}</td>
                        <td>{{ history.created_at }}</td>
                    </tr>
                </tbody>
                    
            </table>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="OpenHistory = false">Close</button>
        </footer>
      </div>
    </b-modal> -->
<!-- // model lead contact -->
    <b-modal :active.sync="OpenContact">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Contact</p>
          <i
            class="fas fa-plus-circle"
            @click="Addcontcatform"
            style="font-size: 2rem;
        right: 2%;
        position: absolute;
        top: 15px;
        color: #6eb165;
        cursor: pointer;"
          ></i>
        </header>
        <section class="modal-card-body">
            <b-collapse class="card" v-for="(data, index) in Contactform" :key="index">
              <div slot="trigger" class="card-header">
                <p class="card-header-title">New {{ index+1 }}</p>
                <i
                  class="fas fa-trash"
                  @click="removeAgenda(index)"
                  style="font-size: 22px; cursor: pointer; margin-right: 2%; margin-top: 1%"
                ></i>
              </div>
              <div class="card-content">
                <div class="content">
                  <div class="columns is-multiline is-mobile">
                    <div class="column is-6">
                      <b-field label="Contact name">
                        <b-input v-model="Contactform[index].name"></b-input>
                      </b-field>
                    </div>
                    <div class="column is-6">
                      <b-field label="Relation">
                        <b-input v-model="Contactform[index].relation"></b-input>
                      </b-field>
                    </div>
                    <div class="column is-6">
                      <div class="field">
                        <b-field label="Contact phone">
                          <b-input v-model="Contactform[index].phone"></b-input>
                        </b-field>
                      </div>
                    </div>
                    <div class="column is-6">
                      <div class="field">
                        <b-field label="Email">
                          <b-input v-model="Contactform[index].email"></b-input>
                        </b-field>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </b-collapse>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Relation</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="contact in AppendContactsData" :key="contact.id">
                        <td>{{ contact.id }}</td>
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.relation }}</td>
                        <td>{{ contact.email }}</td>
                        <td>{{ contact.phone }}</td>
                        <td>{{ contact.created_at }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="OpenContact = false">Close</button>
          <button class="button is-info" @click="AddNewContact">Add</button>
        </footer>
      </div>
    </b-modal>
<!-- // model lead cil history -->
    <!-- <b-modal :active.sync="openclis">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Cils</p>
          <i
            class="fas fa-plus-circle"
            @click=""
            style="font-size: 2rem;
        right: 2%;
        position: absolute;
        top: 15px;
        color: #6eb165;
        cursor: pointer;"
          ></i>
        </header>
        <section class="modal-card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Developer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cli in cilsArray" :key="cli.id">
                        <td>{{ cli.en_name }}</td>
                        <td>{{ cli.status }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="openclis = false">Close</button>
        </footer>
      </div>
    </b-modal> -->

    <!-- // model lead intrest -->
    <!-- <b-modal :active.sync="OpenInterest">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Interest</p>
          <i
            class="fas fa-plus-circle"
            @click=""
            style="font-size: 2rem;
        right: 2%;
        position: absolute;
        top: 15px;
        color: #6eb165;
        cursor: pointer;"
          ></i>
        </header>
        <section class="modal-card-body">
            <table class="table">
                <thead>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                </thead>
                <tbody>
                    <tr v-for="interest in InterestArray" :key="interest.id">
                        <td>{{ interest.type }}</td>
                        <td>{{ interest.name }}</td>
                        <td>{{ interest.created_at }}</td>
                        <td>{{ interest.time }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isAgendaModalActive = false">Close</button>
          <button class="button is-info" @click="">Add</button>
        </footer>
      </div>
    </b-modal> -->

<b-modal :active.sync="EditCallsModel">
    <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Edit Calls</p>
        </header>
        <section class="modal-card-body">
            <div class="container">
                <div class="row">
                    <b-field label="Lead">
                        <b-input v-model="Leadinfoedit.first_name"></b-input>
                    </b-field>
                    <b-field label="phone">
                        <b-input v-model="Leadinfoedit.phone"></b-input>
                    </b-field>
                    <b-field label="Duration">
                        <b-input v-model="Leadinfoedit.duration"></b-input>
                    </b-field>
                    <b-field label="Simple">
                        <!-- <b-select placeholder="Select a name">
                            <option
                                v-for="option in StatusName"
                                :v-if="option.name == Leadinfoedit.status_name"
                                :value="option.id"
                                :key="option.id"
                                v-bind="option.id"
                                >
                                {{ option.name }}
                            </option>
                        </b-select> -->
                    </b-field>
                    <b-field label="Call Status">
                         <b-select expanded v-model="Leadinfoedit.status_name">
                            <option v-for="call in callStatus" :value="call.id">
                                {{ call.name}}
                            </option>
                        </b-select>
                        <!-- <b-input v-model="Leadinfoedit.status_name"></b-input> -->
                    </b-field>
                    <b-field label="date">
                        <b-datepicker
                            placeholder="Click to select..."
                            icon="calendar-today"
                            :date-formatter="dateFormatterFrom"
                            v-model="Leadinfoedit.created_at"
                            >
                        </b-datepicker>
                    </b-field>
                    <b-field label="Probability">
                        <b-select  v-model="Leadinfoedit.probability" expanded>
                                <option value="Follow Up">Follow Up</option>
                                <option value="On going">On going</option>
                                <option value="Expected Closing">Expected Closing</option>
                                <option value="Closed">Closed</option>
                                <option value="Rotation">Rotation</option>
                         </b-select>
                    </b-field>
                    <b-field label="Projects">
                        <!-- <b-input v-model="Projects"></b-input> -->
                        <b-select expanded v-model="Leadinfoedit.project_id">
                            <option v-for="project in projects" :value="project.id">
                                {{ project.en_name}}
                            </option>
                        </b-select>
                    </b-field>
                    <b-field label="Description">
                        <b-input type="textarea" v-model="Leadinfoedit.description"></b-input>
                    </b-field>
                </div>
            </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="EditCallsModel = false">Close</button>
          <button class="button is-info" @click="EditLeadCall">Add</button>
        </footer>
      </div>
</b-modal>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>


</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>



import {editCalls,callstatus,GetleadInfo,GetleadSwitchHistory,Getcilslead,GetFavoriteLead,GetleadInterest,saveOtherContacts,GetLeadContacts,GetLeadContracts,GetleadHistory,GetLeadMassege,getLeadData,addCall,addMeeting,addRequest,addNote,getPublicData,getUnitTypes,addToDo,getDevProjects,addCILRequest,getLeadSources,getSuggestionsNew,changeLeadFav,changeLeadHot,getOwnedUnits,getHintTags,storeMultipleTags,addSuggestions,getLeadSuggestions,convertLeadCC,FromrequestPage} from './../../calls'

import Multiselect from 'vue-multiselect'
import createUnitHintSection from "../Resale/createUnitHintSection";
// import Create from "../Resale/Create";
  // register globally
  // Vue.component('multiselect', Multiselect)

export default {
    components: { Multiselect ,
        createUnitHintSection : createUnitHintSection,
    },
    data(){
        return {
            activeTab2: 0,
            activeTabsHistory:0,
            EditCallsModel: false,
            OpenMassegeData: false,
            OpenInterest: false,
            OpenHistory: false,
            OpenContracts: false,
            requestPage: false,
            OpenFavorite: false,
            openclis:false,
            siteiconsmodel:false,
            leadhistorymodel:false,
            openHistorySwitch: false,
            AppendContractsData: [],
            leadID: null,
            AppendContactsData: [],
            AppendHistoryArray:[],
            Contactform: [],
            intrestArray:[],
            InterestArray:[],
            favoriteArray: [],
            switchLeadArray: [],
            massegeArray: [],
            cilsArray:[],
            OpenContact: false,
            activeTab: 0,
            activeTabActions: 0,
            leadData: {},
            contacts: [],
            isLoading: false,
            isFullPage:false,
            callStatus: [],
            projects: [],
            locations: [],
            developers: [],
            devProjects: [],
            meetingStatus:[],
            StatusName:[],
            Leadinfoedit:{
                first_name: null,
                phone: null,
                duration: null,
                status_name: null,
                probability: null,
                created_at: null,
                project_id:null,
                description:null
            },
            newCallData: {date: new Date()},
            newMeetingData: {date: new Date()},
            newRequestData: {},
            token: window.auth_user.csrf,
            userId: window.auth_user.id,
            phone_in_out : 'out',
            call_status_id : '',
            meeting_status_id : '',
            request_type: '',
            showDueCard: false,
            formatAmPm: true,
            newNote: '',
            showPhone: false,
            unitTypes: [],
            todo: {},
            cilData: {},
            showFullDataCard: false,
            options: [],
            suggestions : '',
            disabled: true,
            resales: [],
            rentals: [],
            hintTags: [],
            selectedTags: [],
            defaultSortDirection: 'desc',
            units: [],
            selectedSuggestions: [],
            suggestionsActive: false,
            leadNewHomeSuggestions: [],
            leadResaleSuggestions: [],
            leadRentalSuggestions: [],
            suggestions_request_type: '',
            requestLeadArray: [],
        }
    },
    props: {
        sideView: {
            type: Boolean,
        },
        hintId: null,
        fav: null,
        hot: null,
        flag: null,
        tab: ''
    },
    updated() {
        if(this.leadData.favorite == 1){
                document.getElementById("fav").style.color = "#caa42d"
        }else{
                document.getElementById("fav").style.color = "unset"
        }
        if(this.leadData.hot == 1){
                document.getElementById("hot").style.color = "#caa42d"
        }else{
                document.getElementById("hot").style.color = "unset"
        }
    },
    watch: {
        'hintId': function(newId, oldId) {
            console.log(this.hintId)
            this.getData()
        },
        'call_status_id': function(newId, oldId) {
            this.showDue('call')
        },
        'meeting_status_id': function(newId, oldId) {
            this.showDue('meeting')
        },
        'request_type': function(newId, oldId) {
            if(newId == 'resale' || newId == 'rental'){
                this.showFullDataCard = true
            }else this.showFullDataCard = false
        },
        'fav': function() {
            this.getData();
        },
        'flag': function() {
            this.getData();
        }
    },
    computed: {
        format() {
            return this.formatAmPm ? '12' : '24'
        }
    },
    methods: {
        changeLeadStatus(type,id){
                if(type == 'fav'){
                    changeLeadFav({id:id}).then(response=>{
                        console.log(response)
                        if(this.leadData.favorite == 1){
                            document.getElementById("fav").style.color = "#caa42d"
                        }else
                            document.getElementById("fav").style.color = "unset"
                        
                        this.getData()
                        this.$emit("changeHint", null)
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }else if (type == 'hot'){
                    changeLeadHot({id:id}).then(response=>{
                        console.log(response)
                        if(this.leadData.hot == 1){
                            document.getElementById("hot").style.color = "#caa42d"
                        }else
                            document.getElementById("hot").style.color = "unset"
                        this.getData()
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
        selectEvent(){
            console.clear()
            let payload = [];
            this.projects.map(project=>{
                if (this.newCallData.location == project.location_id)
                    payload.push(project);
                if (this.newMeetingData.location == project.location_id)
                    payload.push(project);
                if (this.newRequestData.location == project.location_id)
                    payload.push(project);
            });
            this.options = payload;
        },
        getData(){
            this.isLoading = true
            getLeadData(this.hintId).then(response=>{
                console.log(response)
                this.leadData = response.data.lead
                this.contacts = response.data.contacts
                this.newCallData.contact_id = 0
                this.newMeetingData.contact_id = 0
                this.newCallData.phone = this.leadData.phone
                this.selectedTags = response.data.lead.tags
                /*if(this.contacts.length > 0){
                    this.newCallData.contact_id = this.contacts[0].id
                }*/
                this.getHintTags()
                this.getOwnedUnits()
                this.getLeadSuggestions()
                this.isLoading = false
                this.getPublic()
                if(response.data.lead.status === "not_seen")
                this.$emit("changeHint", null)
            })
            .catch(error => {
                console.log(error)
            })
        },
        getShortName(){
            return this.leadData.first_name.charAt(0)+this.leadData.last_name.charAt(0)
        },
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
        getDevPro(event){
            getDevProjects(event.target.value).then(response=>{
                console.log(response)
                this.devProjects = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        unitsTypes(event){
            var usage = event.target.value
            getUnitTypes({usage: usage, _token: this.token}).then(response=>{
                console.log(response)
                this.unitTypes = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewToDo(){
            this.isLoading = true
            var data = {
                "_token": this.token,
                "user_id": this.userId,
                'leads': this.leadData.id,
                "to_do_type": this.todo.to_do_type,
                "due_date": this.todo.to_do_due_date,
                "description": this.todo.to_do_description,
            };
            console.log(data)
            addToDo(data).then(response=>{
                console.log(response)
                if(response.data.status == 501){
                    this.error('To Do')
                    this.isLoading = false
                }else {
                    //this.isLoading = false
                    this.newCallData = {}
                    this.call_status_id = 0
                    this.getData()
                    this.success('To Do')
                }

            })
            .catch(error => {
                console.log(error)
            })
        },
        addNewCall(){
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
                "probability": this.newCallData.probability ? this.newCallData.probability : 'Follow Up',
                "budget": this.newCallData.budget,
                "location_id": this.newCallData.location,
                "projects": this.mapProjects(this.newCallData.projects),
                "description": this.newCallData.description,
                "to_do_type": this.newCallData.to_do_type,
                "to_do_due_date": this.newCallData.to_do_due_date,
                "to_do_description": this.newCallData.to_do_description,
            };
            console.log(data)
            addCall(data).then(response=>{
                console.log(response)
                if(response.data.status == 501){
                    this.error('Call')
                    this.isLoading = false
                }else {
                    //this.isLoading = false
                    if(this.call_status_id == 6 && (this.tab == 'cold_calls' || this.tab == 'today_cold_calls')){
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
        addNewMeeting(){
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
                "probability": this.newMeetingData.probability ?  this.newMeetingData.probability : 'Follow Up',
                "budget": this.newMeetingData.budget,
                "projects":this.mapProjects(this.newMeetingData.projects),
                "description": this.newMeetingData.description,
                "to_do_type": this.newMeetingData.to_do_type,
                "to_do_due_date": this.newMeetingData.to_do_due_date,
                "to_do_description": this.newMeetingData.to_do_description,
            };
            console.log(data)
            addMeeting(data).then(response=>{
                console.log(response)
                console.log(response)
                if(response.data.status == 501){
                    this.error('Meeting')
                    this.isLoading = false
                }else {
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

        mapProjects(projects = [], id = null){
            let payload = [];
            projects.map(project=>{
                payload.push(project.id);
            });

            return payload;
        },
        Addcontcatform: function() {
        this.Contactform.push({
            name: null,
            relation: null,
            phone: null,
            email: null,
            jobtitle: null,
        });
        },

        addNewRequest(){
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
            addRequest(data).then(response=>{
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
        addNewNote(){
            this.isLoading = true
            var data = {
                lead_id: this.leadData.id,
                user_id: this.userId,
                note: this.newNote,
                _token: this.token

            };
            console.log(data)
            addNote(data).then(response=>{
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
        addNewCILRequest(){
            this.isLoading = true
            var data = {
                lead_id: this.leadData.id,
                developer: this.cilData.dev,
                project: this.cilData.project,
                _token: this.token

            };
            addCILRequest(data).then(response=>{
                console.log(response)
                //this.isLoading = false
                if(response.data.status == 501){
                    this.error('CIL Request')
                    this.isLoading = false
                }else {
                    this.isLoading = false
                    this.cilData = {}
                    this.success('CIL Request')
                }
            })
            .catch(error => {
                console.log(error)
            })
        },
        showDue(type){
            this.showDueCard = false
            if(type == 'call') {
                if(this.call_status_id){
                    this.callStatus.forEach(element => {
                        if(this.call_status_id == element.id){
                            if(element.has_next_action){
                                this.showDueCard = true
                                console.log(this.showDueCard)
                            }
                        }
                    });
                }
            }else if(type == 'meeting'){
                if(this.meeting_status_id){
                    this.meetingStatus.forEach(element => {
                        if(this.meeting_status_id == element.id){
                            if(element.has_next_action){
                                this.showDueCard = true
                                console.log(this.showDueCard)
                            }
                        }
                    });
                }
            }

        },
        dateFormatter(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.parsedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        dateFormatter2(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.to_do_due_date = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
        timeFormater(dt){
            var time = dt.toLocaleTimeString();
            this.time = time
            return time
        },
        sideClose() {
            this.sideView = false;
            this.$emit('closeSide', this.sideView);
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
        getSuggestionsNew(){
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
            if(data['project_id'].length > 0){
                if(data['request_type'] == "new_home"){
                    this.suggestionsActive = false
                    console.log("No Suggestions when there are projects selected")
                    return;
                }
            }
            console.log(data)
            this.suggestions_request_type = this.request_type    
            // $("#suggestions").html("");            
            getSuggestionsNew(data).then(response=>{
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
        getOwnedUnits(){
            getOwnedUnits(this.hintId).then(response=>{
                console.log(response)
                this.resales = response.data.resales
                this.rentals = response.data.rentals
            })
            .catch(error => {
                console.log(error)
            })
        },
        viewResaleUnit(id){
            console.log(id)
            window.location.href = '/admin/resale_units/' + id
        },
        viewRentalUnit(id){
            console.log(id)
            window.location.href = '/admin/rental_units/' + id
        },
        getHintTags(){
            getHintTags().then(response=>{
                console.log("Tags")
                console.log(response.data)
                this.hintTags = response.data
            })
        },
        storeMultipleTags(){
            let selected = []
            for(let i=0;i<this.selectedTags.length;i++){
                selected.push(this.selectedTags[i]['id']);
            }
            var data = {
                'lead_id': this.leadData.id,
                'selected_tags': selected
            };
            storeMultipleTags(data).then(response=>{
                console.log("Saved Tags")
                console.log(response.data)
                this.ignoreSaveTags();
            })
        },
        addSuggestions(){
            var data = {
                'lead_id': this.leadData.id,
                'selected_suggestions': this.selectedSuggestions,
                'request_type': this.request_type
            };
            addSuggestions(data).then(response=>{
                this.newRequestData = {}
                this.suggestionsActive = false
                this.request_type = ''
                this.$emit("changeHint", null)
                this.getData()
                this.success('Suggestions')
                console.log(response.data)
            })
        },
        getLeadSuggestions(){
            getLeadSuggestions(this.leadData.id).then(response=>{
                console.log(response.data)
                this.leadResaleSuggestions = response.data['resale_suggestions'];
                this.leadRentalSuggestions = response.data['rental_suggestions'];
                this.leadNewHomeSuggestions = response.data['new_home_suggestions'];
            })
        },
        editTags(){
            this.disabled = false
            document.getElementById('editTag').style.display = "none"
            document.getElementById('saveTag').style.display = "block"
            document.getElementById('ignoreSaveTag').style.display = "block"
        },
        ignoreSaveTags(){
            this.disabled = true
            document.getElementById('editTag').style.display = "block"
            document.getElementById('saveTag').style.display = "none"
            document.getElementById('ignoreSaveTag').style.display = "none"
        },
        // OpenMassegeData(){
        //     console.log("dataNewMassege")
        // },
        MassegeLead(){
            let data = this.leadData
            console.log("lead-Request",data)
            GetLeadMassege(data).then(response=>{
                this.massegeArray = response.data
                console.log(response)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenMassegeData = true;
        },
        convertLeadCC(){
            convertLeadCC(this.hintId).then(response=>{
                console.log("Lead Converted Successfully From cold calls")
            })
            .catch(error => {
                console.log(error)
            })
},
        HistoryLead(){
            let data = this.leadData
            console.log("lead-Request",data)
            GetleadHistory(data).then(response=>{
                console.log(response)
                this.AppendHistoryArray = response.data
                console.log('Lead-History',this.AppendHistoryArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenHistory = true;
        },
        ContractsData(){
            let data = this.leadData
            GetLeadContracts(data).then(response=>{
                console.log(response)
                this.AppendContractsData = response.data
                console.log('Lead-contracts',this.AppendContractsData)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenContracts = true;
        },
        getRequestPageData(){
            let data = this.leadData
            FromrequestPage(data).then(response=>{
                this.requestLeadArray = response.data
                console.log('Lead request from get function request',requestLeadArray)
            }).catch(error=>{
                console.log(error)
            })
        },
        saveContacts(){
        let lead_id = this.leadData.id
        const bodyFormData = new FormData();

        for (let key in this.Contactform) {
            const value = this.Contactform[key];
            bodyFormData.append(
            "data" + "[" + key + "]",
            JSON.stringify(this.Contactform[key])
            );
        }
            bodyFormData.append("lead_id", lead_id);

        saveOtherContacts(bodyFormData)
            .then(response => {
            console.log(response);
            this.isAgendaModalActive = false;
            // return true;
            })
            .catch(error => {
            console.log(error);
            });
            this.LeadContact()
        },
        AddNewContact(){
            this.saveContacts();
        },
        LeadContact(){
            let data = this.leadData
            GetLeadContacts(data).then(response=>{
                console.log(response)
                this.AppendContactsData = response.data
                console.log('Lead-Contacts',this.AppendContactsData)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenContact = true
        },
        LeadInterest(){
            console.log("taaaaaaaaaaaabs inter")
            let data = this.leadData
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
        favoriteLead(){
        let data = this.leadData
            GetFavoriteLead(data).then(response=>{
                console.log(response)
                this.favoriteArray = response.data
                console.log('Lead-intrest',this.favoriteArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.OpenFavorite = true
        },
        leadCils(){
            let data = this.leadData
            Getcilslead(data).then(response=>{
                console.log(response)
                this.cilsArray = response.data
                console.log('Lead-cils',this.cilsArray)
            })
            .catch(error => {
                console.log(error)
            })
            this.openclis = true
        },
        website(){
            this.siteiconsmodel = true
        },
        HistoryLeadModel(){
            this.leadhistorymodel = true
        },
        historySwitchLead(){
            let data = this.leadData
                GetleadSwitchHistory(data).then(response=>{
                    console.log(response)
                    this.switchLeadArray = response.data
                    console.log('Lead-switched',this.switchLeadArray)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        testtabs(value){
            if(value === 0){
                this.LeadInterest()
                console.log("tab of 0")
            }else if(value === 1){
                this.MassegeLead()
                console.log("tab of 1")
            }else if(value === 2){
                this.favoriteLead()
                console.log("tab of 2")
            }else if(value === 3){
                this.getRequestPageData()
                console.log("tab of 3")
            }
        },
        HistoryTabs(value){
            if(value === 0){
                this.HistoryLead()
                console.log("tab one is active")
            }else if(value === 1){
                this.leadCils()
                console.log("tab history cils")
            }else{
                this.historySwitchLead()
            }
        },
        getAllCallstatus(){
            callstatus().then(response=>{
                this.StatusName = response.data.data
                console.log('Call status',response)
            })
            .catch(error => {
                console.log(error)
            })
        },
        ShowEditCallsModel(){
            console.log("this edit calls")
            this.getAllCallstatus()
            let data = this.leadData
            GetleadInfo(data).then(response=>{
                console.log(response)
                this.leadID = response.data[0].lead_id
                this.Leadinfoedit.first_name = response.data[0].first_name
                this.Leadinfoedit.phone = response.data[0].phone
                this.Leadinfoedit.duration = response.data[0].duration
                this.Leadinfoedit.status_name = response.data[0].status_name
                this.Leadinfoedit.created_at = response.data[0].created_at
                this.Leadinfoedit.probability = response.data[0].probability
                // this.Leadinfoedit = response.data
                console.log('Lead-Lead edit',this.Leadinfoedit)
            })
            .catch(error => {
                console.log(error)
            })

            this.EditCallsModel = true
        },
        EditLeadCall(){
        const bodyFormData = new FormData();
            for (const key in this.Leadinfoedit) {
                const value = this.Leadinfoedit[key]
                bodyFormData.set(key, value)
                // bodyFormData.tagsID.push(this.value[i].id)
                // console.log('tags',this.value)
            }
        // bodyFormData.append('_method','put')
        bodyFormData.append("call_status_id",this.Leadinfoedit.status_name)
        bodyFormData.delete("status_name")
        bodyFormData.append("Lead_id",this.leadID)
        editCalls(bodyFormData)
        .then(response => {
        // this.responseStatus = response.status
        // if(response.status === 200)
        // this.isLoading = false
        // console.log("lead infoooo",response);
        // return true;
       $(location).attr('href', ' /admin/vue/MyLeads')

       
        })
        .catch(error => {
          console.log(error);
        });
        },
        dateFormatterFrom(dt){
            var date = dt.toLocaleDateString();
            const [month, day, year] = date.split('/')
            this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            return date
        },
    }
}


</script>
<style>
.multiselect__tag,
.multiselect__option--highlight{
    background: #b07d12 !important;
}

.multiselect__tag-icon:hover{
    background: #b07d12 !important;
}
@media only screen and (max-width: 800px) {
    .nameSpan{
        font-size:218%
    }
    .respo-header{
        margin-left:10px !important;
    }
    .respo-header h3{
        margin-top:1.5vw;
    }
    .sespo-icons-header{
        margin-left: 0 !important;
    }
    .level-left{
        margin-left: 10px
    }
}
</style>
