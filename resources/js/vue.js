/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
window.Vue = Vue;
Vue.config.devtools = false;

import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRx from 'vue-rx';

Vue.use(VueAxios, {
    enableSettings:() => {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
});
Vue.use(VueRx);
Vue.use(VueRouter);

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




/*

import {
    clipperBasic,
    clipperUpload,
    clipperFixed,
    clipperPreview,
    clipperRange
} from 'vuejs-clipper';
*/

//import ImageCropper from 'vue-component-image-cropper/src/components/CropperImage.vue';




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


/*
import VuejsClipper from 'vuejs-clipper';

Vue.use(VuejsClipper, {
    components: {
        //clipperBasic: true,
        clipperUpload: true,
        clipperFixed: true,
        clipperPreview: true,
        //clipperRange: true,
    }
})
 */

/*
Vue.component("clipper-basic", clipperBasic);
Vue.component("clipper-upload", clipperUpload);
Vue.component("clipper-fixed", clipperFixed);
Vue.component("clipper-preview", clipperPreview);
Vue.component("clipper-range", clipperRange);
*/





//Vue.component('v-toast-editor', require('./components/ToastEditorComponent.vue').default);
//Vue.component('v-toast-viewer', require('./components/ToastViewerComponent.vue').default);


Vue.component('v-component-image-cropper',require('vue-component-image-cropper/dist/v-cropper-image.min.js'));


const app = new Vue({
    //vuetify: new Vuetify(vuetifyOpts),
    el: '#app',
});

/** Librerías Propias **/
//import 'vue-component-image-cropper/dist/v-cropper-image.min.js';
// Image cropper

//Vue.component('v-component-image-cropper', CropperImage);


