<template>
  <form>
    <button v-on:click="save">Save</button> /
    <router-link v-if="this.id" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
    <router-link v-if="this.id" :to="{ name: 'note_index' }">Index</router-link>
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
      (new NoteService).getNote(this.id).then(note => {
        this.note = note;
      });
    } else {
      this.note = { source: '' };
    }
  },
  methods: {
    save: function () {
      const service = new NoteService();
      const response = this.id
        ? service.update(this.note)
        : service.create(this.note)
      ;
      response.then(note => {
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
