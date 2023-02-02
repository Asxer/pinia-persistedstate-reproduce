<template>
  <div>
    <div class="layout">
      <input
          ref="toggleCheckbox"
          id="sidebar-toggle"
          class="sidebar-checkbox"
          type="checkbox"
          v-model="isMobileSidebarHidden"
      />
      <label for="sidebar-toggle" class="sidebar-toggle">
        <span class="fas fa-bars"></span>
      </label>

      <nav class="sidebar">
        <div class="sidebar-logo">
          <img src="/images/logo.png" class="sidebar-logo-image">
        </div>

        <div class="sidebar-items-list">
          <sidebar-item title="Girls" icon="house" to="/dashboard/cities" />
          <sidebar-item title="Girls" icon="flag" to="/dashboard/countries" />
        </div>
      </nav>

      <section class="page">
        <header class="header">
          <span class="header-title">
            {{ title }}
          </span>

          <a class="header-logout" @click="auth.logout()">
            <span>Logout</span>
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </header>

        <div class="main">
          <slot />
        </div>
      </section>

      <footer class="footer">
        (c) 2022
      </footer>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { useRouter, useHead } from '#imports'
import { useAuthStore } from '~/store/auth'
import { useStore } from '~/store'
import SidebarItem from '~/components/SidebarItem.vue'

const props = defineProps({
  title: {
    type: String,
    required: true
  }
})

const router = useRouter()
const store = useStore()
const auth = useAuthStore()

useHead({ title: props.title })

let isMobileSidebarHidden: boolean = true
router.beforeEach(() => {
  isMobileSidebarHidden = true
})
</script>
