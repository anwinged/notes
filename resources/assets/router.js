import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import NoteList from './components/NoteList.vue';
import NoteView from './components/NoteView.vue';
import NoteForm from './components/NoteForm.vue';
import NotFound from './components/NotFound.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        redirect: { name: 'note_index' },
    },
    {
        path: '/notes',
        component: Dashboard,
        props: true,
        children: [
            {
                path: '',
                name: 'note_index',
                component: NoteList,
                props: route => ({ query: route.query.q }),
            },
            {
                path: ':id',
                name: 'note_view',
                props: true,
                component: NoteView,
            },
            {
                path: ':id/edit',
                name: 'note_edit',
                props: true,
                component: NoteForm,
            },
        ],
    },
    {
        path: '*',
        name: 'not_found',
        component: NotFound,
    },
];

const router = new VueRouter({
    routes,
});

export default router;
