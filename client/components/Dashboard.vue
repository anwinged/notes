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
    height: 100%;
    display: flex;
    @media (max-width: $width) {
      display: block;
      height: auto;
    }
  }
  %list {
    width: 400px;
    height: 100%;
    flex-grow: 0;
    overflow-y: scroll;
  }
  .index-list {
    @extend %list;
    @media (max-width: $width) {
      width: 100%;
      height: auto;
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
    height: 100%;
    flex-grow: 1;
    border-left: 1px solid #ccc;
    overflow-y: scroll;
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
      height: auto;
      border-left: none;
      overflow-y: auto;
    }
  }
</style>
