<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/task_lists">Task Lists</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="taskList.deleted_at" class="mb-6" @restore="restore"> This task list has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!taskList.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Task List</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Task List</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 text-2xl font-bold">Tasks</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
      <thead>
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
        </tr>
        </thead>
        <tbody tag='tbody' v-if="taskList.tasks.length > 0" is='draggable' group='taskList.tasks'>
        <tr v-for="task in taskList.tasks" :key="task.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/task_lists/${taskList.id}/task/${task.id}/edit`">
              {{ task.name }}
              <icon v-if="task.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/tasks/${task.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="taskList.tasks.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No tasks found.</td>
        </tr>
        </tbody>
      </table>


       <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <!-- <form @submit.prevent="update"> -->
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <Link class="btn-indigo hover:underline" :href="`/task_lists/${taskList.id}/task/create`">Create a Task</Link>
        </div>
      <!-- </form> -->
    </div>


    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon.vue'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    taskList: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.taskList.name
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/task_lists/${this.taskList.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this taskList?')) {
        this.$inertia.delete(`/task_lists/${this.taskList.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this taskList?')) {
        this.$inertia.put(`/task_lists/${this.taskList.id}/restore`)
      }
    },
  },
}
</script>