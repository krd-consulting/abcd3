import './bootstrap';

import vue from 'vue';
import VueRouter from 'vue-router';
import ElementUI from 'element-ui';
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'

window.Vue = vue;

Vue.use(VueRouter);
Vue.use(ElementUI);
Vue.use(VueGoodTablePlugin);

// Components
Vue.component('base-button', require('./components/BaseButton.vue'));
Vue.component('base-checkbox', require('./components/BaseCheckbox.vue'));
Vue.component('base-container', require('./components/BaseContainer.vue'));
Vue.component('base-header', require('./components/BaseHeader.vue'));
Vue.component('base-icon', require('./components/BaseIcon.vue'));
Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('base-menu', require('./components/BaseMenu.vue'));
Vue.component('base-menu-item', require('./components/BaseMenuItem.vue'));
Vue.component('base-sidebar', require('./components/BaseSidebar.vue'));
Vue.component('base-submenu', require('./components/BaseSubmenu.vue'));
Vue.component('base-switch', require('./components/BaseSwitch.vue'));
Vue.component('live-edit-text', require('./components/LiveEditText.vue'));
Vue.component('sidebar-list', require('./components/SidebarList.vue'));
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue'));

// Views
import Files from './views/PreferencesFiles.vue';
import Roles from './views/PreferencesRoles.vue';

const routes = [
    { path: '/preferences', component: {template: '<h2>General</h2>'} },
    { path: '/preferences/files', component: Files },
    { path: '/preferences/roles', component: Roles }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router
});
