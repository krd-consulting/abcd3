import VueRouter from 'vue-router';

import Files from './views/PreferencesFiles.vue';
import Roles from './views/PreferencesRoles.vue';

const routes = [
    { path: '/preferences', component: {template: '<h2>General</h2>'} },
    { path: '/preferences/files', component: Files },
    { path: '/preferences/roles', component: Roles }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
