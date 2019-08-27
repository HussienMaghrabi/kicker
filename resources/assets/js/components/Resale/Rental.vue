<template>

  <div>
    <div class="control">
      <a class="button" :class="{ 'is-success': privacy == 'only_me' }" @click="privacy = 'only_me'; getData();">Me</a>
      <a class="button" :class="{ 'is-success': privacy == 'team_only' }"
        @click="privacy = 'team_only'; getData(); ">Team Only</a>
      <a class="button" :class="{ 'is-success': privacy == 'public' }"
        @click="privacy = 'public'; getData();">Public</a>
    </div>
    <div class="columns is-multiline" style="margin: 1rem 0">
      <div class="column is-3 filter-div">
        <p class="filter-title"><i class="fas fa-filter"></i>filter</p>
        <div class="columns is-multiline" style="margin: 0">
          <div class="column is-12">
            <b-field label="Developer">
              <b-select v-model="filter.developer">
                <option v-for="developer in allDevelopers" :key="developer.id" :value="developer.id">{{developer.name}}
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-6">
            <b-field label="Min Price">
              <b-input v-model="filter.min_price" type="number" min="0"></b-input>
            </b-field>
          </div>
          <div class="column is-6">
            <b-field label="Max Price">
              <b-input v-model="filter.max_price" type="number" min="0"></b-input>
            </b-field>
          </div>
          <div class="column is-6">
            <b-field label="Min Area">
              <b-input v-model="filter.min_area" type="number" min="0"></b-input>
            </b-field>
          </div>
          <div class="column is-6">
            <b-field label="Max Area">
              <b-input v-model="filter.max_area" type="number" min="0"></b-input>
            </b-field>
          </div>
          <div class="column is-6">
            <b-field label="Min Down Payment">
              <b-input v-model="filter.min_down_payment" type="number" min="0"></b-input>
            </b-field>
          </div>
          <div class="column is-6">
            <b-field label="Max Down Payment">
              <b-input v-model="filter.max_down_payment" type="number" min="0"></b-input>
            </b-field>
          </div>
          <div class="column is-12">
            <b-field label="Locations">
              <b-select v-model="filter.location">
                <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-12">
            <b-field label="Unit">
              <b-select v-model="filter.typee">
                <option value="commercial">Commercial</option>
                <option value="personal">Residential</option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-12">
            <b-field label="Unit Type">
              <b-select v-model="filter.unit_typee">
                <option v-for="unit_typee in unit_type" :key="unit_typee.id" :value="unit_typee.id"
                  v-if="filter.typee == unit_typee.usage">
                  {{unit_typee.en_name}}
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-12">
            <b-field label="Projects">
              <b-select v-model="filter.project">
                <option v-for="project in projects"
                  v-if="filter.typee == project.type && filter.location == project.location_id" :key="project.id"
                  :value="project.id">
                  {{project.en_name}}
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-12">
            <b-field label="Most Viewed">
              <b-select v-model="filter.location">
                <option value=""> </option>
                <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-12" style="text-align: center; margin: 1rem 0 0 0">
            <b-button class="unit-filter-btn" @click="filtersChanged"><i class="fas fa-filter"></i>filter</b-button>
          </div>
        </div>
      </div>
      <div class="column is-9 unit-main-div">
        <div class="columns is-multiline" style="margin: 0">
          <div class="column is-4" style="padding-top: 0; box-shadow: 5px 5px 20px 0px #a29a9a; margin-bottom: 2rem"
            v-for="unit in units" :key="unit.id">
            <div class="columns is-multiline is-mobile" style="margin: 0">
              <div class="column is-12" style="padding-top: 0">
                <img class="resale-img" :src="'/' + unit.image">
              </div>
              <div class="column is-12">
                <div class="columns is-multiline is-mobile" style="margin: 0">
                  <div class="column is-6">
                    <img class="developer-logo-img" :src="'/uploads/' + unit.developer_logo">
                  </div>
                  <div class="column is-6" style="text-align: right; padding-right: 0.5rem">
                    <img class="project-logo-img" :src="'/uploads/' + unit.project_logo">
                    <br>
                    <div class="spinner unit-available">
                      <div class="double-bounce1" :style="{'background-color': availableBgColor(unit.availability)}">
                      </div>
                      <div class="double-bounce2" :style="{'background-color': availableBgColor(unit.availability)}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="column is-12" style="padding: 0 1rem 1rem 1rem;">
                <div class="columns is-multiline is-mobile unit-div-content" style="margin: 0">
                  <div class="column is-6">
                    <span class="unit-details">Location: <span
                        class="unit-details-value">{{ unit.location_en_name }}</span></span>
                  </div>
                  <div class="column is-6">
                    <span class="unit-details">Due Now: <span
                        class="unit-details-value">{{ unit.due_now }}</span></span>
                  </div>
                  <div class="column is-6">
                    <span class="unit-details">Value Of Rent: <span
                        class="unit-details-value">{{ unit.value_of_rent }}EGP</span></span>
                  </div>
                  <div class="column is-6">
                    <span class="unit-details">Delivery Date: <span
                        class="unit-details-value">{{ unit.delivery_date }}</span></span>
                  </div>
                  <div class="column is-12">
                    <div class="columns is-multiline is-mobile unit-rooms" style="margin: 0">
                      <div class="column is-4">
                        <i class="fas fa-bed" style="font-size: 1.5rem"></i>
                        <br>
                        <span class="unit-rooms-value">{{ unit.rooms }}</span>
                      </div>
                      <div class="column is-4">
                        <i class="fas fa-bath" style="font-size: 1.5rem"></i>
                        <br>
                        <span class="unit-rooms-value">{{ unit.bathrooms }}</span>
                      </div>
                      <div class="column is-4">
                        <i class="fas fa-expand-arrows-alt" style="font-size: 1.5rem"></i>
                        <br>
                        <span class="unit-rooms-value">{{ unit.area }}m</span>
                      </div>
                    </div>
                  </div>
                  <div class="column is-12">
                    <span class="unit-details">Entered By: <span
                        class="unit-details-value">{{ unit.user }}</span></span>
                  </div>
                </div>
              </div>
              <div class="column is-12 resale-footer">
                <div class="columns is-multiline is-mobile" style="margin: 0">
                  <div class="column is-6" style="display: grid">
                    <router-link :to="'/admin/vue/showRentalUnit/' + unit.id">
                      <b-button class="resale-btn" style="margin-bottom: 0.5rem">Read More</b-button>
                    </router-link>
                    <b-button class="resale-btn">Request Ads</b-button>
                  </div>
                  <div class="column is-6">
                    <div class="columns is-multiline is-mobile footer-btns-div" style="margin: 0">
                      <div class="column is-2">
                        <router-link :to="'/admin/vue/showRentalUnit/' + unit.id">
                          <b-button class="footer-btns"><i class="fas fa-eye"></i></b-button>
                        </router-link>
                      </div>
                      <div class="column is-2">
                        <router-link :to="'/admin/vue/rental_units/' + unit.id + '/edit'">
                          <b-button class="footer-btns"><i class="fas fa-edit"></i></b-button>
                        </router-link>
                      </div>
                      <div class="column is-3">
                        <router-link :to="'/admin/vue/showRentalUnit/' + unit.id">
                          <b-button class="footer-btns"><i class="fab fa-think-peaks"></i></b-button>
                        </router-link>
                      </div>
                      <div class="column is-3">
                        <router-link :to="'/admin/vue/showRentalUnit/' + unit.id">
                          <b-button class="footer-btns"><i class="fas fa-home"></i></b-button>
                        </router-link>
                      </div>
                      <div class="column is-2">
                        <b-button class="footer-btns" @click="RentalActions('delete',unit.id)"><i class="fas fa-trash"></i></b-button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <b-pagination @change="onPageChange" :total="total" :current.sync="current" :order="order" :size="size"
          :simple="isSimple" :rounded="isRounded" :per-page="perPage" aria-next-label="Next page"
          aria-previous-label="Previous page" aria-page-label="Page" aria-current-label="Current page">
        </b-pagination>
      </div>
    </div>

  </div>
