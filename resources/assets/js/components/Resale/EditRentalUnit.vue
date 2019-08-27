<template lang="html">
    <div>
         <div class="container is-fluid">
         <div class="card">
              <header class="card-header cardHeader">
                <p class="card-header-title">Edit Unit</p>
              </header>
              <div class="card-content">
           <div class="card">
              <header class="card-header cardHeader">
                <p class="card-header-title">Unit Information</p>
              </header>
              <div class="card-content">
                <div class="columns is-multiline">
                  <div class="column is-6">
                    <div class="field">
                      <b-field label="Arabic Title">
                        <b-input v-model="unitInfo.ar_title"></b-input>
                      </b-field>
                    </div>
                  </div>
                  <div class="column is-6">
                    <div class="field">
                      <b-field label="English Title">
                        <b-input v-model="unitInfo.en_title"></b-input>
                      </b-field>
                    </div>
                  </div>
                  <div class="column is-6">
                    <div class="field">
                      <b-field label="Arabic Description">
                        <b-input v-model="unitInfo.ar_description" maxlength="200" type="textarea"></b-input>
                      </b-field>
                    </div>
                  </div>
                  <div class="column is-6">
                    <div class="field">
                      <b-field label="English Description">
                        <b-input v-model="unitInfo.en_description" maxlength="200" type="textarea"></b-input>
                      </b-field>
                    </div>
                  </div>
                </div>
              </div>
          </div>

           <div class="card">
              <header class="card-header cardHeader">
                <p class="card-header-title">Lead Information</p>
              </header>
              <div class="card-content">
                <div class="columns is-multiline">
                <div class="column is-6">
                  <b-field label="Lead">
                      <b-select v-model="unitInfo.lead_id">
                          <option :value="lead.id" v-for="lead in leads" :key="lead.id">{{lead.first_name}} {{lead.last_name}}</option> 
                        </b-select>
                  </b-field>
                </div>
                <div class="column is-6">
                  <div class="field">
                      <b-field label="Phone">
                        <b-input  type="number" v-model="unitInfo.lead_phone"></b-input>
                      </b-field>
                    </div>
                </div>
                </div>
              </div>
          </div>

           <div class="card">
              <header class="card-header cardHeader">
                <p class="card-header-title">Unit Description</p>
              </header>
              <div class="card-content">
                <div class="columns is-multiline">
                  <div class="column is-4">
                    <b-field label="Type">
                      <b-select v-model="unitInfo.type">
                          <option value="commercial">Commercial</option>
                          <option value="personal">Residential</option>
                      </b-select>
                    </b-field>
                  </div>
                  <div class="column is-4">
                    <b-field label="Unit Type">
                        <b-select v-model="unitInfo.unitTypes">
                          <option :value="type.id" v-for="type in unitTypes" :key="type.id">{{type.en_name}}</option> 
                        </b-select>
                    </b-field>
                  </div>
                  <div class="column is-4">
                    <b-field label="Project">
                        <b-select v-model="unitInfo.project_id">
                            <option :value="project.id" v-for="project in projects" :key="project.id">
                              {{project.en_name}}
                            </option>
                        </b-select>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Rent">
                        <b-numberinput type="is-info" v-model="unitInfo.rent" min="0">
                        </b-numberinput>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Area">
                        <b-numberinput type="is-info" v-model="unitInfo.area" min="0">
                        </b-numberinput>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Rooms">
                        <b-numberinput type="is-info" v-model="unitInfo.rooms" min="0">
                        </b-numberinput>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Bathrooms">
                        <b-numberinput type="is-info" v-model="unitInfo.bathrooms" min="0">
                        </b-numberinput>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Floors">
                        <b-numberinput type="is-info" v-model="unitInfo.floors" min="0">
                        </b-numberinput>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Delivery Date">
                      <b-select v-model="unitInfo.delivery_date">
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
                      </b-select>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Finishing">
                      <b-select v-model="unitInfo.finishing">
                          <option value="finished">Finished</option>
                          <option value="semi_finished">Semi Finished</option>
                          <option value="not_finished">Not Finished</option>
                      </b-select>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="View">
                      <b-select v-model="unitInfo.view">
                        <option v-for="view in views" :key="view.id" :value="view.id">{{view.name}}</option>
                      </b-select>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <div class="field">
                      <b-field label="Meta Keywords">
                        <b-input v-model="unitInfo.meta_keywords"></b-input>
                      </b-field>
                    </div>
                  </div>
                  <div class="column is-6">
                    <div class="field">
                      <b-field label="Meta Description">
                        <b-input v-model="unitInfo.meta_description" maxlength="200" type="textarea"></b-input>                        
                      </b-field>
                    </div>
                  </div>
                  <div class="column is-6">
                    <b-field label="Facility">
                      <div class="field">
                          <multiselect v-model="unitInfo.facilities" :close-on-select="false" placeholder="Select Facility" label="en_name" track-by="id" value="id" :options="allFacilities" :multiple="true" :taggable="true"></multiselect>
                      </div>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Location on Map">
                      <div class="field">
                        <b-select v-model="unitInfo.location">
                          <option v-for="location in allLocations" :key="location.id" :value="location.id">{{location.en_name}}</option>
                        </b-select>
                      </div>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="English Address">
                      <b-input v-model="unitInfo.en_address"></b-input>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Arabic Address">
                      <b-input v-model="unitInfo.ar_address"></b-input>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Image">
                    <div class="field" style="display: flex">
                      <b-upload v-model="unitInfo.image" accept="image">
                          <a class="button is-primary">
                              <b-icon icon="upload"></b-icon>
                              <span>Click to upload</span>
                          </a>
                      </b-upload>
                      <span class="file-name" v-if="unitInfo.image">
                          {{ unitInfo.image.name }}
                      </span>
                      </div>
                    </b-field>
                  </div>
                  <div class="column is-6">
                    <b-field label="Other Images">
                      <b-upload v-model="unitInfo.other_images"
                          accept="image"
                          multiple
                          drag-drop>
                          <section class="section">
                              <div class="content has-text-centered">
                                  <p>
                                      <b-icon
                                          icon="upload"
                                          size="is-large">
                                      </b-icon>
                                  </p>
                                  <p>Drop your files here or click to upload</p>
                              </div>
                          </section>
                      </b-upload>
                    </b-field>
                    <div class="tags">
                        <span v-for="(file, index) in unitInfo.other_images"
                            :key="index"
                            class="tag is-primary" >
                            {{file.name}}
                            <button class="delete is-small"
                                type="button"
                                @click="deleteDropFile(index)">
                            </button>
                        </span>
                    </div>
                  </div>
                  
                </div>
              </div>
          </div>
          </div>
          <footer class="card-footer cardHeader" style="padding: 1rem">
            <b-button type="is-info" @click="editRental">Save</b-button>
          </footer>
          </div>
         </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import Multiselect from 'vue-multiselect'
