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
Vue.component('base-container', require('./components/BaseContainer.vue'));
Vue.component('base-checkbox', require('./components/BaseCheckbox.vue'));
Vue.component('base-header', require('./components/BaseHeader.vue'));
Vue.component('base-icon', require('./components/BaseIcon.vue'));
Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('base-menu', require('./components/BaseMenu.vue'));
Vue.component('base-menu-item', require('./components/BaseMenuItem.vue'));
Vue.component('base-pagination', require('./components/BasePagination.vue'));
Vue.component('base-sidebar', require('./components/BaseSidebar.vue'));
Vue.component('base-submenu', require('./components/BaseSubmenu.vue'));
Vue.component('file-list', require('./components/FileList.vue'));
Vue.component('global-search', require('./components/GlobalSearch.vue'));
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('profile-picture', require('./components/ProfilePicture.vue'));
Vue.component('sidebar-list', require('./components/SidebarList.vue'));
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue'));
Vue.component('records-list-item-options', require('./components/RecordsListItemOptions.vue'));
Vue.component('user-dropdown', require('./components/UserDropdown.vue'));

// Views
import AppFileList from './views/AppFileList';
import AppProgramList from './views/AppProgramList';

const routes = [
    {
        path: '/', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/dashboard', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/files', component: {template: '<h2>All Files</h2>'}
    },
    {
        path: '/files/:id', component: AppFileList,
    },
    {
        path: '/programs/:id', component: AppProgramList
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
    }
});
