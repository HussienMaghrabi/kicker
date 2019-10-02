require('./bootstrap');

window.Vue = require('vue');
import Element from 'element-ui'
import FormWizard from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import locale from 'element-ui/lib/locale/lang/en'
window.Vue.use(Element, { locale })
window.Vue.use(FormWizard);

import VueRouter from 'vue-router';
import VueDragTree from 'vue-drag-tree'
import 'vue-drag-tree/dist/vue-drag-tree.min.css'

Vue.use(VueDragTree)
import { routes } from './routes';
window.Vue.use(VueRouter);
import App from './components/App.vue' 


import { i18n } from './lang'


const $ = require('jquery');
// We declare it globally
window.$ = $;

import Buefy from 'buefy'
window.Vue.use(Buefy)
import { Datetime } from 'vue-datetime';
import { FunctionalCalendar } from 'vue-functional-calendar';


window.Vue.component('datetime', Datetime);

import VueGoodWizard from 'vue-good-wizard';

Vue.use(VueGoodWizard);

import 'vue-googlemaps/dist/vue-googlemaps.css'
import * as VueGoogleMaps from "vue2-google-maps";
// import * as VueGoogleMaps from "vue2-google-maps"

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyCJ67H5QBLVTdO2pnmEmC2THDx95rWyC1g",
    libraries: "places" // necessary for places input
  }
})

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );


import DaySpanVuetify from 'dayspan-vuetify';
window.Vue.use(DaySpanVuetify,{
  methods: {
    getDefaultEventColor: () => '#1976d2'
  }
})

const router = new VueRouter({
  mode: 'history',
  routes,
});

// This callback runs before every route change, including on page load.
router.beforeEach((to, from, next) => {
  // This goes through the matched routes from last to first, finding the closest route with a title.
  // eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
  const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

  // Find the nearest route element with meta tags.
  const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
  const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

  // If a route with a title was found, set the document (page) title to that value.
  if(nearestWithTitle) document.title = nearestWithTitle.meta.title;

  // Remove any stale meta tags from the document using the key attribute we set below.
  Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

  // Skip rendering meta tags if there are none.
  if(!nearestWithMeta) return next();

  // Turn the meta tag definitions into actual elements in the head.
  nearestWithMeta.meta.metaTags.map(tagDef => {
    const tag = document.createElement('meta');

    Object.keys(tagDef).forEach(key => {
      tag.setAttribute(key, tagDef[key]);
    });

    // We use this to track which meta tags we create, so we don't interfere with other ones.
    tag.setAttribute('data-vue-router-controlled', '');

    return tag;
  })
  // Add the meta tags to the document head.
  .forEach(tag => document.head.appendChild(tag));

  next();
});

new Vue({
    el: '#app3',
    router,
    i18n,
    template: '<App/>',
    components: { App },

  }) 

