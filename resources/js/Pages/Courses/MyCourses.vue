<template>
    <div class="min-h-screen flex flex-col">
     <Navbar />
     <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">My Courses</h1>

    <!-- Only for teachers -->
    <div v-if="auth.user?.role === 'teacher'">
      <h2 class="text-lg font-semibold mb-2">Courses You Created</h2>
      <div v-if="createdCourses.length">
        <div
          v-for="course in createdCourses"
          :key="course.id"
          class="bg-white shadow-md p-4 rounded-lg mb-4"
        >
        <img
            v-if="course.photo_url"
            :src="course.photo_url"
            alt="Course Cover"
            class="w-full h-48 object-cover rounded-md mb-4"
        />
          <h2 class="text-xl font-semibold">{{ course.title }}</h2>
          <p class="text-sm text-gray-600">{{ course.description }}</p>
          <Link
            :href="route('courses.show', course.id)"
            class="text-blue-600 hover:underline text-sm mt-2 block"
          >
            View Course
          </Link>
        </div>
      </div>
      <p v-else>You haven't created any courses yet.</p>
    </div>

    <!-- Always show enrolled courses -->
    <h2 class="text-lg font-semibold mb-2 mt-6">Courses You Enrolled In</h2>
    <div v-if="enrolledCourses.length">
      <div
        v-for="course in enrolledCourses"
        :key="course.id"
        class="bg-white shadow-md p-4 rounded-lg mb-4"
      >

      <img
        v-if="course.photo_url"
        :src="course.photo_url"
        alt="Course Cover"
        class="w-full h-48 object-cover rounded-md mb-4"
    />
        <h2 class="text-xl font-semibold">{{ course.title }}</h2>
        <p class="text-sm text-gray-600">{{ course.description }}</p>
        <Link
          :href="route('courses.show', course.id)"
          class="text-blue-600 hover:underline text-sm mt-2 block"
        >
          View Course
        </Link>
      </div>
    </div>
    <p v-else>You are not enrolled in any courses yet.</p>
  </div>
  <Footer  class="mt-auto" />
</div>
</template>


  <script setup>
    import Navbar from '@/Components/Navbar.vue';
    import Footer from '@/Components/Footer.vue'
    import {route} from 'ziggy-js';
    import { Link, usePage } from '@inertiajs/vue3'

    const props = defineProps({
        createdCourses: Array,
        enrolledCourses: Array,
    });
    const { auth } = usePage().props
  </script>
