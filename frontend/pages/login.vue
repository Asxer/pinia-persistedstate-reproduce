<template>
  <div class="login-container">
    <form @submit.prevent="login" class="login form">
      <ui-kit-input
        v-model="auth.email"
        :errors="v$.auth.email"
        :error-messages="{ required: 'Please enter login', email: 'Please enter valid email' }"
        placeholder="Login"
        name="login"
      />

      <ui-kit-input
        v-model="auth.password"
        :errors="v$.auth.password"
        :error-messages="{ required: 'Please enter password' }"
        placeholder="Password"
        name="password"
        type="password"
      />

      <button class="button button-success full-width">
        Login
      </button>
      <label v-if="error" class="form-error">{{ error }}</label>
    </form>

    <label class="login-footer">
      Handcrafted by <a href="https://artel-workshop.com/en/clients">Artel Workshop</a>
    </label>
  </div>
</template>

<script lang="ts" setup>
import type { LoginData } from '~/types/auth'
import { required, email } from '@vuelidate/validators'
import { ref, reactive } from '@vue/reactivity'
import { useAuthStore } from '~/store/auth'
import { navigateTo, useHead } from '#imports'
import { ADMIN_ROLE } from '~/types/auth'
import UiKitInput from '~/components/UiKit/UiKitInput.vue'
import useVuelidate from '@vuelidate/core'

useHead({ title: 'Login' })
const store = useAuthStore()

if (!!store.token) {
  navigateTo('/dashboard/girls')
}

const auth: LoginData = reactive({
  email: '',
  password: ''
})
let error = ref('')

const v$ = useVuelidate({
  auth: {
    email: { required, email },
    password: { required },
  }
}, { auth })

async function login() {
  v$.value.$touch()

  if (v$.value.$error) {
    return
  }

  try {
    const response = await store.login(auth)

    if (response.data.user.role_id !== ADMIN_ROLE) {
      error.value = 'Permission denied'

      return
    }

    store.token = response.data.token

    return await navigateTo('/dashboard/girls')
  } catch (e: any) {
    if (e.response && e.response.status === 401) {
      error.value = 'Wrong login or password'

      return
    }

    error.value = e as string
  }
}
</script>
