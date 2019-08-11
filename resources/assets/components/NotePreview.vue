<template>
  <section class="note-preview" v-on:click="goToView()">
    <header class="header">
      <h2 class="title" :title="note.title">{{ note.title }}</h2>
      <span class="meta">{{ meta }}</span>
    </header>
    <div class="content" v-if="note.is.finished" v-html="note.short"></div>
    <div class="content" v-if="note.is.draft"><p>{{ note.source }}</p></div>
  </section>
</template>

<script>
import moment from 'moment';
export default {
  name: 'note-preview',
  props: ['note'],
  computed: {
    meta() {
      if (this.note.is.draft) {
        return 'draft';
      }
      const date = moment.unix(this.note.updatedAt);
      return `#${this.note.id}, ${date.fromNow()}`;
    },
  },
  methods: {
    goToView() {
      if (this.note.is.draft) {
        this.$router.push({ name: 'note_edit', params: { id: this.note.id } });
      } else {
        this.$router.push({ name: 'note_view', params: { id: this.note.id } });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars';
@import '../style/mixins';
.note-preview {
  @include panel();
  cursor: pointer;
}
.note-preview:hover {
  background-color: gainsboro;
}
.header {
  box-sizing: border-box;
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid $border-color;
  padding: ($gap / 2) $gap;
}
.title {
  font-size: 100%;
  margin: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.meta {
  font-size: 85%;
  color: #aaa;
  min-width: 150px;
  text-align: right;
}
.content {
  box-sizing: border-box;
  padding: $gap;
}
</style>
