<template>
  <div>
    <nav class="actions">
      <a v-on:click.prevent="create"
         href="#"
         title="Create new note"
      >Create new</a>
    </nav>
    <ul class="list">
      <li v-for="note in notes" :key="note.id" class="item">
        <preview :note="note"/>
      </li>
    </ul>
  </div>
</template>

<script>
import NotePreview from './NotePreview.vue';
export default {
  components: {
    preview: NotePreview,
  },
  computed: {
    notes() {
      return this.$store.getters.newest;
    },
  },
  methods: {
    create() {
      this.$store.dispatch('createDraftNote').then(note => {
        this.$router.push({
          name: 'note_edit',
          params: { id: note.id },
        });
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.actions {
  display: flex;
  justify-content: space-between;
  padding: 10px 20px;
}
.item {
  margin: 0;
  padding: 0;
  border-top: 1px solid #bbb;
}
</style>
