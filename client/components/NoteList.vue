<template>
  <article>
    <router-link :to="{ name: 'note_create' }">Create</router-link>
    <hr>
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
  .preview + .preview {
    border-top: 1px solid #ccc;
  }
</style>
