<template>
  <nuxt-link :to="to" class="sidebar-link">
    <i :class="`fa-${icon}`" class="fas sidebar-icon"></i>
    <label class="sidebar-title">{{ title }}</label>
  </nuxt-link>
</template>

<script lang="ts" setup>
const props = defineProps({
  icon: {
    type: String,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  to: {
    type: String,
    required: true
  }
})
</script>
