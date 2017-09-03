<template>
  <article>
    <nav class="actions">
      <router-link :to="{ name: 'note_create' }">Create new</router-link>
    </nav>
    <preview v-for="note in notes"
             :key="note.id"
             :note="note"
             class="preview">
    </preview>
  </article>
</template>

<script>
import NotePreview from './NotePreview.vue';
export default {
  name: 'note-list',
  components: { preview: NotePreview },
  computed: {
    notes() {
      return this.$store.getters.newest;
    },
  },
}
</script>

<style scoped>
  .actions {
    margin-bottom: 15px;
  }
  .preview + .preview {
    border-top: 1px solid #ccc;
  }
</style>
