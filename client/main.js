import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import NoteList from './components/NoteList.vue'
import NoteView from './components/NoteView.vue'
import NoteForm from './components/NoteForm.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/', component: NoteList },
    { path: '/notes/new', component: NoteForm },
    { path: '/notes/:id/edit', component: NoteForm, props: true },
    { path: '/notes/:id', component: NoteView, props: true },
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
