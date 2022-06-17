
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */
import Vue from 'vue'
import { BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import Vuetify from 'vuetify'
import vuetify_css from 'vuetify/dist/vuetify.min.css';
//import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VueFontAwesomeCss from 'vue-fontawesome-css'

library.add(fas)
library.add(fab)
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.use(VueFontAwesomeCss)


import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

import { Settings } from 'luxon'

Settings.defaultLocale = 'en'

import Vuex from 'vuex'
import store from './store/store.js'


import * as mutations from './store/mutation-types'

Vue.config.productionTip = false

import { mapGetters } from 'vuex'
Vue.use(Vuetify);

Vue.mixin({
  methods: {
    isArray: theArray => str.charAt(0).toUpperCase() + str.slice(1)
  }
})

import {ClientTable, Event} from 'vue-tables-2';
Vue.use(ClientTable);

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons)
var debounce = require('lodash.debounce');
//const Event = ClientTable.Event // import eventbus
import 'vue-select/dist/vue-select.css';
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
import VueCharts from 'vue-chartjs'
import { Bar, Line } from 'vue-chartjs'
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

Vue.use(VueCharts);
 Vue.use(Bar);
 Vue.use(Line);

Vue.use(VueMoment, {
    moment,
})
Vue.use(Vuex);
Vue.use(Datetime)
Vue.component('snackbar', require('./components/SnackBarComponent.vue'));
require('spark-bootstrap');
require('./components/bootstrap');
require('./bootstrap');
import withSnackbar from './components/mixins/withSnackbar'

Spark.forms.register = {
    team_name: '',
    league_name: '',
	short_name: '',
    invite_code: ''
};


var app = new Vue({
    mixins: [require('spark'),withSnackbar],
	store,

});
