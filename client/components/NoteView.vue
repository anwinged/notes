<template>
  <article>
    <div v-html="note.html"></div>
    <router-link v-if="note.id" :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link> /
    <router-link :to="{ name: 'note_index' }">Index</router-link>
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
    (new NoteService).getNote(this.id).then(note => {
      this.note = note;
    });
  },
}
</script>
