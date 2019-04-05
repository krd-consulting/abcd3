import VueRouter from 'vue-router';

import AppRecordList from './views/AppRecordList';
import AppRecordProfile from './views/AppRecordProfile';
import AppRecordProfilePrograms from './views/AppRecordProfilePrograms';
import AppRecordProfileSummary from './views/AppRecordProfileSummary';
import AppProgramList from './views/AppProgramList';
import AppProgramProfile from './views/AppProgramProfile';
import AppProgramProfileGroups from './views/AppProgramProfileGroups';
import AppProgramProfileRecords from './views/AppProgramProfileRecords';
import AppProgramProfileSummary from './views/AppProgramProfileSummary';
import AppGroupList from './views/AppGroupList';
import AppGroupProfile from './views/AppGroupProfile';

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
        children: [
            { path: '', name: 'record_profile_summary', component: AppRecordProfileSummary },
            { path: 'programs', name: 'record_profile_programs', component: AppRecordProfilePrograms }
        ]
    },
    {
        path: '/programs', component: AppProgramList
    },
    {
        path: '/programs/:program', component: AppProgramProfile,
        children: [
            { path: '', name: 'program_profile_summary', component: AppProgramProfileSummary },
            { path: 'groups', name: 'program_profile_groups', component: AppProgramProfileGroups },
            { path: 'records/:recordType', name: 'program_profile_records', component: AppProgramProfileRecords },
        ]
    },
    {
        path: '/groups', component: AppGroupList
    },
    {
        path: '/groups/:group', component: AppGroupProfile,
        children: [
            { path: '', name: 'group_profile_summary', component: AppProgramProfileSummary },
            //{ path: 'groups', name: 'program_profile_groups', component: AppProgramProfileGroups },
            //{ path: 'records/:recordType', name: 'program_profile_records', component: AppProgramProfileRecords },
        ]
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
