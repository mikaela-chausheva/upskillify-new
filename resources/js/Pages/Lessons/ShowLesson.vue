<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md mt-8">
      <h1 class="text-2xl font-bold mb-4">{{ lesson.title }}</h1>

      <div v-if="lesson.video_url" class="mb-6">
        <iframe
            v-if="embedUrl"
            :src="embedUrl"
          class="w-full aspect-video"
          frameborder="0"
          allowfullscreen
        ></iframe>
      </div>

      <div v-html="lesson.content" class="prose mb-6"></div>

      <div v-if="lesson.pdf_file" class="mt-4">
        <a
          :href="`/storage/${lesson.pdf_file}`"
          target="_blank"
          class="text-blue-600 underline"
        >
          Download PDF
        </a>
      </div>

      <Link
        v-if="authUser?.id === course.teacher_id"
        :href="route('lessons.edit', [course.id, lesson.id])"
        class="text-sm text-blue-600 underline"
        >
        Edit Lesson
    </Link>

      <Link :href="route('courses.show', course.id)" class="text-sm text-gray-600 hover:underline mt-6 block">
        ← Back to Course
      </Link>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
  import Navbar from '@/Components/Navbar.vue';
import { computed } from 'vue'
  import { route } from 'ziggy-js';

  const props = defineProps({
    course: Object,
    lesson: Object
  });

    const embedUrl = computed(() => {
    if (!props.lesson.video_url) return null;

    const url = props.lesson.video_url;

    // Extract video ID from standard YouTube link
    const match = url.match(/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    if (!match) return null;

    return `https://www.youtube.com/embed/${match[1]}`;
    });
  </script>
