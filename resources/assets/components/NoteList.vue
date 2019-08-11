<template>
  <ul v-if="notes.length" class="list">
    <li v-for="note in notes" :key="note.id" class="item">
      <preview :note="note"/>
    </li>
  </ul>
  <div v-else class="empty-set">
    Nothing found.
  </div>
</template>

<script>
import NotePreview from './NotePreview.vue';
import Action from '../store/actions.js';
export default {
  props: ['query'],
  components: {
    preview: NotePreview,
  },
  data() {
    return {
      notes: [],
    };
  },
  created() {
    this.loadNotes();
  },
  watch: {
    query() {
      this.loadNotes();
    },
  },
  methods: {
    loadNotes() {
      if (this.query) {
        this.$store.dispatch(Action.SEARCH_NOTES, this.query).then(notes => {
          this.notes = notes;
        });
      } else {
        this.notes = this.$store.getters.newest;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars';
@import '../style/mixins';
.list {
  list-style: none;
  margin: 0 0 $gap;
  padding: 0;
}
.item {
  padding: 0;
  box-sizing: border-box;
  margin-bottom: $gap;
}
.empty-set {
  @include panel();
  padding: $gap;
}
</style>
