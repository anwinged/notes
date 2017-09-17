<template>
  <main class="dashboard">
    <section class="list">
      <router-view name="list"></router-view>
    </section>
    <section class="view">
      <router-view name="view"></router-view>
    </section>
  </main>
</template>

<style lang="scss" scoped>
  .dashboard {
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    display: flex;
  }
  .list {
    width: 400px;
    height: 100%;
    flex-grow: 0;
    overflow-y: scroll;
  }
  .view {
    height: 100%;
    flex-grow: 1;
    border-left: 1px solid #ccc;
    overflow-y: scroll;
  }
</style>
