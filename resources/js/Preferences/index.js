import '@/bootstrap'

// Components
import '@/components/base'
Vue.component('live-edit-text', require('@/components/liveEditText.vue').default);
Vue.component('scope-tag', require('@/components/scopeTag.vue').default);
Vue.component('sidebar-list', require('@/components/sidebarList.vue').default);
Vue.component('sidebar-list-item', require('@/components/sidebarListItem.vue').default);

import { VueRouter, router } from './routes';
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    methods: {
        toggle() {
            console.log('Toggling the menu here folks...')
        }
    }
});
