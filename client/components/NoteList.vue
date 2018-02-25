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
};
</script>

<style lang="scss" scoped>
@import '../style/vars.scss';
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
</style>
