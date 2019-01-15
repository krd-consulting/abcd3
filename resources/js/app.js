import './bootstrap';

import vue from 'vue';

// Plugins
import ElementUI from 'element-ui';
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'

// Vue Instance
window.Vue = vue;

Vue.use(ElementUI);
Vue.use(VueGoodTablePlugin);

// Components
import './baseComponents';
Vue.component('record-list', require('./components/RecordList.vue').default);
Vue.component('global-search', require('./components/GlobalSearch.vue').default);
Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('profile-picture', require('./components/ProfilePicture.vue').default);
Vue.component('sidebar-list', require('./components/SidebarList.vue').default);
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue').default);
Vue.component('records-list-item-options', require('./components/RecordsListItemOptions.vue').default);
Vue.component('user-dropdown', require('./components/UserDropdown.vue').default);

import { VueRouter, router } from './appRoutes.js';
Vue.use(VueRouter);


const app = new Vue({
    el: '#app',
    router,
    data: {
    }
});
