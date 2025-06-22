<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
      <div class="bg-white shadow-md rounded-xl w-full max-w-md p-8">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Log In</h2>

        <form @submit.prevent="submit" class="space-y-5">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                v-model="form.email"
                type="email"
                id="email"
                autocomplete="email"
                class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            />
            <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
        </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
                v-model="form.password"
                type="password"
                id="password"
                autocomplete="current-password"
                required
                class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</p>


            </div>

          <!-- Login Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md font-semibold transition"
          >
            Login
          </button>
        </form>
        <div v-if="form.errors.email" class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            {{ form.errors.email }}
        </div>
        <a
        href="/auth/google/redirect"
        class="mt-4 flex items-center justify-center rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
        >
        <svg class="mr-2 h-5 w-5" viewBox="0 0 48 48"><path fill="#fff" d="..."/></svg>
        Login with Google
        </a>


        <p class="text-sm text-center text-gray-600 mt-4">
            Don't have an account?
            <a href="/register" class="text-blue-600 hover:underline font-medium">Register</a>
        </p>
      </div>
    </div>
  </template>

<style scoped>
.error {
  color: red;
  margin-top: 5px;
  font-size: 0.9rem;
}
</style>


  <script setup>
  import { useForm } from '@inertiajs/vue3'
  import { route } from 'ziggy-js'

  const form = useForm({
    email: '',
    password: '',
  })

  const submit = () => {
    form.post(route('login.store'), {
      onFinish: () => form.reset('password'),
      onError: (errors) => {
      console.log("Login errors", form.errors)
    },
      onSuccess: () => {
        window.location.href = route('home')
      },
    })
  }
  </script>
