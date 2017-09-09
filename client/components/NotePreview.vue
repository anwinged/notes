<template>
  <section class="note-preview">
    <header class="header">
      <nav class="actions">
        <router-link class="action" v-if="note.finished" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link>
        <router-link class="action" :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link>
      </nav>
      <span class="meta">{{ meta }}</span>
    </header>
    <div v-if="note.finished" v-html="note.html"></div>
    <div v-if="note.draft"><p>{{ note.source }}</p></div>
  </section>
</template>

<script>
import moment from 'moment';
export default {
  name: 'note-preview',
  props: ['note'],
  computed: {
    meta() {
      if (this.note.draft) {
        return 'draft';
      }
      const date = moment.unix(this.note.createdAt);
      return `#${this.note.id}, ${date.fromNow()}`;
    },
  },
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
