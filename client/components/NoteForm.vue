<template>
  <div class="component">
    <div class="content">
      <loader v-if="loading"></loader>
      <not-found v-if="missed"></not-found>
      <form v-if="found">
        <nav class="actions">
          <button v-on:click="save">Save</button>
          <router-link v-if="note.finished" :to="{ name: 'note_view', params: { id: note.id }}">View</router-link>
        </nav>
        <textarea v-model="note.source" class="input" title="Input"></textarea>
      </form>
    </div>
  </div>
</template>

<script>
import LoaderMixin from '../mixins/LoaderMixin';
export default {
  props: ['id'],
  mixins: [LoaderMixin],
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
    save: function () {
      this.$store.dispatch('saveNote', this.note).then((note) => {
        this.$router.push({
          name: 'note_view',
          params: { id: note.id },
        });
      });
    }
  }
}
</script>

<style scoped>
  .component {
    width: 100%;
    box-sizing: border-box;
    padding: 20px;
    overflow-y: scroll;
  }
  .content {
    max-width: 600px;
    margin: 0 auto;
  }
  .actions {
    margin-bottom: 15px;
  }
  .input {
    width: 100%;
    height: 400px;
  }
</style>
