/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
import Vue from 'vue';
window.Vue = Vue;

// Importo Bootstrap-Vue
//import BootstrapVue from 'bootstrap-vue';
import VueRouter from 'vue-router';

import axios from 'axios';
import VueAxios from 'vue-axios';


import VueRx from 'vue-rx';


const $axios = {
    enableSettings: () => {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
};

/***************************************
                 VUETIFY
****************************************/

//import 'vue-component-image-cropper/dist/v-image-cropper.js';

/*
import Vuetify from 'vuetify';


const vuetifyOpts = {
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
};
*/

//Vue.use(Vuetify);
Vue.use(VueAxios, axios);
//Vue.use(BootstrapVue);
Vue.use(VueRx);
Vue.use(VueRouter);


import {
    clipperBasic,
    clipperUpload,
    clipperFixed,
    clipperPreview,
    clipperRange
} from 'vuejs-clipper';

import ImageCropper from 'vue-component-image-cropper/src/components/CropperImage.vue';
//import CropperModal from 'vue-component-image-cropper/src/components/CropperModal.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("clipper-basic", clipperBasic);
Vue.component("clipper-upload", clipperUpload);
Vue.component("clipper-fixed", clipperFixed);
Vue.component("clipper-preview", clipperPreview);
Vue.component("clipper-range", clipperRange);



Vue.component('v-image-cropper', ImageCropper);
//Vue.component("v-image-cropper-modal", CropperModal);




//Vue.component('v-toast-editor', require('./components/ToastEditorComponent.vue').default);
//Vue.component('v-toast-viewer', require('./components/ToastViewerComponent.vue').default);


const app = new Vue({
    //vuetify: new Vuetify(vuetifyOpts),
    el: '#app',
});
