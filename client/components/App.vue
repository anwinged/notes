<template>
  <div class="application">
    <ul>
      <li v-for="note in notes">
        {{ note.title }}
      </li>
    </ul>
  </div>
</template>

<script>
import NoteService from '../services/NoteService';

export default {
  name: 'app',
  data() {
    return {
      notes: [],
    };
  },
  created: function () {
    (new NoteService).getNotes().then(d => {
      this.notes = d;
    });
  },
}
</script>

<style scoped>
  .application {
    box-sizing: border-box;
    width: 100%;
    margin-top: 60px;
    margin-bottom: 40px;
  }
</style>
