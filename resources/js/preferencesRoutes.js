import VueRouter from 'vue-router';

import Records from './views/PreferencesRecords.vue';
import Roles from './views/PreferencesRoles.vue';

const routes = [
    { path: '/preferences', component: {template: '<h2>General</h2>'} },
    { path: '/preferences/records', component: Records },
    { path: '/preferences/roles', component: Roles }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };