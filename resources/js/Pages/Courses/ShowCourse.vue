<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-xl mt-8">
      <img :src="course.photo_url" alt="Course Image" class="rounded-lg w-full h-64 object-cover mb-6" />

      <h1 class="text-2xl font-bold mb-2">{{ course.title }}</h1>
      <p class="text-gray-700 mb-4">{{ course.description }}</p>
      <p class="text-lg font-semibold text-blue-600 mb-6">Price: ${{ course.price }}</p>

      <h2 class="text-xl font-bold mb-4">Lessons</h2>

      <ul v-if="course.lessons && course.lessons.length > 0" class="list-disc pl-6 space-y-2">
        <li v-for="lesson in course.lessons" :key="lesson.id">
            <Link
            :href="route('lessons.show', [course.id, lesson.id])"
            class="text-blue-600 hover:underline"
                >
            {{ lesson.title }}
            </Link>
            - {{ lesson.content }}
        </li>
      </ul>

      <div v-else class="text-gray-500">
        <p>No lessons yet.</p>

    </div>

    <!--  Button to add lessons  -->
    <Link
        v-if="authUser?.role === 'teacher' && authUser.id === course.teacher_id"
        :href="route('lessons.create', course.id)"
        class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Lesson
    </Link>


    </div>
    <!-- <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">{{ course.title }}</h1>
      <Link
        :href="route('lessons.create', course.id)"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        + Add Lesson
      </Link>
    </div> -->

  </template>

  <script setup>
  import Navbar from '@/Components/Navbar.vue';
  import { Link } from '@inertiajs/vue3';
  import { route } from 'ziggy-js';

  const props = defineProps({
    course: Object,
    authUser : Object,
  })
  </script>
