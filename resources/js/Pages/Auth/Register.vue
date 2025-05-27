<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
      <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Create an Account</h2>

        <form @submit.prevent="submitForm" class="space-y-5">
          <!-- First Name -->
          <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input
              v-model="form.first_name"
              type="text"
              id="first_name"
              class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="form.errors.first_name" class="text-red-500 text-sm mt-1">{{ form.errors.first_name[0] }}</p>
          </div>

          <!-- Last Name -->
          <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input
              v-model="form.last_name"
              type="text"
              id="last_name"
              class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="form.errors.last_name" class="text-red-500 text-sm mt-1">{{ form.errors.last_name[0] }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="form.email"
              type="email"
              id="email"
              class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email[0] }}</p>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              v-model="form.password"
              type="password"
              id="password"
              class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password[0] }}</p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              id="password_confirmation"
              class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="form.errors.password_confirmation" class="text-red-500 text-sm mt-1">
              {{ form.errors.password_confirmation[0] }}
            </p>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md font-semibold transition"
          >
            Register
          </button>
        </form>
        <p class="text-sm text-center text-gray-600 mt-4">
            Already have an account?
            <a href="/login" class="text-blue-600 hover:underline font-medium">Log in</a>
        </p>
      </div>
    </div>
  </template>

  <script setup>
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  function submitForm() {
    form.post(route('register.store'), {
      onError(errors) {
        console.log('Validation Errors:', errors)
      },
      onSuccess() {
        window.location.href = "/login"
      },
    })
  }
  </script>
