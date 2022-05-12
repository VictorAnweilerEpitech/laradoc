import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)


Vue.component('search-bar', require('./../default/Components/SearchBar').default);

import Structure from './Views/Structure';
import Members from './Views/Members';

let config = JSON.parse(document.getElementById('scriptappadmin').getAttribute('config'))
const router = new VueRouter({
    mode: 'history',
    base: config.url_prefix + '/admin',
    routes: [
        { path: '/', redirect: '/structure'},
        { path: '/structure', component: Structure, name: 'structure' },
        { path: '/members', component: Members, name: 'members' },
    ]
})

Vue.prototype.$laraConfig = config

new Vue(Vue.util.extend({ router })).$mount('#app');
