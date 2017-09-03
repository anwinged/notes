<template>
  <section class="note-preview">
    <header class="header">
      <nav>
        <router-link v-if="!note.draft" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
        <router-link :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link>
      </nav>
      <span class="meta">{{ note.id }}, {{ note.updatedAt }}</span>
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
  .meta {
    color: #aaa;
  }
</style>