import {
    getUnitTypes,
    getPublicData,
    getRentalEditData,
    editRental
} from './../../calls'

export default {
  name: "EditRentalUnit",

  data() {
    return {
      unitInfo: {},
      unitTypes: [],
      projects: [],
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
    allFacilities: [],
    allLocations: [],
    csrf: window.auth_user.csrf,
    id: null
    };
  },

  components: {
    Multiselect
  },

  watch: {},
  created() {
    this.id = this.$route.params.id
    this.getData();
  },
  mounted() {
    this.getUnitTypes();
    this.getPublic();
  },

  computed: {},

  methods: {
    getData(loading = true){
        this.isLoading = loading
        getRentalEditData(this.id).then(response=>{
            const unit = response.data.unit
            var unitInfo = {}
            this.unitInfo = Object.assign(unitInfo,unit);
            this.leads = response.data.leads
            this.allFacilities = response.data.allFacilities
            this.allLocations = response.data.allLocations
            console.log(this.unitInfo)
            // this.isLoading = false
        })    
        .catch(error => {
            console.log(error)
        })
    },
    getUnitTypes() {
      getUnitTypes({
          usage: this.unitInfo.type,
          _token: this.token
      }).then(response => {
          this.unitTypes = response.data
      })
      .catch(error => {
          console.log(error)
      })
    },

    getPublic() {
      getPublicData().then(response => {
          this.locations = response.data.locations
          this.projects = response.data.projects
          this.districts = response.data.districts
          this.cities = response.data.cities
          // console.log(response.data.projects)
      })
      .catch(error => {
          console.log(error)
      })
    },

    deleteDropFile(index) {
      this.unitInfo.other_images.splice(index, 1)
    },

    // editRental() {
    //   const bodyFormData = new FormData();
    //     for (const key in this.unitInfo) {
    //       const value = this.unitInfo[key];
    //       bodyFormData.set(key, value);
    //     }
    // }
    editRental() {
      const bodyFormData = new FormData();
      bodyFormData.append("_token",this.csrf);
      const data = this.unitInfo
      const other_images = this.unitInfo.other_images;
      console.log(other_images);
      Object.keys(data).forEach(function(key) {
          bodyFormData.append(key,data[key]);
          // console.log(key, data[key]);
      });
      bodyFormData.append("id",this.id);
      bodyFormData.delete('other_images');
      if(this.unitInfo.other_images != null){
        for (var i = 0; i < other_images.length; i++) {
            bodyFormData.append('other_images[]', other_images[i]);
        }
      }
    
      editRental(bodyFormData).then(response=>{
          console.log(response)
          this.isLoading = false
          this.success('Updated')
          // window.location.href = "/admin/lead_summaries#/1"
      })
      .catch(error => {
          this.errorDialog();
          console.log(error)
      })
    },
    errorDialog() {
        this.$dialog.alert({
            title: 'Error',
            message: 'Please make sure to provide the required Inputs',
            type: 'is-danger',
        })
    },
    success(action) {
        this.$toast.open({
            message: 'Resale Units '+action+' Successfully',
            type: 'is-success',
            position: 'is-bottom',
            duration: 5000,
        })
    },
  }
};
</script>

<style>
.select,
.select select{
  width: 100%;
}
</style>
