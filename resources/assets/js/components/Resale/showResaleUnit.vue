<template lang="html">
    <div>
         <div class="container is-fluid">
           <div class="card">
          <header class="card-header cardHeader">
            <p class="card-header-title">Show Unit   ---------  Entered By : {{ unit.user }}</p>
            <b-switch :value="false" v-model="featuredValue"
            type="is-info">
                Featured website
            </b-switch>
            <b-switch :value="false" v-model="showOnWebsiteValue"
            type="is-info">
                show on website
            </b-switch>
            <b-switch :value="false" v-model="showInMobileValue"
            type="is-info">
                show in mobile
            </b-switch>
            <button class="button is-info add-proposal">
                 <router-link :to="'/admin/vue/createProposal'" style="color:#fff;"> 
                      Add Proposal
                 </router-link>
            </button>
          </header>
          <div class="card-content">
              <div class="columns is-multiline">
                <div class="column is-12">
                    <carousel :per-page="1" :navigationEnabled="true" :paginationEnabled="true" :autoplay="true" :loop="true">
                        <slide style="padding-top: 1%;" v-for="image in unit.sliderImages" :key="image.id">
                            <img :src="'/' + image.image" style="height: 100%; width: 100%;">
                        </slide>
                    </carousel>
                </div>
                <div class="column is-6 title" v-if="unit.agent">
                    <div class="columns is-multiline is-mobile bg-profile-content">
                        <div class="column is-4">
                            <img class="profile-img" :src="'/' + unit.agent.image">
                        </div>
                        <div class="column is-8 profile-main-content">
                            <p class="profile-title">Agent</p>
                            <div class="profile-content">
                                <p>{{ unit.agent.name }}</p>
                                <p class="unit-data">{{ unit.agent.phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6 title" v-if="unit.lead && userType === 'admin'">
                    <div class="columns is-multiline is-mobile bg-profile-content">
                        <div class="column is-4">
                            <img class="profile-img" :src="'/' + unit.lead.image" >
                        </div>
                        <div class="column is-8 profile-main-content">
                            <p class="profile-title">Lead</p>
                            <div class="profile-content">
                                <p>{{ unit.lead.first_name }} {{unit.lead.last_name}}</p>
                                <p class="unit-data">{{ unit.lead.phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="columns is-multiline">
                <div class="column is-6 title">
                    Type:
                    <span class="unit-data">{{ unit.type }}</span>
                </div>
                <div class="column is-6 title">
                    Unit Type:
                    <span class="unit-data" v-if="unit.unit_type != null">{{ unit.unit_type.en_name }}</span>
                    <span class="unit-data" v-else></span>
                </div>
                <div class="column is-6 title">
                    Project:
                    <span class="unit-data" v-if="unit.project != null">{{ unit.project.en_name }}</span>
                    <span class="unit-data" v-else></span>
                </div>
                <div class="column is-6 title">
                    Original Price:
                    <span class="unit-data">{{ unit.original_price }}</span>
                </div>
                <div class="column is-6 title">
                    Paid:
                    <span class="unit-data">{{ unit.payed }}</span>
                </div>
                <div class="column is-6 title">
                    Rest:
                    <span class="unit-data">{{ unit.rest }}</span>
                </div>
                <div class="column is-6 title">
                    Over:
                    <span class="unit-data">{{ unit.total }}</span>
                </div>
                <div class="column is-6 title">
                    Delivery Date:
                    <span class="unit-data">{{ unit.delivery_date }}</span>
                </div>
                <div class="column is-6 title">
                    Due Now:
                    <span class="unit-data">{{ unit.due_now }}</span>
                </div>
                <div class="column is-6 title">
                    Finishing:
                    <span class="unit-data">{{ unit.finishing }}</span>
                </div>
                <div class="column is-6 title">
                    Location on Map:
                    <span class="unit-data" v-if="unit.locationOnMap != null">{{ unit.locationOnMap.en_name }}</span>
                    <span class="unit-data" v-else></span>
                </div>
                <div class="column is-6 title">
                    Arabic Notes:
                    <span class="unit-data">{{ unit.ar_notes }}</span>
                </div>
                <div class="column is-6 title">
                    English Notes:
                    <span class="unit-data">{{ unit.en_notes }}</span>
                </div>
                <div class="column is-6 title">
                    Arabic Description:
                    <span class="unit-data">{{ unit.ar_description }}</span>
                </div>
                <div class="column is-6 title">
                    English Description:
                    <span class="unit-data">{{ unit.en_description }}</span>
                </div>
                <div class="column is-6 title">
                    Arabic Title:
                    <span class="unit-data">{{ unit.ar_title }}</span>
                </div>
                <div class="column is-6 title">
                    English Title:
                    <span class="unit-data">{{ unit.en_title }}</span>
                </div>
                <div class="column is-6 title">
                    Arabic Address:
                    <span class="unit-data">{{ unit.ar_address }}</span>
                </div>
                <div class="column is-6 title">
                    English Address:
                    <span class="unit-data">{{ unit.en_address }}</span>
                </div>
                <div class="column is-6 title">
                    Youtube Link:
                    <span class="unit-data"><a :href="unit.youtube_link">{{ unit.youtube_link }}</a></span>
                </div>
                <div class="column is-6 title">
                    Phone:
                    <span class="unit-data">{{ unit.phone }}</span>
                </div>
                <div class="column is-6 title">
                    Buldin Area:
                    <span class="unit-data">{{ unit.bua }}</span>
                </div>
                <div class="column is-6 title">
                    Other Phones:
                    <span class="unit-data">{{ unit.other_phones }}</span>
                </div>
                <div class="column is-6 title">
                    Land Area:
                    <span class="unit-data">{{ unit.area }}</span>
                </div>
                <div class="column is-6 title">
                    Unit Number:
                    <span class="unit-data">{{ unit.location_number }}</span>
                </div>
                <div class="column is-6 title">
                    Price:
                    <span class="unit-data">{{ unit.price }}</span>
                </div>
                <div class="column is-6 title">
                    Rooms:
                    <span class="unit-data">{{ unit.rooms }}</span>
                </div>
                <div class="column is-6 title">
                    Bathrooms:
                    <span class="unit-data">{{ unit.bathrooms }}</span>
                </div>
                <div class="column is-6 title">
                    Floors:
                    <span class="unit-data">{{ unit.floors}}</span>
                </div>
                <div class="column is-6 title">
                    Payment Method:
                    <span class="unit-data">{{ unit.payment_method }}</span>
                </div>
                <div class="column is-6 title">
                    Availability:
                    <span class="unit-data">{{ unit.availability }}</span>
                </div>
                <div class="column is-6 title">
                    View:
                    <span class="unit-data">{{ unit.view}}</span>
                </div>
                <div class="column is-6 title">
                    Rent:
                    <span class="unit-data">{{ unit.rent}}</span>
                </div>
                <div class="column is-6 title">
                    Image:
                    <br>
                    <img :src="'/' + unit.image" style="width: 20rem; margin-top: 1rem">
                </div>
              </div>
          </div>
        </div>
             
         </div>
    </div>
</template>

<script>

import {updateWebsiteResaleShow,showResaleUnit} from './../../calls'

import { Carousel, Slide } from "vue-carousel";

export default {
  name: "showResaleUnit",

  data() {
    return {
      unit: null,
      featuredValue: "",
      showOnWebsiteValue: "",
      showInMobileValue: "",
      userType: window.auth_user.type,
      id: null
    };
  },

  components: {
    Carousel,
    Slide
  },

  watch: {
    featuredValue: function() {
      this.showOnWebsiteValue = true;
      this.saveFeatured();
    },
    showOnWebsiteValue: function() {
      this.saveShowOnWebsite();
    },
    showInMobileValue: function() {
        this.saveShowInMobile();
    }
  },
  created() {
    this.id = this.$route.params.id
  },
  mounted() {
      this.getData()
  },

  computed: {},

  methods: {
    getData(loading = true){
        this.isLoading = loading
        console.log(this.id)
        showResaleUnit(this.id).then(response=>{
            console.log(response)
            this.unit = response.data
            this.isLoading = false
        })
        .catch(error => {
            console.log(error)
        })
    },
    saveFeatured() {
      const bodyFormData = new FormData();
      bodyFormData.append("featured", this.featuredValue);
      console.log(bodyFormData);
    },
    saveShowOnWebsite() {
    //   const bodyFormData = new FormData();
    //   bodyFormData.append("show_on_website", this.showOnWebsiteValue);
    //   console.log(bodyFormData);
        updateWebsiteResaleShow(this.unit.id).then(response=>{
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
    },
    saveShowInMobile() {
      const bodyFormData = new FormData();
      bodyFormData.append("show_in_mobile", this.showInMobileValue);
      console.log(bodyFormData);
    }
  }
};
</script>

<style>
body > div > div > div > div > div > div.column.is-12 > div {
  max-width: 50%;
  max-height: 100%;
  margin-right: auto;
  margin-left: auto;
  margin-bottom: 3rem;
}
</style>
<style lang="css" scoped>
.unit-data {
  font-weight: 500;
}

.add-proposal {
  margin: 0.5rem 0.5rem 0.5rem 0.5rem;
}

.profile-img {
  border-radius: 50%;
  width: 9rem;
  height: 9rem;
  display: block;
  margin-right: auto;
  margin-left: auto;
}

.profile-main-content {
  position: relative;
}

.profile-content {
  position: absolute;
  top: 0;
  bottom: 0;
  height: 30%;
  margin: auto;
}

.profile-content p {
  margin-bottom: 1rem;
}

.profile-title {
  text-align: center;
  font-size: 1.5rem;
}

.bg-profile-content {
  background: #b07d121f;
  padding: 1.5rem 0;
  border-radius: 2rem;
  margin: 0 1rem;
  width: -webkit-fill-available;
  width: -moz-available;
}
</style>