</template>
<!--<template><div>{{ this.come }}</div></template>-->

<script>
  //export const myVar = 'This is my variable'
  import {
    getRental,
    getPublicData,
    newRentalFilter,
    getMyLeads,
    deleteRental,
    getAllDevelopers
  } from './../../calls'

  export default {
    data() {
      return {
        items: [],
        item: {
          id: 0,
          availability: '',
          price: 0,
          location: 0,
          rooms: 0,
          bathrooms: 0,
          area: 0
        },

        ddisplay: true,
        unit_type: [],
        typee: '',
        locations: [],
        //project:{},
        page: parseInt(this.$route.params.page),
        newCallData: {
          date: new Date()
        },
        leadsCurrentNumber: 0,
        leadsTotalNumber: 0,
        getLeadsByAgent: [],
        leadSources: [],
        units: [],
        isEmpty: false,
        isLoading: true,
        hasMobileCards: true,
        isPaginated: true,
        isPaginationSimple: false,
        defaultSortDirection: 'desc',
        total: 0,
        current: 1,
        order: '',
        size: '',
        isSimple: false,
        isRounded: false,
        page: 1,
        perPage: 10,
        isLoading: true,
        isFullPage: true,
        searchInput: '',
        selectedLeads: [],
        ShowHint: false,
        hintId: '',
        callStatus: [],
        projects: [],
        meetingStatus: [],
        filter: {
          developer: "",
          min_price: null,
          max_price: null,
          min_area: null,
          max_area: null,
          min_down_payment: null,
          max_down_payment: null,
          location: "",
          project: "",
          typee: "",
          unit_typee: "",
        },
        startFilter: false,
        switchLeadModel: false,
        bulkActionModel: false,
        switchLeadData: {},
        leadsIds: [],
        commercialAgents: [],
        residentialAgents: [],
        permArray: [],
        reloadData: false,
        types: ['personal', 'commercial'],
        privacy: 'only_me',
        allDevelopers: []


      }
    },
    created() {
      this.getPublic()
    },
    mounted() {
      if (this.ddisplay == false) {
        this.ddisplay = true
      } else {
        this.getData()
      }
      this.availableBgColor();
      this.getAllDevelopers();
    },

    methods: {
      filtersChanged() {
        this.getData();
      },
      getAllDevelopers() {
        getAllDevelopers()
          .then(response => {
            this.allDevelopers = response.data
          })
          .catch(error => {
            console.log(error);
          });
      },
      availableBgColor(availability) {
        if (availability === 'available')
          return 'green'
        else
          return 'red'
      },
      getData(loading = true) {
        this.isLoading = loading;
        const filters = this.filter;
        var jsonDataFormat = {
          "token": window.auth_user.token,
          "user_id": window.auth_user.id,
          "lang": "en",
          "type": "personal",
          "privacy": this.privacy,
          "selection": "me",
          filters,
        }
        getRental(jsonDataFormat, this.page)
          .then(response => {
            this.units = response.data.data;
            console.log("this.units", this.units)
            this.perPage = response.data.per_page;
            this.leadsCurrentNumber = this.units.length
            this.leadsTotalNumber = response.data.total
            if (this.units.length == 0) {
              this.isEmpty = true
            }
            let currentTotal = response.data.total
            if (response.data.total / this.perPage > 1000) {
              currentTotal = this.perPage * 1000
            }
            this.total = currentTotal
            this.isLoading = false
            this.getPublic()

          })
          .catch(error => {
            console.log(error)
          })
      },

      filterLeads(scrollSwitch = false) {
        //this.isLoading = true
        //this.fitlerFlag = true
        var data = {
          'project': this.filter.project,
          'unit_typee': this.filter.unit_typee,
          'location': this.filter.location,
          'typee': this.filter.typee,
          //'meetingStatus':this.filter.meeting_status_id,
          //'callStatus':this.filter.call_status_id,
          'dateTo': this.parsedDateTo,
          'dateFrom': this.parsedDateFrom,
          '_token': this.token,
          'agent_id': this.userId,
        };
        newRentalFilter(this.page, data).then(response => {
            this.ddisplay = false;

            this.items = response.data.data
            if (this.items.length > 0) {
              // Unit.display=false;
            }


            this.leadsCurrentNumber = this.roow.length
            this.leadsTotalNumber = response.data.total

            if (this.roow.length == 0) {
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
      getPublic() {
        var data = {
          'Unit': this.unit,
        };

        getPublicData(data).then(response => {

            this.unit_type = response.data.unit_type
            this.locations = response.data.locations
            this.projects = response.data.projects
            //this.types = response.data.types


          })
          .catch(error => {
            console.log(error)
          })
      },
      dateFormatterFrom(dt) {
        var date = dt.toLocaleDateString();
        const [month, day, year] = date.split('/')
        this.parsedDateFrom = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        return date
      },
      showonlyme() {

      },
      dateFormatterTo(dt) {
        var date = dt.toLocaleDateString();
        const [month, day, year] = date.split('/')
        this.parsedDateTo = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        return date
      },
      RentalActions(event, id) {
        // var action = event.target.value
        var action = event;
        if (action == 'show') {
          window.location = "/admin/rental_units/" + id;
        } else if (action == 'edit') {
          window.location = "/admin/rental_units/" + id + "/edit";
        } else if (action == 'delete') {
          this.confirmDelete(id)
        }
      },
      confirmDelete(id) {
        this.$dialog.confirm({
          title: 'Deleting Rental',
          message: 'Are you sure you want to <b>delete</b> Rental Unit?',
          confirmText: 'Delete Rental Unit',
          type: 'is-danger',
          hasIcon: true,
          onConfirm: () => this.deleteThisRental(id)
        })
      },
      deleteThisRental(id) {
        this.isLoading = true
        deleteRental(id).then(response => {
            this.getData()
            this.success('Deleted')
          })
          .catch(error => {
            console.log(error)
          })
      },
      onPageChange(page) {
        this.getData()
      },
      setlocation(id) {
        let locationEnName = ''
        this.locations.forEach((item) => {
          if (item.id == id) {
            locationEnName = item.en_name
          }
        })
        return locationEnName
      },
      setproject(id) {
        let proEnName = ''
        this.projects.forEach((item) => {
          if (item.id == id) {
            proEnName = item.en_name
          }
        })
        return proEnName
      },
    },
    filters: {
      jsontest($value) {
        return JSON.stringify($value);
      }
    }
  }
</script>

<style>
  .select,
  .select select {
    width: 100%;
  }
</style>

<style scoped>
  .filter-title {
    font-size: 1.5rem;
    text-transform: uppercase;
  }

  .filter-div {
    border: 1.5px solid black;
    padding: 1rem;
    height: fit-content;
  }

  .unit-filter-btn i {
    margin-right: 0.5rem;
  }

  .unit-filter-btn {
    text-transform: uppercase;
    color: black;
    padding: 0.5rem 1rem;
  }

  .resale-img {
    width: 100%;
    height: 12rem;
  }

  .unit-details {
    font-weight: bold;
    text-transform: capitalize;
  }

  .unit-details:nth-child(even) {
    float: right;
    text-transform: capitalize;
  }

  .unit-details-value {
    font-weight: 500 !important;
    margin-left: 0.5rem;
    text-transform: capitalize;
  }

  .unit-div-content .is-6:nth-child(even) {
    padding-left: 0.5rem;
    margin-bottom: 0.5rem
  }

  .unit-rooms .column,
  .footer-btns-div {
    text-align: center
  }

  .resale-footer {
    border-top: 1px solid black;
    padding: 1rem 0.5rem;
  }

  .resale-btn {
    width: 7rem;
    text-transform: uppercase;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.25rem;
    text-align: center;
  }

  .footer-btns {
    border: unset !important;
    padding: unset !important;
  }

  .unit-main-div {
    padding: 0 2rem;
  }

  .project-logo-img {
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    background: white;
    margin-top: -3rem;
    box-shadow: rgb(162, 154, 154) 5px 5px 20px 0px;
  }

  .developer-logo-img {
    width: 7rem;
    height: 7rem;
  }

  .unit-available {
    height: 1.5rem;
    width: 1.5rem;
    border-radius: 50%;
    float: right;
    margin: 1rem 2rem 0 0px;
  }

  .spinner {
    position: relative;
  }

  .double-bounce1,
  .double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;
    -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
    animation: sk-bounce 2.0s infinite ease-in-out;
  }

  .double-bounce2 {
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
  }

  @-webkit-keyframes sk-bounce {

    0%,
    100% {
      -webkit-transform: scale(0.0)
    }

    50% {
      -webkit-transform: scale(1.0)
    }
  }

  @keyframes sk-bounce {

    0%,
    100% {
      transform: scale(0.0);
      -webkit-transform: scale(0.0);
    }

    50% {
      transform: scale(1.0);
      -webkit-transform: scale(1.0);
    }
  }
</style>