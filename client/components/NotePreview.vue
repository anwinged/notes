<template>
  <section class="note-preview" v-on:click="goToView()">
    <header class="header">
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
      const date = moment.unix(this.note.updatedAt);
      return `#${this.note.id}, ${date.fromNow()}`;
    },
  },
  methods: {
    goToView() {
      if (this.note.draft) {
        this.$router.push({ name: 'note_edit', params: { id: this.note.id }});
      } else {
        this.$router.push({ name: 'note_view', params: { id: this.note.id }});
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .note-preview {
    padding: 10px 20px;
    cursor: pointer;
  }
  .note-preview:hover {
    background-color: gainsboro;
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
    font-size: 85%;
    color: #aaa;
  }
</style>
