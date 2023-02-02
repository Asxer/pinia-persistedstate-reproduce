<template>
  <div>
    <div class="form-group form-checkbox" :cy-name="name">
      <input
        :id="name"
        :name="name"
        :checked="+modelValue"
        ref="checkbox"
        type="checkbox"
        @input="$emit('update:modelValue', $event.target.checked ? 1 : 0)"
      >

      <label :for="name">
        {{ title }}
      </label>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  modelValue: boolean | null | 0 | 1 | '0' | '1'
  name: string
  title: string
}

const props = defineProps<Props>()
</script>
