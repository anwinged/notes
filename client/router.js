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
        children: [
            {
                path: '',
                name: 'note_index',
                components: {
                    list: NoteList,
                    view: NoteView,
                }
            },
            {
                path: 'create',
                name: 'note_create',
                components: {
                    list: NoteList,
                    view: NoteForm,
                },
            },
            {
                path: ':id',
                name: 'note_view',
                components: {
                    list: NoteList,
                    view: NoteView,
                },
                props: {
                    list: false,
                    view: true,
                },
            },
            {
                path: ':id/edit',
                name: 'note_edit',
                components: {
                    list: NoteList,
                    view: NoteForm,
                },
                props: {
                    list: false,
                    view: true,
                },
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
