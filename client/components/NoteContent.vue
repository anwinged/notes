<template>
  <div>
    <em v-if="note.is.draft">Draft</em>
    <code v-if="note.is.draft">{{ note.source }}</code>
    <div v-if="note.is.finished" v-html="note.html"></div>
  </div>
</template>

<script>
export default {
  props: ['note'],
};
</script>
