import Vue from 'vue';
import VueRouter from 'vue-router'
import NoteList from './components/NoteList.vue'
import NoteView from './components/NoteView.vue'
import NoteForm from './components/NoteForm.vue'
import NotFound from './components/NotFound.vue'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'note_index' ,
        component: NoteList,
    },
    {
        path: '/notes/create',
        name: 'note_create' ,
        component: NoteForm,
    },
    {
        path: '/notes/:id/edit',
        name: 'note_edit',
        component: NoteForm,
        props: true,
    },
    {
        path: '/notes/:id',
        name: 'note_view',
        component: NoteView,
        props: true,
    },
    {
        path: '*',
        name: 'not_found',
        component: NotFound,
    }
];

const router = new VueRouter({
    routes,
});

export default router;
