<template>
  <div class="component">
    <div class="content">
      <not-found v-if="!this.note"></not-found>
      <loader v-if="note.is.preview"></loader>
      <div v-if="note.is.full" class="view">
        <note-actions class="view-acts" :note="note"/>
        <note-content class="view-text" :note="note"/>
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
    'loader': Loader,
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
    }
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
    }
  }
}
</script>

<style lang="scss" scoped>
  @import "../style/vars.scss";
  .component {
    width: 100%;
    box-sizing: border-box;
    padding: 20px;
  }
  .view {
    position: relative;
  }
  .view-text {
    max-width: 600px;
    margin: 0 auto;
    @media (max-width: $width) {
      margin-right: auto;
      margin-bottom: 85px;
    }
  }
  .view-acts {
    top: 0;
    right: 0;
    position: fixed;
    width: 80px;
    @media (max-width: $width) {
      top: auto;
      bottom: 0;
      left: 0;
    }
  }
</style>
