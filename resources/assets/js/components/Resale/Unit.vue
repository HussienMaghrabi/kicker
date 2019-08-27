<template>
    <div>
      <div class="control">
                <a class="button" :class="{ 'is-success': privacy == 'only_me' }" @click="privacy = 'only_me'; getData()">
                  Me
                </a>
                <a class="button" :class="{ 'is-success': privacy == 'team_only' }" @click="privacy = 'team_only'; getData()">
                  Team Only
                </a>
                <a class="button" :class="{ 'is-success': privacy == 'public' }" @click="privacy = 'public'; getData()">
                  Public
                </a>
            </div>
        <!-- <div>
            <div class="control">
                <a class="button" :class="{ 'is-success': privacy == 'only_me' }" @click="privacy = 'only_me'; getData()">
                  Me
                </a>
                <a class="button" :class="{ 'is-success': privacy == 'team_only' }" @click="privacy = 'team_only'; getData()">
                  Team Only
                </a>
                <a class="button" :class="{ 'is-success': privacy == 'public' }" @click="privacy = 'public'; getData()">
                  Public
                </a>
            </div>
            <br>
            <div class="columns is-mobile mb-5 ml-0">
                <div class="column is-2">
                    <div class="field">
                        <b-field label="From">
                            <b-datepicker
                              placeholder="Click to select..."
                              :date-formatter="dateFormatterFrom"
                              position="is-bottom-left"
                              v-model="filter.from">
                            </b-datepicker>
                        </b-field>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <b-field label="To">
                            <b-datepicker
                              placeholder="Click to select..."
                              :date-formatter="dateFormatterTo"
                              position="is-bottom-left"
                              v-model="filter.to">
                            </b-datepicker>
                        </b-field>
                    </div>
                </div>
                <div class="column is-2">
                    <label class="label">Location</label>
                    <div class="field has-addons">

                        <div class="control is-expanded">
                            <div class="select is-fullwidth">
                                <select v-model="filter.location" @change="filtersChanged">
                                    <option value=""> </option>
                                    <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="column is-2">
                    <label class="label">Unit</label>
                    <div class="field has-addons">

                        <div class="control is-expanded">
                            <div class="select is-fullwidth">
                              <select v-model="filter.typee" @change="filtersChanged">
                                <option value=""> </option>
                                <option value="commercial">Commercial</option>
                                <option value="personal">Residential</option>
                              </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="column is-2">
                    <label class="label">projects</label>
                    <div class="field has-addons">

                        <div class="control is-expanded">
                            <div class="select is-fullwidth">
                                <select v-model="filter.project" @change="filtersChanged">
                                  <option value=""> </option>
                                    <option v-for="project in projects" v-if="filter.typee == project.type && filter.location == project.location_id"
                                        :key="project.id" :value="project.id">
                                        {{project.en_name}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="column is-2">
                    <label class="label">unit_type</label>
                    <div class="field has-addons">

                        <div class="control is-expanded">
                            <div class="select is-fullwidth">
                                <select v-model="filter.unit_typee" @change="filtersChanged">
                                  <option value=""> </option>
                                    <option v-for="unit_typee in unit_type" :key="unit_typee.id" :value="unit_typee.id"
                                        v-if="filter.typee == unit_typee.usage">
                                        {{unit_typee.en_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <div>
          <b-table
          :data="units"
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
          :checked-rows.sync="selectedLeads"
          :default-sort-direction="defaultSortDirection"
          default-sort="created_at">

          <template slot-scope="props">
            <b-table-column field="id" label="ID" sortable>
              {{props.row.id}}
            </b-table-column>

            <b-table-column field="Image" label="Image" sortable>
              <img :src="'/'+props.row.image" width="160px">
            </b-table-column>

            <b-table-column field="leadProbability" label="Availabity" sortable>
              {{props.row.availability}}
            </b-table-column>

            <b-table-column field="first_name" label="price" sortable>
              {{props.row.price}}
            </b-table-column>

            <b-table-column field="DueNow" label="Due Now" sortable>
              {{props.row.due_now}}
            </b-table-column>

            <b-table-column field="location" label="Location" sortable>
              {{setlocation(props.row.location)}}

            </b-table-column>
            <b-table-column field="project" label="project" sortable>
              {{setproject(props.row.project_id)}}

            </b-table-column>

            <b-table-column field="requestLocation" label="Rooms" sortable>
              {{props.row.rooms}}
            </b-table-column>

            <b-table-column field="projectName" label="Bathrooms" sortable>
              {{props.row.bathrooms}}
            </b-table-column>

            <b-table-column field="created_at" label="Area" sortable>
              {{props.row.area}} KM ^ 2
            </b-table-column>

            <b-table-column field="created_at" label="Delivery Date" sortable>
              {{props.row.delivery_date}}
            </b-table-column>

            <b-table-column field="user" label="Entered By" sortable>
              {{props.row.user}}
            </b-table-column>

            <b-table-column field="created_at" label="Created At" sortable>
              {{props.row.created_at}}
            </b-table-column>



            <b-table-column field="phone" label="Options" centered>
              <div class="select">
                <select @change="ResaleActions($event,props.row.id)">
                  <option disabled selected value="options">Options</option>
                  <option value="show">Show</option>
                  <option value="edit">Edit</option>
                  <option value="delete">Delete</option>
                </select>
              </div>
            </b-table-column>



          </template>

          <template slot="empty">
            <section class="section">
              <div class="content has-text-grey has-text-centered">
                <p>
                  <b-icon icon="emoticon-sad" size="is-large">
                  </b-icon>
                </p>
                <p>Nothing here.</p>

              </div>
            </section>
            <hr>
          </template>
        </b-table>
      </div> -->
      

      <div class="columns is-multiline" style="margin: 1rem 0">
        <div class="column is-3 filter-div">
          <p class="filter-title"><i class="fas fa-filter"></i>filter</p>
          <div class="columns is-multiline" style="margin: 0">
            <div class="column is-12">
              <b-field label="Developer">
                <b-select v-model="filter.developer" @change="filtersChanged">
                  <option v-for="developer in allDevelopers" :key="developer.id" :value="developer.id">{{developer.name}}</option>
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
                <b-select v-model="filter.location" @change="filtersChanged">
                  <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-12">
              <b-field label="Unit">
                <b-select v-model="filter.typee" @change="filtersChanged">
                  <option value="commercial">Commercial</option>
                  <option value="personal">Residential</option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-12">
              <b-field label="Unit Type">
                <b-select v-model="filter.unit_typee" @change="filtersChanged">
                  <option v-for="unit_typee in unit_type" :key="unit_typee.id" :value="unit_typee.id"
                      v-if="filter.typee == unit_typee.usage">
                      {{unit_typee.en_name}}
                  </option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-12">
              <b-field label="Projects">
                <b-select v-model="filter.project" @change="filtersChanged">
                  <option v-for="project in projects" v-if="filter.typee == project.type && filter.location == project.location_id"
                      :key="project.id" :value="project.id">
                      {{project.en_name}}
                  </option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-12">
              <b-field label="Most Viewed">
                <b-select v-model="filter.location" @change="filtersChanged">
                  <option value=""> </option>
                  <option v-for="location in locations" :key="location.id" :value="location.id">{{location.en_name}}</option>
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
            <div class="column is-4" style="padding-top: 0; box-shadow: 5px 5px 20px 0px #a29a9a; margin-bottom: 2rem" v-for="unit in units" :key="unit.id">
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
                        <div class="double-bounce1" :style="{'background-color': availableBgColor(unit.availability)}"></div>
                        <div class="double-bounce2" :style="{'background-color': availableBgColor(unit.availability)}"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="column is-12" style="padding: 0 1rem 1rem 1rem;">
                  <div class="columns is-multiline is-mobile unit-div-content" style="margin: 0">
                    <div class="column is-6">
                      <span class="unit-details">Location: <span class="unit-details-value">{{ unit.location_en_name }}</span></span>
                    </div>
                    <div class="column is-6">
                      <span class="unit-details">Due Now: <span class="unit-details-value">{{ unit.due_now }}</span></span>
                    </div>
                    <div class="column is-6">
                      <span class="unit-details">Price: <span class="unit-details-value">{{ unit.price }}EGP</span></span>
                    </div>
                    <div class="column is-6">
                      <span class="unit-details">Delivery Date: <span class="unit-details-value">{{ unit.delivery_date }}</span></span>
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
                      <span class="unit-details">Entered By: <span class="unit-details-value">{{ unit.user }}</span></span>
                    </div>
                  </div>
                </div>
                <div class="column is-12 resale-footer">
                  <div class="columns is-multiline is-mobile" style="margin: 0">
                    <div class="column is-6" style="display: grid">
                      <router-link :to="'/admin/vue/showResaleUnit/' + unit.id">
                        <b-button class="resale-btn" style="margin-bottom: 0.5rem">Read More</b-button>
                      </router-link>
                      <b-button class="resale-btn">Request Ads</b-button>
                    </div>
                    <div class="column is-6">
                      <div class="columns is-multiline is-mobile footer-btns-div" style="margin: 0">
                        <div class="column is-2">
                          <router-link :to="'/admin/vue/showResaleUnit/' + unit.id">
                            <b-button class="footer-btns"><i class="fas fa-eye"></i></b-button>
                          </router-link>
                        </div>
                        <div class="column is-2">
                          <router-link :to="'/admin/vue/resale_units/' + unit.id + '/edit'">
                            <b-button class="footer-btns"><i class="fas fa-edit"></i></b-button>
                          </router-link>
                        </div>
                        <div class="column is-3">
                          <router-link :to="'/admin/vue/showResaleUnit/' + unit.id">
                            <b-button class="footer-btns"><i class="fab fa-think-peaks"></i></b-button>
                          </router-link>
                        </div>
                        <div class="column is-3">
                          <router-link :to="'/admin/vue/showResaleUnit/' + unit.id">
                            <b-button class="footer-btns"><i class="fas fa-home"></i></b-button>
                          </router-link>
                        </div>
                        <div class="column is-2">
                          <b-button class="footer-btns" @click="ResaleActions('delete',unit.id)"><i class="fas fa-trash"></i></b-button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <b-pagination
            @change="onPageChange"
            :total="total"
            :current.sync="current"
            :order="order"
            :size="size"
            :simple="isSimple"
            :rounded="isRounded"
            :per-page="perPage"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">
        </b-pagination>
        </div>
      </div>
    </div>
</template>

<script>
import {
  getPublicData,
  newResaleFilter,
  getResales,
  deleteResale,
  getAllDevelopers
} from "./../../calls";

export default {
  data() {
    return {
      unit_type: [],
      typee: "",
      locations: [],
      //location:{},
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
      defaultSortDirection: "desc",
      total: 0,
      current: 1,
      order: '',
      size: '',
      isSimple: false,
      isRounded: false,
      page: 1,
      perPage: 9,
      isLoading: true,
      isFullPage: true,
      searchInput: "",
      selectedLeads: [],
      ShowHint: false,
      hintId: "",
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
        typee: "",
        project: "",
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
      privacy: "only_me",
      area: 0,
      allDevelopers:[]
    };
  },
  created() {
    this.$router.replace({hash: '#/1'});
  },
  mounted() {
    this.getPublic();
    this.getData();
    this.availableBgColor();
    this.getAllDevelopers();
  },

  methods: {
    availableBgColor(availability) {
      if(availability === 'available')
        return 'green'
      else
        return 'red'
    },

    filtersChanged() {
      this.getData();
    },
    getData(loading = true) {
      this.isLoading = loading;
      const filters = this.filter;
      var jsonDataFormat = {
        token: window.auth_user.token,
        user_id: window.auth_user.id,
        lang: "en",
        type: "personal",
        privacy: this.privacy,
        selection: this.privacy,
        filters: filters
      };
      // this.page = parseInt(this.$route.hash.split('/')[1]),
      getResales(jsonDataFormat, this.page)
        .then(response => {
          this.units = response.data.data;
          console.log('unitsssssss', response.data.data)
          this.perPage = response.data.per_page;
          this.leadsCurrentNumber = this.units.length;
          this.leadsTotalNumber = response.data.total;
          if (this.units.length == 0) {
            this.isEmpty = true;
          }
          let currentTotal = response.data.total;
          if (response.data.total / this.perPage > 1000) {
            currentTotal = this.perPage * 1000;
          }
          this.total = currentTotal;
          this.isLoading = false;
          this.getPublic();
        })
        .catch(error => {
          console.log(error);
        });
    },
    getPublic() {
      var data = {
        Unit: this.unit
      };
      getPublicData(data)
        .then(response => {
          //console.log(this.projects)
          this.unit_type = response.data.unit_type;
          this.locations = response.data.locations;
          this.projects = response.data.projects;
          //this.types = response.data.types
        })
        .catch(error => {
          console.log(error);
        });
    },
    dateFormatterFrom(dt) {
      var date = dt.toLocaleDateString();
      const [month, day, year] = date.split("/");
      this.parsedDateFrom = `${year}-${month.padStart(2, "0")}-${day.padStart(
        2,
        "0"
      )}`;
      return date;
    },
    dateFormatterTo(dt) {
      var date = dt.toLocaleDateString();
      const [month, day, year] = date.split("/");
      this.parsedDateTo = `${year}-${month.padStart(2, "0")}-${day.padStart(
        2,
        "0"
      )}`;
      return date;
    },
    ResaleActions(event, id) {
      // var action = event.target.value;
      var action = event;
      if (action == "show") {
        window.location = "/admin/resale_units/" + id;
      } else if (action == "edit") {
        window.location = "/admin/resale_units/" + id + "/edit";
      } else if (action == "delete") {
        this.confirmDelete(id);
      }
    },
    showUnit(id){
      window.location = "/admin/resale_units/" + id;
    },
    editUnit(id){
      window.location = "/admin/resale_units/" + id + "/edit";
    },
    confirmDelete(id) {
      this.$dialog.confirm({
        title: "Deleting Resale",
        message: "Are you sure you want to <b>delete</b> Resale Unit?",
        confirmText: "Delete Resale Unit",
        type: "is-danger",
        hasIcon: true,
        onConfirm: () => this.deleteThisResale(id)
      });
    },
    deleteThisResale(id) {
      this.isLoading = true;
      deleteResale(id)
        .then(response => {
          this.getData();
          this.success("Deleted");
        })
        .catch(error => {
          console.log(error);
        });
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
    onPageChange() {
      // this.page = parseInt(this.$route.hash.split('/')[this.page+1]),
      this.page = this.page + 1
      console.log(this.page)
      this.getData();
    },
    setlocation(id) {
      let locationEnName = "";
      this.locations.forEach(item => {
        if (item.id == id.id) {
          locationEnName = item.en_name;
        }
      });
      return locationEnName;
    },
    setproject(id) {
      let proEnName = "";
      this.projects.forEach(item => {
        if (item.id == id) {
          proEnName = item.en_name;
        }
      });
      return proEnName;
    }
  },
  watch: {
    "filter.from": function() {
      this.filtersChanged();
    },
    "filter.to": function() {
      this.filtersChanged();
    }
  },
};
</script>

<style>
.select,
.select select{
  width: 100%;
}
</style>

<style scoped>
  .filter-title{
    font-size: 1.5rem;
    text-transform: uppercase;
  }

  .filter-div{
    border: 1.5px solid black;
    padding: 1rem;
    height: fit-content;
  }

  .unit-filter-btn i{
    margin-right: 0.5rem;
  }

  .unit-filter-btn{
    text-transform: uppercase;
    color: black;
    padding: 0.5rem 1rem;
  }

  .resale-img{
    width: 100%;
    height: 12rem;
  }

  .unit-details{
    font-weight: bold;
    text-transform: capitalize;
  }

  .unit-details:nth-child(even){
    float: right;
    text-transform: capitalize;
  }

  .unit-details-value{
    font-weight: 500 !important;
    margin-left: 0.5rem;
    text-transform: capitalize;
  }

  .unit-div-content .is-6:nth-child(even){
    padding-left: 0.5rem;
    margin-bottom: 0.5rem
  }

  .unit-rooms .column,
  .footer-btns-div{
    text-align: center
  }

  .resale-footer{
    border-top: 1px solid black;
    padding: 1rem 0.5rem;
  }

  .resale-btn{
    width: 7rem;
    text-transform: uppercase;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.25rem;
    text-align: center;
  }

  .footer-btns{
    border: unset !important;
    padding: unset !important;
  }

  .unit-main-div{
    padding: 0 2rem;
  }

  .project-logo-img{
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    background: white;
    margin-top: -3rem;
    box-shadow: rgb(162, 154, 154) 5px 5px 20px 0px;
  }

  .developer-logo-img{
    width: 7rem;
    height: 7rem;
  }

  .unit-available{
    height: 1.5rem;
    width: 1.5rem;
    border-radius: 50%;
    float: right;
    margin: 1rem 2rem 0 0px;
  }

  .spinner {
  position: relative;
}

.double-bounce1, .double-bounce2 {
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
  0%, 100% { -webkit-transform: scale(0.0) }
  50% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bounce {
  0%, 100% { 
    transform: scale(0.0);
    -webkit-transform: scale(0.0);
  } 50% { 
    transform: scale(1.0);
    -webkit-transform: scale(1.0);
  }
}

 
</style>