<template>
  <section class="page">
    <p>
      Username: {{ user.username }}
    </p>
    <p>
      Email: {{ user.email }}
    </p>
    <p>
      <router-link :to="{ name: 'home' }">Back</router-link>
    </p>
  </section>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$store.state.user;
    }
  }
}
</script>

<style lang="scss" scoped>
  .page {
    margin: 2em auto;
    max-width: 400px;
  }
</style>
