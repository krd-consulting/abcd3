import '@/bootstrap';

// Components
import '@/components/base'
Vue.component('global-search', require('@/components/globalSearch.vue').default);
Vue.component('login-form', require('@/components/loginForm.vue').default);
Vue.component('profile-picture', require('@/components/profilePicture.vue').default);
Vue.component('sidebar-list', require('@/components/sidebarList.vue').default);
Vue.component('sidebar-list-item', require('@/components/sidebarListItem.vue').default);
Vue.component('user-dropdown', require('@/components/userDropdown.vue').default);

import Vuex from 'vuex';
import { store } from './store/index.js';
import draggable from 'vuedraggable';
import { VueRouter, router } from './routes';

import Initialize from './views/initialize';

Vue.use(VueRouter);

Vue.use(draggable);
Vue.use(Vuex);


const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
        collapseSidebar: true,
        loading: false,
        initialize: { 
            active: true 
        }
    },
    components: {
    	Initialize
    },

    computed: {
        title: {
            get() { return this.$store.state.title },
            set(title) { this.$store.commit('SET_TITLE', title) }, 
        },

        description: {
            get() { return this.$store.state.description },
            set(description) { this.$store.commit('SET_DESCRIPTION', description) }
        },

        team_id: {
            get() { return this.$store.state.team_id },
            set(team_id) { this.$store.commit('SET_TEAM_ID', team_id) }
        },

        scope_id: {
            get() { return this.$store.state.scope_id },
            set(scope_id) { this.$store.commit('SET_SCOPE_ID', scope_id) }
        },

        type: {
            get() { return this.$store.state.type },
            set(type) { this.$store.commit('SET_TYPE', type) }
        },

        target: {
            get() { return this.$store.state.target },
            set(target) { this.$store.commit('SET_TARGET', target) }, 
        },
    },

    methods: {
    	initializeForm(data) {
            this.title = data.name;
            this.description = data.description;
            this.team_id = data.team_id;
            this.scope_id = data.scope_id; 
            this.type = data.type;
            this.target = data.target;
        }
    },

    mounted() {
        this.loading = false;
    }
});
