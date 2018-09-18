import './bootstrap';

import vue from 'vue';
window.Vue = vue;

Vue.component('user-dropdown', require('./components/UserDropdown.vue'));

const app = new Vue({
    el: '#app'
});
