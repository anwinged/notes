<template>
  <div class="component">
    <div class="content">
      <loader v-if="loading"></loader>
      <not-found v-if="missed"></not-found>
      <div v-if="found">
        <router-link v-if="note.finished"
                     :to="{ name: 'note_edit', params: { note_id: note.id }}">Edit</router-link>
        <em v-if="note.draft">Draft</em>
        <code v-if="note.draft">{{ note.source }}</code>
        <div v-if="note.finished" v-html="note.html"></div>
      </div>
    </div>
  </div>
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
  watch: {
    id() {
      this.loadNote();
    }
  },
  created() {
    this.loadNote();
  },
  methods: {
    loadNote() {
      if (!this.id) {
        this.note = this.$store.getters.first;
        return;
      }
      this.$store.dispatch('getNote', this.id).then(note => {
        this.note = note;
      });
    }
  }
}
</script>

<style scoped>
  .component {
    width: 100%;
    box-sizing: border-box;
    padding: 20px;
    overflow-y: scroll;
  }
  .content {
    max-width: 600px;
    margin: 0 auto;
  }
</style>
