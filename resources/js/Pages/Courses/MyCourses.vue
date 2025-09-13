<template>
    <div class="min-h-screen flex flex-col">
      <Navbar />

      <!-- Outer wrapper with more padding and centered content -->
      <div class="px-4 sm:px-8 lg:px-16 py-8 max-w-7xl mx-auto w-full">
        <h1 class="text-3xl font-bold mb-8">My Courses</h1>

        <!-- Teacher-only section -->
        <div v-if="auth.user?.role === 'teacher'" class="mb-12">
          <h2 class="text-2xl font-semibold mb-4">Courses You Created</h2>
          <div v-if="createdCourses.length">
            <div
              v-for="course in createdCourses"
              :key="course.id"
              class="bg-white shadow-md p-6 rounded-xl mb-6"
            >
              <img
                v-if="course.photo_url"
                :src="course.photo_url"
                alt="Course Cover"
                class="w-full h-48 object-cover rounded-lg mb-4"
              />
              <h3 class="text-xl font-semibold">{{ course.title }}</h3>
              <p class="text-gray-600 text-sm">{{ course.description }}</p>
              <Link
                :href="route('courses.show', course.id)"
                class="text-blue-600 hover:underline text-sm mt-3 block"
              >
                View Course
              </Link>
            </div>
          </div>
          <p v-else class="text-gray-500 italic">You haven't created any courses yet.</p>
        </div>

        <!-- Enrolled courses section -->
        <div>
          <h2 class="text-2xl font-semibold mb-4">Courses You Enrolled In</h2>
          <div v-if="enrolledCourses.length">
            <div
              v-for="course in enrolledCourses"
              :key="course.id"
              class="bg-white shadow-md p-6 rounded-xl mb-6"
            >
              <img
                v-if="course.photo_url"
                :src="course.photo_url"
                alt="Course Cover"
                class="w-full h-48 object-cover rounded-lg mb-4"
              />
              <h3 class="text-xl font-semibold">{{ course.title }}</h3>
              <p class="text-gray-600 text-sm">{{ course.description }}</p>
              <Link
                :href="route('courses.show', course.id)"
                class="text-blue-600 hover:underline text-sm mt-3 block"
              >
                View Course
              </Link>
            </div>
          </div>
          <p v-else class="text-gray-500 italic">You are not enrolled in any courses yet.</p>
        </div>
      </div>

      <Footer class="mt-auto" />
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
