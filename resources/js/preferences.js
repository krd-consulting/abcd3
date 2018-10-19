import './bootstrap';

import vue from 'vue';
import VueRouter from 'vue-router';

window.Vue = vue;

Vue.use(VueRouter);

// Components
Vue.component('base-button', require('./components/BaseButton.vue'));
Vue.component('base-icon', require('./components/BaseIcon.vue'));
Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('sidebar-list', require('./components/SidebarList.vue'));
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue'));

// Views
import Files from './views/PreferencesFiles.vue';
import PermissionsAndRoles from './views/PreferencesPermissionsAndRoles.vue';

const routes = [
    { path: '/preferences', component: {template: '<h2>General</h2>'} },
    { path: '/preferences/files', component: Files },
    { path: '/preferences/roles', component: PermissionsAndRoles }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router
});
