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
        // beforeRouteEnter (to, from, next) {
        // const answer = window.confirm('Are you sure you want to leave?')
        // if (answer) {
        //     next('/Preview')
        // } else {
        //     next(false)
        // }
        // }
    },
    {
        path: '/forms/create/',
        name: 'NewForm',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: FormBuilder
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
});

export { VueRouter, router, routes };
