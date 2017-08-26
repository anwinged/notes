<template>
  <article>
    <loader v-if="loading"></loader>
    <not-found v-if="missed"></not-found>
    <form v-if="found">
      <button v-on:click="save">Save</button> /
      <router-link v-if="this.id" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
      <router-link :to="{ name: 'note_index' }">Index</router-link>
      <textarea v-model="note.source" class="input" title="Input"></textarea>
    </form>
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
  created: function () {
    if (this.id) {
      this.$store.dispatch('getNote', this.id).then(note => {
        this.note = note;
      });
    } else {
      this.$store.dispatch('createDraftNote').then(note => {
        this.note = note;
      });
    }
  },
  methods: {
    save: function () {
      this.$store.dispatch('saveNote', this.note).then(() => {
        this.$router.push({ name: 'note_index' });
      });
    }
  }
}
</script>

<style scoped>
  .input {
    width: 100%;
    height: 400px;
  }
</style>
