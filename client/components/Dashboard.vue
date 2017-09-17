<template>
  <main class="dashboard">
    <section :class="listClass">
      <router-view name="list"></router-view>
    </section>
    <section :class="viewClass">
      <router-view name="view"></router-view>
    </section>
  </main>
</template>

<script>
export default {
  props: ['id'],
  computed: {
    listClass() {
      return {
        'index-list': !this.id,
        'item-list': !!this.id,
      }
    },
    viewClass() {
      return {
        'index-view': !this.id,
        'item-view': !!this.id,
      }
    }
  },
}
</script>

<style lang="scss" scoped>
  @import "../style/vars.scss";
  .dashboard {
    box-sizing: border-box;
    width: 100%;
    height: 100vh;
    @media (max-width: $width) {
      display: block;
      height: auto;
    }
  }
  %list {
    box-sizing: border-box;
    width: 400px;
    min-width: 400px;
    height: 100vh;
    display: block;
    position: fixed;
    overflow-y: scroll;
  }
  .index-list {
    @extend %list;
    @media (max-width: $width) {
      min-width: initial;
      width: auto;
      height: auto;
      position: static;
      overflow-y: auto;
    }
  }
  .item-list {
    @extend %list;
    @media (max-width: $width) {
        display: none;
    }
  }
  %view {
    min-height: 100vh;
    box-sizing: border-box;
    margin-left: 400px;
    border-left: 1px solid #ccc;
    flex-grow: 1;
  }
  .index-view {
    @extend %view;
    @media (max-width: $width) {
      display: none;
    }
  }
  .item-view {
    @extend %view;
    @media (max-width: $width) {
      margin-left: 0;
      border-left: none;
      height: auto;
    }
  }
</style>
