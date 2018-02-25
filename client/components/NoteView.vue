<template>
  <div class="component">
    <div class="content">
      <not-found v-if="!this.note"></not-found>
      <loader v-if="note.is.preview"></loader>
      <div v-if="note.is.full" class="view">
        <note-content class="view-text" :note="note"/>
        <note-actions class="view-acts" :note="note"/>
      </div>
    </div>
  </div>
</template>

<script>
import NoteContent from './NoteContent.vue';
import NoteActions from './NoteActions.vue';
import Loader from './Loader.vue';
import NotFound from './NotFound.vue';
export default {
  props: ['id'],
  components: {
    'note-content': NoteContent,
    'note-actions': NoteActions,
    loader: Loader,
    'not-found': NotFound,
  },
  data() {
    return {
      note: { is: { preview: true } },
    };
  },
  watch: {
    id() {
      this.loadNote();
    },
  },
  created() {
    this.loadNote();
  },
  methods: {
    loadNote() {
      if (this.id && this.note.id === this.id) {
        return;
      }
      this.note = { is: { preview: true } };
      this.$store.dispatch('getOrFirst', this.id).then(note => {
        this.note = note;
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars.scss';
.component {
  width: 100%;
  box-sizing: border-box;
}
.view {
  display: flex;
}
.view-text {
  flex-grow: 1;
  @media (max-width: $width) {
    margin-right: auto;
    margin-bottom: 85px;
  }
}
.view-acts {
  flex-grow: 0;
}
</style>
