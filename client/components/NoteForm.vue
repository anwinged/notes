<template>
  <form>
    <textarea v-model.trim="text" class="input"></textarea>
    <button>Save</button>
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
}
</script>

<style scoped>
  .input {
    width: 100%;
    height: 400px;
  }
</style>
