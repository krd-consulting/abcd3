import './bootstrap';

import vue from 'vue';
window.Vue = vue;

Vue.component('base-input', require('./components/BaseInput.vue'));
Vue.component('base-button', require('./components/BaseButton.vue'));
Vue.component('login-form', require('./components/LoginForm.vue'));
Vue.component('user-dropdown', require('./components/UserDropdown.vue'));

const app = new Vue({
    el: '#app'
});
