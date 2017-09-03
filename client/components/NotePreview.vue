<template>
  <section class="note-preview">
    <header class="header">
      <span>{{ note.id }}, {{ note.updatedAt }}</span>
      <nav>
        <router-link :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link>
        <router-link v-if="!note.draft" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
      </nav>
    </header>
    <div v-html="note.html"></div>
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
    border-top: 1px solid #ccc;
  }
  .header {
    display: flex;
    justify-content: space-between;
  }
</style>
