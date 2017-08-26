<template>
  <section class="note-preview">
    <span>{{ note.id }}, {{ note.updatedAt }}</span>
    <div v-html="note.html"></div>
    <router-link v-if="!note.draft" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
    <router-link :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link>
  </section>
</template>

<script>
export default {
  name: 'note-preview',
  props: ['note'],
}
</script>

<style scoped>
  .note-preview {
    padding-top: 20px;
    padding-bottom: 20px;
    position: relative;
  }
</style>
