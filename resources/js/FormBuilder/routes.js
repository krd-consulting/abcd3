import VueRouter from 'vue-router';
// import Forms from './views/Forms.vue'
// import FormPreview from './views/FormPreview.vue'

import FormPreview from './views/formPreview.vue';
import FormBuilder from './views';

const routes = [
    {
        path: '/forms/create/preview',
        name: 'Form Preview',
        component: FormPreview,
    },
    {
        path: '/forms/create/',
        name: 'NewForm',
        component: FormBuilder
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
