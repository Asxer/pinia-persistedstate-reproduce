<template>
  <div>
    <fieldset class="form-group">
      <the-mask
        v-if="mask"
        :mask="mask"
        :max="max"
        :min="min"
        :name="name"
        :type="type"
        :model-value="modelValue"
        :class="{ 'form-control-filled': modelValue }"
        :cy-name="name"
        autocomplete="off"
        class="form-control"
        @update:modelValue="onChanged"
      />

      <input
        v-else
        :max="max"
        :min="min"
        :step="step"
        :name="name"
        :type="type"
        :value="modelValue"
        :class="{ 'form-control-filled': modelValue || ['datetime-local', 'date'].includes(type)  }"
        :cy-name="name"
        autocomplete="off"
        class="form-control"
        @input="onChanged"
      />

      <label
        v-if="placeholder"
        :for="name"
        class="form-label"
      >
        {{ placeholder }}
      </label>

      <span v-if="errors.$error" class="form-errors-list">
        <span
          v-for="(message, key) in errorMessages"
          v-show="errors[key].$invalid"
          :key="key"
          class="form-error error"
          v-html="message"
        ></span>
      </span>
    </fieldset>
  </div>
</template>

<script lang="ts" setup>
import TheMask from 'vue-the-mask'
import { InputValue } from '~/types/uiKit'

const emit = defineEmits(['update:modelValue'])

let timeout: any = null

interface Props {
  modelValue: InputValue
  placeholder: string
  name?: string
  title?: string
  mask?: string
  type?: string
  max?: number | string
  min?: number | string
  step?: number | string
  timeout?: number
  errors?: {
    $error: boolean
  },
  errorMessages?: object,
  isDescription?: boolean
  description?: string
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  min: 0,
  step: 1,
  timeout: 0,
  errors: () => ({ $error: false }),
  errorMessages: () => ({}),
  isDescription: false
})

function input($event: any) {
    let value = props.mask ? $event : $event.target.value

    if (props.type === 'number') {
      value = parseFloat(value)
    }

    emit('update:modelValue', value)
  }

function onChanged(value: any) {
  if (props.timeout) {
    clearTimeout(timeout)

    timeout = setTimeout(() => input(value), props.timeout)
  } else {
    input(value)
  }
}
</script>
