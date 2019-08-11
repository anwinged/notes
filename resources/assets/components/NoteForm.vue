<template>
  <section class="editor">
    <not-found v-if="!this.note"></not-found>
    <loader v-if="note.is.preview"></loader>
    <form class="form" v-if="note.is.full">
      <textarea v-model="note.source"
                v-on:keyup.enter.ctrl="save"
                ref="input"
                class="input"
                title="Input"
                autofocus
                placeholder="Type here"
      ></textarea>
    </form>
    <form-actions v-if="note.is.full" :note="note" />
  </section>
</template>

<script>
import FormActions from './FormActions.vue';
import Loader from './Loader.vue';
import NotFound from './NotFound.vue';
import Action from '../store/actions.js';
export default {
  props: ['id'],
  components: {
    'form-actions': FormActions,
    loader: Loader,
    'not-found': NotFound,
  },
  data() {
    return {
      note: { is: { preview: true } },
    };
  },
  created: function() {
    this.load();
  },
  watch: {
    id() {
      this.load();
    },
  },
  updated() {
    if (this.$refs.input) {
      this.$refs.input.focus();
    }
  },
  methods: {
    load() {
      if (this.id) {
        if (this.note.id === this.id) {
          return;
        }
        this.note = { is: { preview: true } };
        this.$store.dispatch('getNote', this.id).then(note => {
          this.note = note;
        });
      } else {
        this.note = { is: { preview: true } };
        this.$store.dispatch(Action.CREATE_DRAFT_NOTE).then(note => {
          this.note = note;
        });
      }
    },
    save: function() {
      this.$store.dispatch('saveNote', this.note).then(note => {
        this.$router.push({
          name: 'note_view',
          params: { id: note.id },
        });
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars';
@import '../style/mixins';
.editor {
  box-sizing: border-box;
  display: flex;
}
.form {
  @include panel();
  width: 100%;
}
.input {
  margin: 0;
  box-sizing: border-box;
  width: 100%;
  height: 100vh;
  border: none;
  border-radius: 0;
  font-size: $editor-font;
  line-height: 1.5;
  padding: $gap;
  resize: none;
  @media (max-width: $width) {
    padding: 10px 10px 85px;
  }
}
</style>
