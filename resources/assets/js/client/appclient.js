import Vue from 'vue'

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)

Vue.component('search-bar', require('./Components/SearchBar').default);

const router = new VueRouter({ mode: 'history'});
new Vue(Vue.util.extend({ router })).$mount('#app');

require('./../client/template').default
