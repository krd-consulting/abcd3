import './bootstrap';

import vue from 'vue';
window.Vue = vue;

Vue.component('base-button', require('./components/BaseButton.vue'));
Vue.component('base-icon', require('./components/BaseIcon.vue'));
Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('records-list', require('./components/RecordsList.vue'));
Vue.component('records-list-item', require('./components/RecordsListItem.vue'));
Vue.component('records-list-item-options', require('./components/RecordsListItemOptions.vue'));
Vue.component('user-dropdown', require('./components/UserDropdown.vue'));

const app = new Vue({
    el: '#app'
});
