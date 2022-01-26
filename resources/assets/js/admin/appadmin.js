
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import Structure from './Views/Structure';
import Members from './Views/Members';

Vue.component('search-bar', require('./../default/Components/SearchBar').default);

const router = new VueRouter({
    mode: 'history',
    base: '/doc/admin',
    routes: [
        { path: '/', redirect: '/structure'},
        { path: '/structure', component: Structure, name: 'structure' },
        { path: '/members', component: Members, name: 'members' },
    ]  
})

new Vue(Vue.util.extend({ router })).$mount('#app');
