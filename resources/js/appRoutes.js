import VueRouter from 'vue-router';

import AppFileList from './views/AppFileList';
import AppFileProfile from './views/AppFileProfile';
import AppProgramProfile from './views/AppProgramProfile';

const routes = [
    {
        path: '/', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/dashboard', component: {template: '<h2>Dashboard</h2>'}
    },
    {
        path: '/files', component: {template: '<h2>All Files</h2>'}
    },
    {
        path: '/files/:fileType', component: AppFileList,
    },
    {
        path: '/files/:fileType/:file', component: AppFileProfile,
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
