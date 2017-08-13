<template>
  <article>
    <div v-html="note.html"></div>
    <router-link :to="note.edit_url">Edit</router-link>
  </article>
</template>

<script>
import NoteService from '../services/NoteService';

export default {
  name: 'note-view',
  props: ['id'],
  data() {
    return {
      note: {},
    };
  },
  created() {
    (new NoteService).getNote(this.id).then(d => {
      this.note = d;
      this.note.edit_url = '/notes/' + d.id + '/edit'
    });
  },
}
</script>
