<template>
  <form>
    <button v-on:click="save">Save</button> /
    <router-link v-if="this.id" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
    <router-link :to="{ name: 'note_index' }">Index</router-link>
    <textarea v-model="note.source" class="input" title="Input"></textarea>
  </form>
</template>

<script>
import NoteService from '../services/NoteService';
export default {
  name: 'note-form',
  props: ['id'],
  data() {
    return {
      note: { source: '' },
    };
  },
  created: function () {
    if (this.id) {
      this.$store.dispatch('getNote', this.id).then(note => {
        this.note = note;
      });
    } else {
      this.$store.dispatch('createDraftNote').then(note => {
        this.note = note;
      });
    }
  },
  methods: {
    save: function () {
      this.$store.dispatch('saveNote', this.note).then(note => {
        this.$router.push({ name: 'note_view', params: { id: note.id }});
      });
    }
  }
}
</script>

<style scoped>
  .input {
    width: 100%;
    height: 400px;
  }
</style>
