<template>
  <ul class="actions">
    <li class="action">
      <router-link :to="{ name: 'note_edit', params: { note_id: note.id }}"
                   class="action-link"
                   title="Edit"
      >
        <i class="fa fa-pencil-square-o"></i>
      </router-link>
    </li>
    <li class="action">
      <a class="action-link" title="Archive"
         v-on:click.prevent.stop="archive()"
      >
        <i class="fa fa-trash-o"></i>
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  props: ['note'],
  methods: {
    archive() {
      console.log('archive!');
    }
  }
}
</script>

<style lang="scss" scoped>
  .actions {
    list-style: none;
    margin: 0;
    padding: 20px 0 0;
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
  }
</style>
