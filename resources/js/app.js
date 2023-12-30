require('./bootstrap');

require('alpinejs');

import Vue from 'vue';
console.log(`Vue version : ${Vue.version}`);
import VueRouter from "vue-router";

window.Vue = Vue;

// eslint-disable-next-line no-unused-vars
import axios from 'axios';
import store from './store/index';

Vue.use(VueRouter);

// draggable
import rawDisplayer from "./utilities/infra/raw-displayer.vue";

// Windows Notify
window.events = new Vue();

window.noty = function(notification) {
    window.events.$emit('notification', notification)
}

window.handleErrors = function(error) {
    if(error.response.status === 422) {
        window.noty({
            message: 'You have validation errors. Try Again.',
            type: 'danger'
        })
    }

    window.noty({
        message: 'Something went wrong. Please refresh the page.',
        type: 'danger'
    })
}

import Form from "./utilities/Form";
window.Form = Form;

import router from './routes';

import moment from 'moment'

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YY HH:mm')
    }
})

var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
});

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/fr';

// necessaire pour rendre un modal draggable (doit d'abord être installé: 'npm install --save jquery-ui-dist')
import 'jquery-ui-dist/jquery-ui';

import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

/**
 *  Added 2021-08-27 for b-table
 */
import PortalVue from 'portal-vue'
Vue.use(PortalVue)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import Buefy from 'buefy'
//import 'buefy/dist/buefy.css'
Vue.use(Buefy)

//import BuefyColor from 'buefy/src/utils/color'

/**
 * end Added
 */

/**
 * Added laravel-permission-to-vuejs
 */
// eslint-disable-next-line no-unused-vars
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
//Vue.use(LaravelPermissionToVueJS)
/**
 * end Added
 */

import Permissions from './mixins/Permissions';
Vue.mixin(Permissions);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('person-index', require('./views/persons/index').default);

Vue.component('vue-noty', require('./components/Noty').default);
Vue.component('vue-login', require('./views/Login').default);
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
Vue.component('vue-ctk-date-time-picker', window['vue-ctk-date-time-picker']);
Vue.component('vue-dtpicker', require('./components/vueDTpicker').default);
Vue.component('vue2-datepicker', require('vue2-datepicker').default);
Vue.component('vue-datepicker', require('vuejs-datepicker').default);

Vue.component('dashboard-index', require('./views/dashboard/index').default);
Vue.component("rawDisplayer", rawDisplayer);

Vue.component("systems-index", require("./views/systems/index").default);
Vue.component('reportsetting-index', require('./views/reportsettings/index').default);
Vue.component('user-show', require('./views/users/show').default);

Vue.component('subject-create', require('./views/subjects/addupdate').default);
Vue.component('subject-details', require('./views/subjects/details').default);

Vue.component('times-circle', require('./components/Icons/TimesCircle').default);
Vue.component('select-angle', require('./components/Form/SelectAngle').default);

Vue.component('search-pagination', require('./components/Search/SearchPagination').default);
Vue.component('search-form', require('./components/Search/SearchForm').default);
Vue.component('search-results', require('./components/Search/SearchResults').default);

Vue.component('report-index', require('./views/reports/index').default);
Vue.component('report-addupdate', require('./views/reports/addupdate').default);
Vue.component('reports-details', require('./views/reports/details').default);

Vue.component('accessaccount-index', require('./views/accessaccounts/index').default);
Vue.component('accessaccount-list', require('./views/accessaccounts/list').default);
Vue.component('reportserver-index', require('./views/reportservers/index').default);

Vue.component('reportfile-item', require('./views/reportfiles/item').default);
Vue.component('reportfile-index', require('./views/reportfiles/list').default);
Vue.component('reportattribute-index', require('./views/modelattributes/list').default);
Vue.component('collectedreportfile-item', require('./views/collectedreportfiles/item').default);
Vue.component('dynamicattribute-item', require('./views/dynamicattributes/item').default);

Vue.component('reporttreatment-list', require('./views/reporttreatments/list').default);
Vue.component('reporttreatment-item', require('./views/reporttreatments/item').default);
Vue.component('reporttreatmentstep-item', require('./views/reporttreatmentsteps/item').default);
Vue.component('treatmentoperation-item', require('./views/treatmentoperations/item').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// eslint-disable-next-line no-unused-vars
const app = new Vue({
    store,
    el: '#app',
    router,
});
