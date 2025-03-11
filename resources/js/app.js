// require('./bootstrap');

// window.Vue = require('vue').default;

// Vue.component('post-modal', require('./components/PostModalComponent.vue').default);
// Vue.component('post-item', require('./components/PostItemComponent.vue').default);


// const app = new Vue({
//     el: '#app',



// });

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import axios from 'axios';

window.Vue = Vue;

Vue.component('post-modal', require('./components/PostModalComponent.vue').default);
Vue.component('post-item', require('./components/PostItemComponent.vue').default);
Vue.component('post-list', require('./components/PostsListComponent.vue').default);
Vue.component('member-list', require('./components/MembersListComponent.vue').default);
Vue.component('contact-form', require('./components/ContactUsComponent.vue').default);

Vue.use(BootstrapVue);

// axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
Vue.prototype.$http = axios;

new Vue({
    el: '#app',
});
