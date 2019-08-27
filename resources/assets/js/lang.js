import HeaderEn from './lang/en/layout/header.js'
import HeaderAr from './lang/ar/layout/header.js'



window.Vue = require('vue');
import VueI18n from 'vue-i18n'
window.Vue.use(VueI18n)


// Ready translated locale messages
const messages = {
  en: {
  	header: HeaderEn,
    soso: { hello: 'hello world' }
  },
  ar: {
  	header: HeaderAr,
    soso: { hello: 'こんにちは、世界' }
  }
}

// Create VueI18n instance with options
export const i18n = new VueI18n({
  locale: window.auth_user.locale, // set locale
  messages, // set locale messages
})