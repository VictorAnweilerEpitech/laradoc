import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Bootstrap
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

// Modal
import VModal from 'vue-js-modal'
Vue.use(VModal)

// Toast
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

// VueSelect
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

const options = {};
Vue.use(Toast, options);

// Components
Vue.component('search-bar', require('./../default/Components/SearchBar').default);


// Pages
import Structure from './Views/Structure';
import Members from './Views/Members';
import StructureDocs from './Views/StructureDocs'
import StructurePageView from './Views/StructurePageView'

// Router
let config = JSON.parse(document.getElementById('scriptappadmin').getAttribute('config'))
const router = new VueRouter({
    mode: 'history',
    base: config.url_prefix + '/admin',
    routes: [
        { path: '/', redirect: '/structure/docs'},
        { path: '/structure/docs', component: StructureDocs, name: 'structure.order' },
        { path: '/structure/page/:id', component: StructurePageView, name: 'structure.page.view' },
        { path: '/structure', component: Structure, name: 'structure' },
        { path: '/members', component: Members, name: 'members' },
    ]
})

Vue.prototype.$laraConfig = config

new Vue(Vue.util.extend({ router })).$mount('#app');
