<template>
  <dashboard-layout title="Categories list">
    <ui-kit-box :show-close-button="false" :with-header="false">
      <template v-slot:content>
        <ui-kit-search-results-table
          :fields="tableHeader"
          :entities="categoriesList"
          @open-modal="updateCategoryModal.open($event)"
          name="favors-list"
        />
      </template>
    </ui-kit-box>

    <update-category-modal ref="updateCategoryModal" />
  </dashboard-layout>
</template>

<script lang="ts" setup>
import { useStore } from '~/store'
import { useCategoriesStore } from '~/store/categories'
import { computed, Ref, ref } from '@vue/reactivity'
import { SimpleTableHeaderItem } from '~/types/uiKit'
import { useAsyncData } from '#imports'
import { Category } from '~/types'
import UiKitSearchResultsTable from '~/components/UiKit/UiKitSearchResultsTable.vue'
import UpdateCategoryModal from '~/components/Categories/UpdateCategoryModal.vue'
import DashboardLayout from '~/components/Layout/DashboardLayout.vue'

const categoriesStore = useCategoriesStore()
const store = useStore()

const updateCategoryModal = ref<InstanceType<typeof UpdateCategoryModal>>(null)

const tableHeader: Ref<SimpleTableHeaderItem[]> = ref([
  { name: 'Category', class: 'col-100' },
])

const categoriesList = computed(() => categoriesStore.items.data.map((category: Category) => ({
  event: {
    name: 'openModal',
    payload: category
  },
  line: [
    category.name,
  ]
})))

await useAsyncData('categories', async () => {
  await categoriesStore.fetchAll()

  return categoriesStore.items
})
</script>