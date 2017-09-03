<template>
  <main class="application">
    <header class="header">
      <h1 class="title">
        <router-link :to="{ name: 'note_index' }">Note it</router-link>
      </h1>
      <nav class="navigation">
        <a class="navigation-link" href="/profile">Profile</a>
        <a class="navigation-link" href="/logout">Log out</a>
      </nav>
    </header>
    <div class="content">
      <router-view></router-view>
    </div>
    <footer class="footer">
      Made with love.
    </footer>
  </main>
</template>

<script>
export default {
  name: 'app',
}
</script>

<style lang="scss" scoped>
  %primary {
    width: 600px;
    margin: 0 auto;
  }
  .application {
    box-sizing: border-box;
    width: 100%;
  }
  .header {
    @extend %primary;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }
  .navigation-link {
    display: inline-block;
    margin-left: 1em;
  }
  .content {
    @extend %primary;
    margin-bottom: 40px;
  }
  .footer {
    @extend %primary;
    color: #777;
    margin-bottom: 20px;
  }
</style>
