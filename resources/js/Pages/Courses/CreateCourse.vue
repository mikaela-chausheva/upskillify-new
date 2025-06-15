<template>
    <Navbar />

    <div class="max-w-3xl mx-auto p-6">
        <form @submit.prevent="submitForm">
            <!-- Title -->
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base/7 font-semibold text-gray-900">Course</h2>
            <p class="mt-1 text-sm/6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                <label for="title" class="block text-sm/6 font-medium text-gray-900">Title</label>
                <div class="mt-2">
                    <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                    <div class="shrink-0 select-none text-base text-gray-500 sm:text-sm/6">upskillify.com/</div>
                    <input
                        v-model="form.title"
                        type="text"
                        name="title"
                        id="title"
                        placeholder="laravel-vue-inertia-tailwindcss-course"
                        class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                        />
                    </div>
                </div>
                </div>

                <!-- Description -->

                <div class="col-span-full">
                <label for="description" class="block text-sm/6 font-medium text-gray-900">Description</label>
                <div class="mt-2">
                    <textarea
                    v-model="form.description"
                    name="description"
                    id="description"
                    rows="3"
                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
                <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about the course.</p>
                </div>


                <!-- Photo URL -->

                <div class="col-span-full" v-if="form">
                    <label for="photo_url" class="block text-sm font-medium text-gray-900">Cover Photo URL</label>
                    <div class="mt-2">
                        <input
                        v-model="form.photo_url"
                        type="url"
                        name="photo_url"
                        id="photo_url"
                        placeholder="https://example.com/course-cover.jpg"
                        class="block w-full rounded-lg bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                        />
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Enter the full image URL for your course cover photo.</p>
                </div>

                <!-- Price -->
                <div class="sm:col-span-3">
                    <label for="price" class="block text-sm font-medium text-gray-900">Price</label>
                    <div class="mt-2">
                        <input
                        type="number"
                        name="price"
                        id="price"
                        v-model="form.price"
                        min="0"
                        step="0.01"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                        />
                    </div>
                </div>

            </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save</button>
        </div>
        </form>
    </div>
    <Footer/>
  </template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue'

import { useForm } from '@inertiajs/vue3';

  const form = useForm({
  title: '',
  description: '',
  photo_url: '',
  price :0
  });


function submitForm() {
  form.post(route('course.store'), {
    onStart() {
      console.log('Submitting form...');
    },
    onFinish() {
      console.log('Form submission finished.');
    },
    onError(errors) {
      console.log('Form errors:', errors);
    },
    onSuccess() {
      console.log('Course created successful!');
      window.location.href = "/createCourse";
    }
  })
}
</script>
