<template>
  <div class="component">
    <div class="content">
      <loader v-if="loading"></loader>
      <not-found v-if="missed"></not-found>
      <div v-if="found" class="view">
        <note-actions class="view-acts" :note="note"/>
        <note-content class="view-text" :note="note"/>
      </div>
    </div>
  </div>
</template>

<script>
import LoaderMixin from '../mixins/LoaderMixin';
import NoteContent from './NoteContent.vue';
import NoteActions from './NoteActions.vue';
export default {
  props: ['id'],
  mixins: [LoaderMixin],
  components: {
    'note-content': NoteContent,
    'note-actions': NoteActions,
  },
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

<style lang="scss" scoped>
  @import "../style/vars.scss";
  .component {
    width: 100%;
    box-sizing: border-box;
    padding: 20px;
  }
  .content {
    max-width: 600px;
    margin: 0 auto;
  }
  .view {
    position: relative;
  }
  .view-text {
    margin-right: 85px;
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
