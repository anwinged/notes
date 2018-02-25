<template>
  <div class="note-content">
    <em v-if="note.is.draft">Draft</em>
    <code v-if="note.is.draft">{{ note.source }}</code>
    <div class="formatted" v-if="note.is.finished" v-html="note.html"></div>
  </div>
</template>

<script>
export default {
  props: ['note'],
};
</script>

<style lang="scss" scoped>
@import '../style/vars.scss';
@import '../style/mixins.scss';
.note-content {
  @include panel();
  display: block;
  padding: $gap;
  margin-bottom: $gap;
}
.formatted {
  & h1 {
    font-weight: normal;
  }
}
</style>
