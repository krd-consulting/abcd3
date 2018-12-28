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
Vue.component('live-edit-text', require('./components/LiveEditText.vue').default);
Vue.component('scope-tag', require('./components/ScopeTag.vue').default);
Vue.component('sidebar-list', require('./components/SidebarList.vue').default);
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue').default);

import { VueRouter, router } from './preferencesRoutes';
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router
});
