import VueRouter from 'vue-router';

import AppRecordList from './views/AppRecordList';
import AppRecordProfile from './views/AppRecordProfile';
import AppProgramList from './views/AppProgramList';
import AppProgramProfile from './views/AppProgramProfile';

const routes = [
    {
        path: '/', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/dashboard', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/records', component: {template: '<h2>All records</h2>'}
    },
    {
        path: '/records/:recordType', component: AppRecordList,
    },
    {
        path: '/records/:recordType/:record', component: AppRecordProfile,
    },
    {
        path: '/programs', component: AppProgramList,
    },
    {
        path: '/programs/:id', component: AppProgramProfile
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
