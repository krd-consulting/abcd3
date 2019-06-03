import VueRouter from 'vue-router';

import Records from '@/Preferences/views/record';
import Roles from '@/Preferences/views/role';
import Programs from '@/Preferences/views/program';

const routes = [
    { path: '/preferences', component: {template: '<h2>General</h2>'} },
    { path: '/preferences/records', component: Records },
    { path: '/preferences/programs', component: Programs },
    { path: '/preferences/roles', component: Roles }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
