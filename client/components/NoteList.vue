<template>
  <ul class="list">
    <li v-for="note in notes" :key="note.id" class="item">
      <preview :note="note"/>
    </li>
  </ul>
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
}
</script>

<style lang="scss" scoped>
  .list {
    list-style: none;
    margin: 0;
    padding: 0;
    overflow-y: scroll;
  }
  .item {
    margin: 0;
    padding: 0;
    &:not(:first-child) {
      border-top: 1px solid #bbb;
    }
  }
</style>
