<template>
  <div class="application">
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: 'app',
}
</script>

<style scoped>
  .application {
    box-sizing: border-box;
    width: 100%;
  }
  .content {
    width: 600px;
    margin: 0 auto;
    margin-top: 60px;
    margin-bottom: 40px;
  }
</style>
