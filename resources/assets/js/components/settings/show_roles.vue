<template>
    <div class="container">
        <div class="card">
            <header class="card-header level ">
                <div class="level">
                    <div class="level-item">
                        <p class="card-header-title">
                            Edit roles
                        </p>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <section class="container tasks">
                <i style="float:right;color: #724a03; font-size: 1.5rem; cursor: pointer" id="editAgent" class="fas fa-edit" @click="toggleInputsActive"></i>
                    <b-field label="Disabled">
                        <b-input placeholder="Disabled" v-model="name" :disabled="disabled"></b-input>
                    </b-field>
                </section>
                <!-- begin data -->
                <div class="columns is-mobile">
                    <div class="column">
                        <!-- <div class="field column" v-for="(item , role) in nRole[0]" :key="item">
                            <b-switch v-if="item == 1" :disabled="disabled" :v-model="NewRole.role" value="1" true-value="1" false-value="0">
                                {{ role }}
                            </b-switch>
                            <b-switch v-if="item == 0" :disabled="disabled" :v-model="Newrole.role" value="0" true-value="1" false-value="0">
                                {{ role }}
                            </b-switch>
                        </div> -->
                        <div class="">
                            <div class="column is-2">
                                <b-field label="Add leads">
                                    <div class="field">
                                        <!-- <div v-for="(item,role) in nRole[0]" :key="role">
                                            <b-switch v-if="item == 1" v-model="nRole[0].role"  true-value="1" false-value="0">
                                                {{ role }}
                                            </b-switch>
                                            <b-switch v-if="item == 0" v-model="nRole[0].role"  true-value="0" false-value="1">
                                                {{ role }}
                                            </b-switch>
                                        </div> -->

                                        <!-- begin  -->
                                        <b-switch v-if="nRole[0].add_leads == 1" v-model="nRole[0].add_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].add_leads }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].add_leads }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="hard_delete_leads">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].hard_delete_leads == 1" v-model="nRole[0].hard_delete_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].hard_delete_leads }}
                                        </b-switch>
                                        <b-switch v-else  v-model="nRole[0].hard_delete_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].hard_delete_leads }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="soft_delete_leads">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].soft_delete_leads == 1" v-model="nRole[0].soft_delete_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].soft_delete_leads }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].soft_delete_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].soft_delete_leads }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="switch_leads">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].switch_leads == 1" v-model="nRole[0].switch_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].switch_leads }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].switch_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].switch_leads }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_leads">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_leads == 1" v-model="nRole[0].edit_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_leads }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_leads }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_all_leads">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_all_leads == 1" v-model="nRole[0].show_all_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].show_all_leads }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_all_leads"  true-value="1" false-value="0">
                                            {{ nRole[0].show_all_leads }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="send_cil">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].send_cil == 1" v-model="nRole[0].send_cil"  true-value="1" false-value="0">
                                            {{ nRole[0].send_cil }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].send_cil"  true-value="1" false-value="0">
                                            {{ nRole[0].send_cil }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="export_excel">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].export_excel == 1" v-model="nRole[0].export_excel"  true-value="1" false-value="0">
                                            {{ nRole[0].export_excel }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].export_excel"  true-value="1" false-value="0">
                                            {{ nRole[0].export_excel }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="calls">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].calls == 1" v-model="nRole[0].calls"  true-value="1" false-value="0">
                                            {{ nRole[0].calls }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].calls"  true-value="1" false-value="0">
                                            {{ nRole[0].calls }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="meetings">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].meetings == 1" v-model="nRole[0].meetings"  true-value="1" false-value="0">
                                            {{ nRole[0].meetings }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].meetings"  true-value="1" false-value="0">
                                            {{ nRole[0].meetings }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="requests">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].requests == 1" v-model="nRole[0].requests"  true-value="1" false-value="0">
                                            {{ nRole[0].requests }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].requests"  true-value="1" false-value="0">
                                            {{ nRole[0].requests }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_developers">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_developers == 1" v-model="nRole[0].add_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].add_developers }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].add_developers }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_developers">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_developers == 1" v-model="nRole[0].edit_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_developers }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_developers }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_developers">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_developers == 1" v-model="nRole[0].delete_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_developers }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_developers }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_developers">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_developers == 1" v-model="nRole[0].show_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].show_developers }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_developers"  true-value="1" false-value="0">
                                            {{ nRole[0].show_developers }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_projects">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_projects == 1" v-model="nRole[0].add_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].add_projects }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].add_projects }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_projects">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_projects == 1" v-model="nRole[0].edit_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_projects }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_projects }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_projects">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_projects == 1" v-model="nRole[0].delete_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_projects }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_projects }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_projects">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_projects == 1" v-model="nRole[0].show_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].show_projects }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_projects"  true-value="1" false-value="0">
                                            {{ nRole[0].show_projects }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_phases">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_phases == 1" v-model="nRole[0].add_phases"  true-value="1" false-value="0">
                                            {{ nRole[0].add_phases }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_phases"  true-value="1" false-value="0">
                                            {{ nRole[0].add_phases }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_phases">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_phases == 1" v-model="nRole[0].edit_phases"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_phases }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_phases"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_phases }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_phases">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_phases == 1" v-model="nRole[0].show_phases"  true-value="1" false-value="0">
                                            {{ nRole[0].show_phases }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_phases"  true-value="1" false-value="0">
                                            {{ nRole[0].show_phases }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_properties">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_properties == 1" v-model="nRole[0].add_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].add_properties }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].add_properties }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_properties">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_properties == 1" v-model="nRole[0].edit_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_properties }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_properties }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_properties">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_properties == 1" v-model="nRole[0].delete_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_properties }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_properties }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_properties">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_properties == 1" v-model="nRole[0].show_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].show_properties }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_properties"  true-value="1" false-value="0">
                                            {{ nRole[0].show_properties }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_resale_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_resale_units == 1" v-model="nRole[0].add_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].add_resale_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].add_resale_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_resale_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_resale_units == 1" v-model="nRole[0].edit_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_resale_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_resale_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_resale_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_resale_units == 1" v-model="nRole[0].delete_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_resale_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_resale_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_resale_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_resale_units == 1" v-model="nRole[0].show_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].show_resale_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_resale_units"  true-value="1" false-value="0">
                                            {{ nRole[0].show_resale_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_rental_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_rental_units == 1" v-model="nRole[0].add_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].add_rental_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].add_rental_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_rental_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_rental_units == 1" v-model="nRole[0].edit_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_rental_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_rental_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_rental_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_rental_units == 1" v-model="nRole[0].delete_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_rental_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_rental_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_rental_units">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_rental_units == 1" v-model="nRole[0].show_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].show_rental_units }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_rental_units"  true-value="1" false-value="0">
                                            {{ nRole[0].show_rental_units }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_lands">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_lands == 1" v-model="nRole[0].add_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].add_lands }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].add_lands }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_lands">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_lands == 1" v-model="nRole[0].edit_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_lands }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_lands }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_lands">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_lands == 1" v-model="nRole[0].delete_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_lands }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_lands }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_lands">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_lands == 1" v-model="nRole[0].show_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].show_lands }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_lands"  true-value="1" false-value="0">
                                            {{ nRole[0].show_lands }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="marketing">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].marketing == 1" v-model="nRole[0].marketing"  true-value="1" false-value="0">
                                            {{ nRole[0].marketing }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].marketing"  true-value="1" false-value="0">
                                            {{ nRole[0].marketing }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="proposals">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].proposals == 1" v-model="nRole[0].proposals"  true-value="1" false-value="0">
                                            {{ nRole[0].proposals }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].proposals"  true-value="1" false-value="0">
                                            {{ nRole[0].proposals }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="deals">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].deals == 1" v-model="nRole[0].deals"  true-value="1" false-value="0">
                                            {{ nRole[0].deals }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].deals"  true-value="1" false-value="0">
                                            {{ nRole[0].deals }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="finance">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].finance == 1" v-model="nRole[0].finance"  true-value="1" false-value="0">
                                            {{ nRole[0].finance }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].finance"  true-value="1" false-value="0">
                                            {{ nRole[0].finance }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="reports">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].reports == 1" v-model="nRole[0].reports"  true-value="1" false-value="0">
                                            {{ nRole[0].reports }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].reports"  true-value="1" false-value="0">
                                            {{ nRole[0].reports }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="settings">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].settings == 1" v-model="nRole[0].settings"  true-value="1" false-value="0">
                                            {{ nRole[0].settings }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].settings"  true-value="1" false-value="0">
                                            {{ nRole[0].settings }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_job_categories">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_job_categories == 1" v-model="nRole[0].add_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].add_job_categories }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].add_job_categories }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_job_categories">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_job_categories == 1" v-model="nRole[0].edit_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_job_categories }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_job_categories }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_job_categories">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_job_categories == 1" v-model="nRole[0].delete_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_job_categories }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_job_categories }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_job_categories">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_job_categories == 1" v-model="nRole[0].show_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].show_job_categories }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_job_categories"  true-value="1" false-value="0">
                                            {{ nRole[0].show_job_categories }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_job_titles">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_job_titles == 1" v-model="nRole[0].add_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].add_job_titles }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].add_job_titles }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_job_titles">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_job_titles == 1" v-model="nRole[0].edit_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_job_titles }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_job_titles }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_job_titles">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_job_titles == 1" v-model="nRole[0].delete_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_job_titles }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_job_titles }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_job_titles">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_job_titles == 1" v-model="nRole[0].show_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].show_job_titles }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_job_titles"  true-value="1" false-value="0">
                                            {{ nRole[0].show_job_titles }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_vacancies">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_vacancies == 1" v-model="nRole[0].add_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].add_vacancies }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].add_vacancies }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_vacancies">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_vacancies == 1" v-model="nRole[0].edit_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_vacancies }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_vacancies }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_vacancies">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_vacancies == 1" v-model="nRole[0].delete_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_vacancies }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_vacancies }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_vacancies">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_vacancies == 1" v-model="nRole[0].show_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].show_vacancies }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_vacancies"  true-value="1" false-value="0">
                                            {{ nRole[0].show_vacancies }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_applications">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_applications == 1" v-model="nRole[0].add_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].add_applications }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].add_applications }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_applications">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_applications == 1" v-model="nRole[0].edit_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_applications }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_applications }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_applications">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_applications == 1" v-model="nRole[0].delete_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_applications }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_applications }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_applications">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_applications == 1" v-model="nRole[0].show_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].show_applications }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_applications"  true-value="1" false-value="0">
                                            {{ nRole[0].show_applications }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_employees">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_employees == 1" v-model="nRole[0].add_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].add_employees }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].add_employees }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_employees">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_employees == 1" v-model="nRole[0].edit_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_employees }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_employees }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_employees">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_employees == 1" v-model="nRole[0].delete_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_employees }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_employees }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_employees">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_employees == 1" v-model="nRole[0].show_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].show_employees }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_employees"  true-value="1" false-value="0">
                                            {{ nRole[0].show_employees }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="emp_dashboard">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].emp_dashboard == 1" v-model="nRole[0].emp_dashboard"  true-value="1" false-value="0">
                                            {{ nRole[0].emp_dashboard }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].emp_dashboard"  true-value="1" false-value="0">
                                            {{ nRole[0].emp_dashboard }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_salaries">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_salaries == 1" v-model="nRole[0].add_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].add_salaries }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].add_salaries }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_salaries">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_salaries == 1" v-model="nRole[0].edit_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_salaries }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_salaries }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_salaries">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_salaries == 1" v-model="nRole[0].delete_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_salaries }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_salaries }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_salaries">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_salaries == 1" v-model="nRole[0].show_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].show_salaries }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_salaries"  true-value="1" false-value="0">
                                            {{ nRole[0].show_salaries }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_salaries_details">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_salaries_details == 1" v-model="nRole[0].add_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].add_salaries_details }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].add_salaries_details }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_salaries_details">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_salaries_details == 1" v-model="nRole[0].edit_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_salaries_details }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_salaries_details }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_salaries_details">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_salaries_details == 1" v-model="nRole[0].delete_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_salaries_details }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_salaries_details }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_salaries_details">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_salaries_details == 1" v-model="nRole[0].show_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].show_salaries_details }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_salaries_details"  true-value="1" false-value="0">
                                            {{ nRole[0].show_salaries_details }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_vacations">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_vacations == 1" v-model="nRole[0].add_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].add_vacations }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].add_vacations }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="edit_vacations">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].edit_vacations == 1" v-model="nRole[0].edit_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_vacations }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].edit_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].edit_vacations }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="delete_vacations">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].delete_vacations == 1" v-model="nRole[0].delete_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_vacations }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].delete_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].delete_vacations }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="show_vacations">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].show_vacations == 1" v-model="nRole[0].show_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].show_vacations }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].show_vacations"  true-value="1" false-value="0">
                                            {{ nRole[0].show_vacations }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="xattendance">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].xattendance == 1" v-model="nRole[0].xattendance"  true-value="1" false-value="0">
                                            {{ nRole[0].xattendance }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].xattendance"  true-value="1" false-value="0">
                                            {{ nRole[0].xattendance }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="hr_settings">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].hr_settings == 1" v-model="nRole[0].hr_settings"  true-value="1" false-value="0">
                                            {{ nRole[0].hr_settings }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].hr_settings"  true-value="1" false-value="0">
                                            {{ nRole[0].hr_settings }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="rates">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].rates == 1" v-model="nRole[0].rates"  true-value="1" false-value="0">
                                            {{ nRole[0].rates }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].rates"  true-value="1" false-value="0">
                                            {{ nRole[0].rates }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_rates">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_rates == 1" v-model="nRole[0].add_rates"  true-value="1" false-value="0">
                                            {{ nRole[0].add_rates }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_rates"  true-value="1" false-value="0">
                                            {{ nRole[0].add_rates }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="custodies">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].custodies == 1" v-model="nRole[0].custodies"  true-value="1" false-value="0">
                                            {{ nRole[0].custodies }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].custodies"  true-value="1" false-value="0">
                                            {{ nRole[0].custodies }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                                        <!-- begin  -->
                            <div class="column is-2">
                                <b-field label="add_custodies">
                                    <div class="field">
                                        <b-switch v-if="nRole[0].add_custodies == 1" v-model="nRole[0].add_custodies"  true-value="1" false-value="0">
                                            {{ nRole[0].add_custodies }}
                                        </b-switch>
                                        <b-switch v-else v-model="nRole[0].add_custodies"  true-value="1" false-value="0">
                                            {{ nRole[0].add_custodies }}
                                        </b-switch>
                                    </div>
                                </b-field>
                            </div>
                                        <!-- end -->
                        </div>
                    </div>
                </div>
                <div>
                    <b-button @click="updateRole" type="is-success">update</b-button>
                </div>
                <!-- end data -->
            </div>
        </div>
        <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>
</template>
<style>
.tasks{
    background: #fff;
    padding-left: 2%;
    margin-bottom: 3rem
}
</style>
<script>
import {
    getRolesById,
    updateRoleByID
} from './../../calls'
export default {
    data() {
            return {
                disabled:true,
                id:null,
                name:null,
                rolesChoice:[],
                mainroles:{},
                nRole:[
                    {
                    add_leads:0,
                    hard_delete_leads:0,
                    soft_delete_leads:0,
                    switch_leads:0,
                    edit_leads:0,
                    show_all_leads:0,
                    send_cil:0,
                    export_excel:0,
                    calls:0,
                    meetings:0,
                    requests:0,
                    add_developers:0,
                    edit_developers:0,
                    delete_developers:0,
                    show_developers:0,
                    add_projects:0,
                    edit_projects:0,
                    delete_projects:0,
                    show_projects:0,
                    add_phases:0,
                    edit_phases:0,
                    delete_phases:0,
                    show_phases:0,
                    add_properties:0,
                    edit_properties:0,
                    delete_properties:0,
                    show_properties:0,
                    add_resale_units:0,
                    edit_resale_units:0,
                    delete_resale_units:0,
                    show_resale_units:0,
                    add_rental_units:0,
                    edit_rental_units:0,
                    delete_rental_units:0,
                    show_rental_units:0,
                    add_lands:0,
                    edit_lands:0,
                    delete_lands:0,
                    show_lands:0,
                    marketing:0,
                    proposals:0,
                    deals:0,
                    finance:0,
                    reports:0,
                    settings:0,
                    add_job_categories:0,
                    edit_job_categories:0,
                    delete_job_categories:0,
                    show_job_categories:0,
                    add_job_titles:0,
                    edit_job_titles:0,
                    delete_job_titles:0,
                    show_job_titles:0,
                    add_vacancies:0,
                    edit_vacancies:0,
                    delete_vacancies:0,
                    show_vacancies:0,
                    add_applications:0,
                    edit_applications:0,
                    delete_applications:0,
                    show_applications:0,
                    add_employees:0,
                    edit_employees:0,
                    delete_employees:0,
                    show_employees:0,
                    emp_dashboard:0,
                    add_salaries:0,
                    edit_salaries:0,
                    delete_salaries:0,
                    show_salaries:0,
                    add_salaries_details:0,
                    edit_salaries_details:0,
                    delete_salaries_details:0,
                    show_salaries_details:0,
                    add_vacations:0,
                    edit_vacations:0,
                    delete_vacations:0,
                    show_vacations:0,
                    xattendance:0,
                    hr_settings:0,
                    rates:0,
                    add_rates:0,
                    custodies:0,
                    add_custodies:0,
                    }
                ],
                RolesArray:[],
                newRoles:[],
                active_item:1,
                disactive_item:0,
                isLoading:true,
            }
        },
        created() {
            this.id = this.$route.params.id
        },
        mounted(){
            this.gitroledata()
        },
        methods: {
            toggleInputsActive(){
                this.disabled = !this.disabled
            },
            updateRole(){
                this.isLoading = true
                // console.log('ttttttttttttt',this.nRole[0].add_leads)
                // console.log('ttttttttttttt',this.nRole[0].hard_delete_leads)
            const bodyFormData = new FormData();
                for (let key in this.RolesArray) {
                    const value = this.RolesArray[key];
                    bodyFormData.append("roles",JSON.stringify(this.nRole[0]));
                }
                bodyFormData.append('_method','put')
                bodyFormData.append('name',this.name)
                updateRoleByID(bodyFormData,this.id).then(response=>{
                    this.alertsuccess('role is up to date')
                    this.gitroledata()
                    // console.log('edit by id',response)
                }).catch(error=>{
                    console.log(error)
                })
            },
            gitroledata(){
                getRolesById(this.id).then(response=>{
                    this.nRole = response.data.data
                    // console.log('test lead add',this.nRole[0].add_leads)
                    // console.log('string json',this.nRole)
                    // console.log('all_response',response)
                    this.name = response.data.name
                    this.rolesChoice = response.data.data[0].add_leads
                    // console.log("data choice",this.rolesChoice)
                    this.mainroles = response.data.all_roles
                    this.newRoles = response.data.data
                    const tt = this.mainroles
                    var roles = []
                    Object.keys(tt).forEach(function(key,index) {
                        for(var i=0;i<tt[key].length;i++){
                            roles.push(tt[key][i])
                        }
                        // Object.keys(this.mainroles[key]).forEach(function(key2,index2) {
                        //     console.log(key2)
                        // });
                    });
                    this.RolesArray = roles
                    this.isLoading = false
                    console.log(this.RolesArray)
                    // for (var i = 0; i < this.mainroles.length; i++) {
                    //     console.log('TEST',i)
                    //     // for (let y = 0; y < this.mainroles[i].length; y++) {
                    //     //  this.mainroles[i] = this.rolesdetails[0];
                    //     // }
                    // }
                    // console.log('applications',applications)
                    // console.log('dddddd',this.mainroles.rolesdetails)
                    // console.log('mainroles',this.mainroles)
                }).catch(error=>{
                    console.log(error)
                })
            },
            alertsuccess(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-success'
                })
            },
            alerterror(massege){
                this.$toast.open({
                    message: massege,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
            }
        }
}
</script>