<template>
  <div class="action-panel">
    <!-- Note actions -->
    <ul class="actions">
      <li v-if="note.finished" class="action">
        <router-link :to="{ name: 'note_view', params: { id: note.id }}"
                     class="action-link"
                     title="View"
        >
          <i class="fa fa-sticky-note-o"></i>
        </router-link>
      </li>
      <li v-if="note.is.active" class="action">
        <a class="action-link" title="Save"
           v-on:click.prevent.stop="save"
        >
          <i class="fa fa-floppy-o"></i>
        </a>
      </li>
    </ul>
    <!-- Index -->
    <ul class="actions action-index">
      <li class="action">
        <router-link :to="{ name: 'note_index' }"
                     class="action-link"
                     title="Index"
        >
          Index
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ['note'],
  methods: {
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
.action-panel {
  display: flex;
  justify-content: space-between;
  background-color: $background-color;
  @media (max-width: $width) {
    width: 100%;
  }
}
.actions {
  list-style: none;
  margin: 0;
  padding: 0;
  @media (max-width: $width) {
    display: flex;
    padding: 0;
  }
}
.action {
  margin: 0;
  padding: 0;
  cursor: pointer;
}
.action-link {
  display: inline-block;
  padding: 8px 15px;
  font-size: 140%;
  @media (max-width: $width) {
    padding: 20px;
  }
}
.action-index {
  display: none;
  @media (max-width: $width) {
    display: block;
  }
}
</style>
