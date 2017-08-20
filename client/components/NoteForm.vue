<template>
  <form>
    <button v-on:click="save">Save</button>
    <textarea v-model="text" class="input" title="Input"></textarea>
  </form>
</template>

<script>
import NoteService from '../services/NoteService';
export default {
  name: 'note-form',
  props: ['id'],
  data() {
    return {
      note: null,
      text: '',
    };
  },
  created: function () {
    if (this.id) {
      (new NoteService).getNote(this.id).then(d => {
        this.note = d;
        this.text = d.source;
      });
    }
  },
  methods: {
    save: function () {
      const service = new NoteService();
      if (this.id) {
        service.update(this.id, this.text);
      } else {
        service.create(this.text);
      }
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
