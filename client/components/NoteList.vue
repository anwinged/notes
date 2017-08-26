<template>
  <article>
    <router-link :to="{ name: 'note_create' }">Create</router-link>
    <hr>
    <template v-for="note in notes">
      <section class="note-preview">
        <span>{{ note.id }}, {{ note.updatedAt }}</span>
        <div v-html="note.html"></div>
        <router-link v-if="!note.draft" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link> /
        <router-link :to="{ name: 'note_edit', params: { id: note.id }}">Edit</router-link>
      </section>
    </template>
  </article>
</template>

<script>
export default {
  name: 'note-list',
  computed: {
    notes() {
      return this.$store.getters.newest;
    },
  },
}
</script>

<style scoped>
  .note-preview {
    padding-top: 20px;
    padding-bottom: 20px;
    position: relative;
  }
  .note-id {
    position: absolute;
    top: 0;
    left: -45px;
    color: #bbb;
  }
  .note-preview + .note-preview {
    border-top: 1px solid #ccc;
  }
</style>
