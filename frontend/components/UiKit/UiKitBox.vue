<template>
  <div>
    <div
      v-if="!isClosed"
      class="ui-kit-box"
    >
      <div
        v-if="withHeader"
        class="ui-kit-box-title"
      >
        <h5>{{ title }}</h5>

        <div :class="{ open: isOptionsShown }" class="ui-kit-box-tools">
          <a
            v-if="showCollapseButton"
            :class="{ 'fa-chevron-down': isCollapsed, 'fa-chevron-up': !isCollapsed }"
            @click="toggleCollapsing()"
            class="ui-kit-box-tools-link fa"
            cy-name="collapse-button"
          ></a>

          <a
            v-for="button in customButtons"
            :class="button.class"
            @click="$emit(button.event)"
            class="ui-kit-box-tools-link fa">
          </a>

          <a
            v-if="options.length"
            @click="isOptionsShown = !isOptionsShown"
            @blur="isOptionsShown = !isOptionsShown"
            class="ui-kit-box-dropdown-toggle fa fa-wrench">
          </a>
          <ul v-if="isOptionsShown" class="ui-kit-box-dropdown-menu">
            <li v-for="option in options">
              <a @click="$emit(option.event)">
                {{ option.title }}
              </a>
            </li>
          </ul>

          <a
            v-if="showCloseButton"
            @click="close()"
            class="ui-kit-box-tools-link fa fa-times"
            cy-name="close-button"
          ></a>
        </div>
      </div>

      <header v-show="!isCollapsed" class="ui-kit-box-heading">
        <slot name="heading"></slot>
      </header>

      <section v-show="!isCollapsed" class="ui-kit-box-content" cy-name="box-content">
        <slot name="content"></slot>
      </section>

      <footer v-if="withFooter" class="ui-kit-box-footer">
        <slot name="footer"></slot>
      </footer>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from '@vue/reactivity'
import type { UiKitBoxCustomButton, UiKitBoxCustomOption } from '~/types/uiKit'

const emit = defineEmits(['close', 'collapse', 'expand'])

interface Props {
  title?: string
  showCloseButton?: boolean
  showCollapseButton?: boolean
  showOptionsButton?: boolean
  withFooter?: boolean
  withHeader?: boolean
  collapsed?: boolean
  customButtons?: UiKitBoxCustomButton[]
  options?: UiKitBoxCustomOption[]
}

const props = withDefaults(defineProps<Props>(), {
  showCloseButton: true,
  showCollapseButton: true,
  showOptionsButton: true,
  withFooter: false,
  withHeader: true,
  collapsed: false,
  customButtons: () => ([]),
  options: () => ([]),
})

let isClosed = ref(false)
let isOptionsShown = ref(false)
let isCollapsed = ref(props.collapsed)

function close() {
  emit('close')

  isClosed.value = true
}

function toggleCollapsing() {
  isCollapsed.value = !isCollapsed.value

  if (isCollapsed.value) {
    emit('collapse')
  } else {
    emit('expand')
  }
}
</script>