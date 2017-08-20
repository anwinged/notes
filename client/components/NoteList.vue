<template>
  <article>
    <template v-for="note in notes">
      <section class="note-preview">
        <div v-html="note.html"></div>
        <router-link :to="note.url_view">View</router-link>
        <router-link :to="note.url_edit">Edit</router-link>
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
        return Object.assign({},  n, {
          url_view: '/notes/' + n.id,
          url_edit: '/notes/' + n.id + '/edit',
        });
      });
    });
  },
}
</script>

<style scoped>
  .note-preview + .note-preview {
    margin-top: 10px;
    border-top: 1px solid #ccc;
    padding-top: 10px;
  }
</style>
