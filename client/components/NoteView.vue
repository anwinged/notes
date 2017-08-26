<template>
  <article>
    <router-link v-if="!note.draft" :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link> /
    <router-link :to="{ name: 'note_index' }">Index</router-link>
    <em v-if="note.draft">Draft</em>
    <code v-if="note.draft">{{ note.source }}</code>
    <div v-if="!note.draft" v-html="note.html"></div>
  </article>
</template>

<script>
export default {
  name: 'note-view',
  props: ['id'],
  data() {
    return {
      note: {},
    };
  },
  created() {
    this.$store.dispatch('getNote', this.id).then(note => {
      this.note = note;
    });
  },
}
</script>
