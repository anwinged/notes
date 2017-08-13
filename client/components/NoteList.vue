<template>
  <article>
    <template v-for="note in notes">
      <section>
        <h2>
          <router-link :to="note.url">{{ note.title }}</router-link>
        </h2>
        <div v-html="note.html"></div>
      </section>
    </template>
  </article>
</template>

<script>
import NoteService from '../services/NoteService';
export default {
  name: 'note-list',
  data() {
    return {
      notes: [],
    };
  },
  created: function () {
    (new NoteService).getNotes().then(d => {
      this.notes = d.map(n => {
        return Object.assign({},  n, { url: '/notes/' + n.id });
      });
    });
  },
}
</script>
