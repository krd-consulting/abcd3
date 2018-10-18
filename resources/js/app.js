import './bootstrap';

import vue from 'vue';
import VueRouter from 'vue-router';

window.Vue = vue;

Vue.use(VueRouter);

import ElementUI from 'element-ui';

Vue.component('base-button', require('./components/BaseButton.vue'));
Vue.component('base-container', require('./components/BaseContainer.vue'));
Vue.component('base-header', require('./components/BaseHeader.vue'));
Vue.component('base-icon', require('./components/BaseIcon.vue'));
Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('base-menu', require('./components/BaseMenu.vue'));
Vue.component('base-menu-item', require('./components/BaseMenuItem.vue'));
Vue.component('base-sidebar', require('./components/BaseSidebar.vue'));
Vue.component('base-submenu', require('./components/BaseSubmenu.vue'));
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('sidebar-list', require('./components/SidebarList.vue'));
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue'));
Vue.component('records-list-item-options', require('./components/RecordsListItemOptions.vue'));
Vue.component('user-dropdown', require('./components/UserDropdown.vue'));

Vue.use(ElementUI);

const routes = [
    {
        path: '/', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/dashboard', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/records', component: {template: '<h2>All Records</h2>'}
    },
    {
        path: '/record/:id', component: {template: '<h2>Record {{ $route.params.id }}</h2>'},
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router,
    data: {
        records: [
            { id: 1, title: 'Record 1', active: true },
            { id: 2, title: 'Record 2', options: true },
            { id: 3, title: 'Record 3' },
            { id: 4, title: 'Record 4', options: true },
            { id: 5, title: 'Record 5' }
        ]
    }
});
