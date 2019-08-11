<template>
  <ul class="global-actions">
    <li class="action">
      <router-link :to="{ name: 'note_index' }"
                   title="Go to index"
      >Notes</router-link>
    </li>
    <li class="action">
      <a v-on:click.prevent="createNewNote"
         href="#"
         title="Create new note"
      >Create new</a>
    </li>
    <li class="action">
      <form class="search-form" v-on:submit.prevent="search()">
        <input class="search-input"
               title="Search"
               type="text"
               v-model="query"
               placeholder="Search"
        >
      </form>
    </li>
  </ul>
</template>

<script>
import Action from '../store/actions.js';
export default {
  data() {
    return {
      query: '',
    };
  },
  methods: {
    createNewNote() {
      this.$store.dispatch(Action.CREATE_DRAFT_NOTE).then(note => {
        this.$router.push({
          name: 'note_edit',
          params: { id: note.id },
        });
      });
    },
    search() {
      this.$router.push({ name: 'note_index', query: { q: this.query } });
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars';
.global-actions {
  list-style: none;
  margin: 0;
  padding: 0;
}
.action {
  display: inline-block;
  margin-right: $gap;
  padding: $gap 0;
}
</style>
