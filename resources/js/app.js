/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import { store } from './store/store';
import axios from 'axios';
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated.js';
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import BalloonEditor from '@ckeditor/ckeditor5-build-balloon';
import VueCkeditor from 'vue-ckeditor5';

import FullCalendar from 'vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.css'

Vue.use(FullCalendar)

// import Reports from './components/Reports.vue'
const options = {
    editors: {
        classic: BalloonEditor,
        balloon: BalloonEditor
    },
    name: 'ckeditor'
};

Vue.use(VueCkeditor.plugin, options);
Vue.use(VueRouter);
// Vue.use(FullCalendar);
Vue.use(VueInternationalization);

if (localStorage.getItem('access_token')) {
    window.axios.defaults.headers.common['Authorization'] =
        'Bearer ' + localStorage.getItem('access_token');
}

Vue.mixin({
    methods: {
        isTrainee(user) {
            return user.role === 'trainee';
        }
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (localStorage.getItem('access_token')) {
    window.axios.defaults.headers.common['Authorization'] =
        'Bearer ' + localStorage.getItem('access_token');
}

Vue.component(
    'report',
    require('./components/layouts/reports/Report2Component')
);
Vue.component('subject', require('./components/subjects/Subject'));
Vue.component('review', require('./components/reviews/Review'));

const i18n = new VueInternationalization({
    locale: document.documentElement.lang,
    messages: Locale,
    silentTranslationWarn: true
});

const app = new Vue({
    el: '#app',
    i18n,
    store: store
});
