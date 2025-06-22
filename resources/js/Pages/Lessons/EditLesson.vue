<template>
    <div class="min-h-screen flex flex-col">
    <Navbar />
    <div class="max-w-2xl mx-auto mt-8 p-6 bg-white rounded-xl shadow-md">
      <h2 class="text-xl font-bold mb-4">Edit Lesson</h2>

      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="mb-4">
          <label class="block font-medium">Title</label>
          <input v-model="form.title" type="text" class="w-full border rounded p-2" />
          <div v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</div>
        </div>

        <div class="mb-4">
          <label class="block font-medium">Content</label>
          <textarea v-model="form.content" class="w-full border rounded p-2" rows="4" />
        </div>

        <div class="mb-4">
          <label class="block font-medium">Video URL</label>
          <input v-model="form.video_url" type="url" class="w-full border rounded p-2" />
        </div>

        <div class="mb-4">
          <label class="block font-medium">Replace PDF File</label>
          <input @change="handleFileUpload" type="file" accept="application/pdf" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Update Lesson
        </button>
      </form>
    </div>
    <Footer class="mt-auto" />
</div>
  </template>


<script setup>
  import { useForm } from '@inertiajs/vue3'
  import Footer from '@/Components/Footer.vue'
  import Navbar from '@/Components/Navbar.vue'

  const props = defineProps({
    course: Object,
    lesson: Object,
  })

  const form = useForm({
    title: props.lesson.title,
    content: props.lesson.content,
    video_url: props.lesson.video_url,
    pdf_file: null,
  })

  const handleFileUpload = (e) => {
    form.pdf_file = e.target.files[0]
  }

  const submit = () => {
    form.submit('put', route('lessons.update', [props.course.id, props.lesson.id]), {
  forceFormData: true,
    })
  }
  </script>