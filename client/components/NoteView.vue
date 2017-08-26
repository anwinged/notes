<template>
  <article>
    <loader v-if="loading"></loader>
    <not-found v-if="missed"></not-found>
    <section v-if="found">
      <router-link v-if="!note.draft" :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link> /
      <router-link :to="{ name: 'note_index' }">Index</router-link>
      <em v-if="note.draft">Draft</em>
      <code v-if="note.draft">{{ note.source }}</code>
      <div v-if="!note.draft" v-html="note.html"></div>
    </section>
  </article>
</template>

<script>
import LoaderMixin from '../mixins/LoaderMixin';
export default {
  props: ['id'],
  mixins: [LoaderMixin],
  data() {
    return {
      note: 'loading',
    };
  },
  computed: {
    loadingItem() {
      return this.note;
    },
  },
  created() {
    this.$store.dispatch('getNote', this.id).then(note => {
      this.note = note;
    });
  },
}
</script>
