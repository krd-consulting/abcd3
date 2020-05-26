import '@/bootstrap';

// Components
import '@/components/base'
Vue.component('global-search', require('@/components/globalSearch.vue').default);
Vue.component('login-form', require('@/components/loginForm.vue').default);
Vue.component('profile-picture', require('@/components/profilePicture.vue').default);
Vue.component('sidebar-list', require('@/components/sidebarList.vue').default);
Vue.component('sidebar-list-item', require('@/components/sidebarListItem.vue').default);
Vue.component('user-dropdown', require('@/components/userDropdown.vue').default);

import { VueRouter, router } from './routes';
import Vuex from 'vuex';
import { store } from './store/index.js';
Vue.use(VueRouter);
Vue.use(Vuex);


const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
    	collapseSidebar: false,
        loading: true
    },
    mounted() {
        this.loading = false;
    }
});
