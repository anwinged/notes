<template>
  <form class="form">
    <loader v-if="loading"></loader>
    <not-found v-if="missed"></not-found>
    <!--<nav class="actions">-->
      <!--<button v-on:click="save">Save</button>-->
      <!--<router-link v-if="note.finished" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link>-->
    <!--</nav>-->
    <form-actions v-if="found"
                  :note="note"
                  class="form-actions"
    />
    <textarea v-if="found"
              v-model="note.source"
              class="input"
              title="Input"
              autofocus
              placeholder="Type here"
    ></textarea>
  </form>
</template>

<script>
import LoaderMixin from '../mixins/LoaderMixin';
import FormActions from './FormActions.vue';
export default {
  props: ['id'],
  mixins: [LoaderMixin],
  components: {
    'form-actions': FormActions,
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
  created: function () {
    this.load();
  },
  watch: {
    id() {
      this.load();
    }
  },
  methods: {
    load() {
      if (this.id) {
        this.$store.dispatch('getNote', this.id).then(note => {
          this.note = note;
        });
      } else {
        this.$store.dispatch('createDraftNote').then(note => {
          this.note = note;
        });
      }
    },
  }
}
</script>

<style lang="scss" scoped>
  @import "../style/vars.scss";
  .form {
    width: 100%;
    box-sizing: border-box;
  }
  .form-actions {
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
  .input {
    margin: 0;
    box-sizing: border-box;
    width: 100%;
    height: 100vh;
    border: none;
    border-radius: 0;
    font-size: $editor-font;
    line-height: 1.5;
    padding: 20px calc((100% - 600px) / 2);
    resize: none;
    @media (max-width: $width) {
      padding: 10px 10px 85px;
    }
  }
</style>
