<template>
  <div>
    <em v-if="note.draft">Draft</em>
    <code v-if="note.draft">{{ note.source }}</code>
    <div v-if="note.finished" v-html="note.html"></div>
  </div>
</template>

<script>
export default {
  props: ['note'],
}
</script>
