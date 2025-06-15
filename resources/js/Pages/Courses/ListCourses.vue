<template>
    <Navbar />
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="sr-only">Products</h2>

        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
          <!-- <a v-for="course in courses" :key="course.id" :href="course.href" class="group"> -->
            <a
            v-for="course in courses"
            :key="course.id"
            :href="route('courses.show', course.id)"
            class="group"
            >
            <img :src="course.photo_url" alt="" class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]" />
            <h3 class="mt-4 text-sm text-gray-700">{{ course.title }}</h3>
            <p class="text-sm text-gray-500">{{ course.description }}</p>
            <p class="mt-1 text-lg font-medium text-gray-900">${{ course.price }} </p>
          </a>
        </div>
      </div>
    </div>
    <Footer/>
  </template>

  <script setup>
  import Navbar from '@/Components/Navbar.vue';
  import Footer from '@/Components/Footer.vue'
  import { usePage } from '@inertiajs/vue3';
  import { route } from 'ziggy-js';
  const { courses } = usePage().props;

  </script>