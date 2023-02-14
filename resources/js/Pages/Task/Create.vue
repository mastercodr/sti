<template>
  <div>
    <Head title="Create Task" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" :href="`/task_lists/${this.taskList.id}/edit`">Task</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 w-full lg:w-1/2" label="Name" />
          </div>
           <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 w-full lg:w-1/2" label="Description" />
          </div>
           <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <checkbox-input v-model="form.completed" :error="form.errors.completed" class="pb-8 pr-6 w-full lg:w-1/2" label="Completed" />
          </div>
        
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Task</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    taskList: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        description: '',
        task_list_id: this.taskList.id,
        order: 1,
        completed: false
      }),
    }
  },
  methods: {
    store() {
      this.form.post(`/task_lists/${this.taskList.id}/task`)
    },
  },
}
</script>
