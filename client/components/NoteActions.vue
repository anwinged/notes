<template>
  <div class="action-panel">
    <!-- Note actions -->
    <ul class="actions">
      <li class="action">
        <router-link :to="{ name: 'note_edit', params: { id: note.id }}"
                     class="action-link"
                     title="Edit"
        >
          <i class="fa fa-pencil-square-o"></i>
        </router-link>
      </li>
      <li v-if="note.active" class="action">
        <a class="action-link" title="Archive"
           v-on:click.prevent.stop="archive()"
        >
          <i class="fa fa-trash-o"></i>
        </a>
      </li>
      <li v-if="note.archived" class="action">
        <a class="action-link" title="Restore"
           v-on:click.prevent.stop="restore()"
        >
          <i class="fa fa-repeat"></i>
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
    archive() {
      this.$store.dispatch('archive', this.note).then(archived => {
        Object.assign(this.note, archived);
      });
    },
    restore() {
      this.$store.dispatch('restore', this.note).then(restored => {
        Object.assign(this.note, restored);
      });
    }
  }
}
</script>

<style lang="scss" scoped>
  @import "../style/vars.scss";
  .action-panel {
    display: flex;
    justify-content: space-between;
    background-color: white;
    @media (max-width: $width) {
      width: 100%;
    }
  }
  .actions {
    list-style: none;
    margin: 0;
    padding: 20px 0 0;
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
