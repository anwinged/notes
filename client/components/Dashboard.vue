<template>
  <main class="dashboard">
    <!-- Action panel -->
    <nav class="actions">
      <div class="actions-content">
        <global-actions />
      </div>
    </nav>
    <!-- Page content -->
    <article class="content">
      <router-view></router-view>
    </article>
  </main>
</template>

<script>
import GlobalActions from './GlobalActions.vue';
export default {
  components: {
    'global-actions': GlobalActions,
  },
};
</script>

<style lang="scss" scoped>
@import '../style/vars.scss';
.dashboard {
  display: block;
  box-sizing: border-box;
  width: 100%;
  min-height: 100vh;
  background-color: $background-color;
}
.actions {
  box-sizing: border-box;
  width: 100%;
  background-color: white;
  margin-bottom: $gap;
  border-bottom: 1px solid $border-color;
}
.actions-content {
  margin: 0 auto;
  width: $content-width;
}
.content {
  display: block;
  margin: 0 auto;
  box-sizing: border-box;
  max-width: $content-width;
}
</style>
