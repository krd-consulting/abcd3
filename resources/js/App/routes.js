import VueRouter from 'vue-router';

import RecordList from './views/record';
import RecordProfile from './views/record/profile';
import RecordProfilePrograms from './views/record/profile/programs';
import RecordProfileSummary from './views/record/profile/summary';
import RecordProfileGroups from './views/record/profile/groups';
import RecordProfileTeams from './views/record/profile/teams';
import ProgramList from './views/program';
import ProgramProfile from './views/program/profile';
import ProgramProfileGroups from './views/program/profile/groups';
import ProgramProfileRecords from './views/program/profile/records';
import ProgramProfileSummary from './views/program/profile/summary';
import GroupList from './views/group';
import GroupProfile from './views/group/profile';
import GroupProfileSummary from './views/group/profile/summary';
import GroupProfileRecords from './views/group/profile/records';
import TeamProfile from './views/team/profile';
import TeamProfileSummary from './views/team/profile/summary';
import TeamProfilePrograms from './views/team/profile/programs';
import TeamProfileGroups from './views/team/profile/groups';
import TeamProfileRecords from './views/team/profile/records';
import FormList from './views/form';
import FormEntryList from './views/form/entry/';
import FormEntry from './views/form/entry/create';
import FormPreview from '@/FormBuilder/views/formPreview.vue';
import FormBuilder from '@/FormBuilder/views';
import PreferencesRecords from '@/Preferences/views/record';
import PreferencesRecordsCreate from '@/Preferences/views/record/create';
import PreferencesRoles from '@/Preferences/views/role';
import PreferencesPrograms from '@/Preferences/views/program';

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
        path: '/records/:recordType', component: RecordList,
    },
    {
        path: '/records/:recordType/:record', component: RecordProfile,
        children: [
            { path: '', name: 'record_profile_summary', component: RecordProfileSummary },
            { path: 'programs', name: 'record_profile_programs', component: RecordProfilePrograms },
            { path: 'groups', name: 'record_profile_groups', component: RecordProfileGroups },
            { path: 'teams', name: 'record_profile_teams', component: RecordProfileTeams }
        ]
    },
    {
        path: '/programs', component: ProgramList
    },
    {
        path: '/programs/:program', component: ProgramProfile,
        children: [
            { path: '', name: 'program_profile_summary', component: ProgramProfileSummary },
            { path: 'groups', name: 'program_profile_groups', component: ProgramProfileGroups },
            { path: 'records/:recordType', name: 'program_profile_records', component: ProgramProfileRecords },
        ]
    },
    {
        path: '/groups', component: GroupList
    },
    {
        path: '/groups/:group', component: GroupProfile,
        children: [
            { path: '', name: 'group_profile_summary', component: GroupProfileSummary },
            { path: 'records/:recordType', name: 'group_profile_records', component: GroupProfileRecords },
        ]
    },

    {
        path: '/teams/:team', component: TeamProfile,
        children: [
            { path: '', name: 'team_profile_summary', component: TeamProfileSummary },
            { path: 'programs', name: 'team_profile_programs', component: TeamProfilePrograms },
            { path: 'groups', name: 'team_profile_groups', component: TeamProfileGroups },
            { path: 'records/:recordType', name: 'team_profile_records', component: TeamProfileRecords },
        ]
    },

    {
        path: '/forms/create/preview',
        name: 'Form Preview',
        component: FormPreview,
    },
    {
        path: '/forms/create/',
        name: 'NewForm',
        component: FormBuilder
    },
    {
        path: '/forms/', component: FormList,
    },
    {
        path: '/forms/:form/new', component: FormEntry,
    },
    {
        path: '/forms/:form', component: FormEntryList
    },

    { path: '/preferences', component: {template: '<h2>General</h2>'} },
    {
        path: '/preferences/records',
        component: PreferencesRecords,
        children: [
            {
                path: 'create',
                component: PreferencesRecordsCreate
            }
        ]
    },
    { path: '/preferences/programs', component: PreferencesPrograms },
    { path: '/preferences/roles', component: PreferencesRoles }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
