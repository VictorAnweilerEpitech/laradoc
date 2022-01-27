import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue)


Vue.component('search-bar', require('./../default/Components/SearchBar').default);

import Structure from './Views/Structure';
import Members from './Views/Members';
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
