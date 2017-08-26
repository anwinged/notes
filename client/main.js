import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import NoteList from './components/NoteList.vue'
import NoteView from './components/NoteView.vue'
import NoteForm from './components/NoteForm.vue'

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
        props: true
    },
    {
        path: '/notes/:id',
        name: 'note_view',
        component: NoteView,
        props: true
    },
];

const router = new VueRouter({
  routes,
});

new Vue({
  el: '#app',
  // store,
  router,
  render: h => h(App),
});
