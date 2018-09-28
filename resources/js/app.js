import './bootstrap';

import vue from 'vue';
window.Vue = vue;

Vue.component('base-button', require('./components/BaseButton.vue'));
Vue.component('base-icon', require('./components/BaseIcon.vue'));
Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('sidebar-list', require('./components/SidebarList.vue'));
Vue.component('sidebar-list-item', require('./components/SidebarListItem.vue'));
Vue.component('records-list-item-options', require('./components/RecordsListItemOptions.vue'));
Vue.component('user-dropdown', require('./components/UserDropdown.vue'));

const app = new Vue({
    el: '#app',
    data: {
        records: [
            { id: 1, title: 'Record 1', active: true},
            { id: 2, title: 'Record 2', options: true },
            { id: 3, title: 'Record 3' },
            { id: 4, title: 'Record 4', options: true },
            { id: 5, title: 'Record 5' }
        ]
    }
});
