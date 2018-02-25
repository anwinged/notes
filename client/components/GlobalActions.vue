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
  </ul>
</template>

<script>
import Action from '../store/actions.js';
export default {
  methods: {
    createNewNote() {
      this.$store.dispatch(Action.CREATE_DRAFT_NOTE).then(note => {
        this.$router.push({
          name: 'note_edit',
          params: { id: note.id },
        });
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars.scss';
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
