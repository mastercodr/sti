<template>
  <div>
    <Head :title="`${task.name}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <a class="text-indigo-400 hover:text-indigo-600" :href="`/task_lists/${this.taskList.id}/edit`">{{ this.taskList.name }}</a> <br/><br/>
      <span class="text-indigo-400 font-medium">Edit task</span>
    </h1>
    <trashed-message v-if="task.deleted_at" class="mb-6" @restore="restore"> This task has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 w-full lg:w-1/2" label="Name" />
          </div>
           <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 w-full lg:w-1/2" label="Description" />
          </div>
           <div class="flex flex-wrap -mb-8 -mr-6 p-8">
           <label class="form-label" :for="completed">Completed</label>&nbsp;&nbsp;
            <CheckboxInput name="completed" v-model:checked="form.completed" :error="form.errors.completed" class="pb-8 pr-6" label="Completed" />
          </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!task.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Task</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Task</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
//import CheckboxInput from '@/Shared/Checkbox.vue'
import CheckboxInput from '@/Components/Checkbox.vue';

import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    CheckboxInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    task: Object,
    taskList: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.task.name,
        description: this.task.description,
        completed: this.task.completed
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/task_lists/${this.taskList.id}/task/${this.task.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this task?')) {
        this.$inertia.delete(`/task_lists/${this.taskList.id}/task/${this.task.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this task?')) {
        this.$inertia.put(`/task_lists/${this.taskList.id}/task/${this.task.id}/restore`)
      }
    },
  },
}
</script>
