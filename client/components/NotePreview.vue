<template>
  <section class="note-preview">
    <header class="header">
      <nav class="actions">
        <router-link class="action" v-if="!note.draft" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link>
        <router-link class="action" :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link>
      </nav>
      <span class="meta">{{ note.id }}, {{ note.updatedAt }}</span>
    </header>
    <div v-if="!note.draft" v-html="note.html"></div>
    <div v-if="note.draft" v-html="note.source"></div>
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
  .action {
    display: inline-block;
    margin-right: 0.5em;
  }
  .meta {
    color: #aaa;
  }
</style>
