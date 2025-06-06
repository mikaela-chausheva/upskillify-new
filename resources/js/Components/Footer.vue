<template>
    <footer class="bg-gray-900 text-gray-300 pt-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-10 border-b border-gray-700">

          <!-- Logo & About -->
          <div>
            <div class="flex items-center space-x-2">
              <img
                class="h-8 w-8"
                src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                alt="Logo"
              />
              <span class="text-xl font-bold text-white">Upskillify</span>
            </div>
            <p class="mt-4 text-sm text-gray-400">
              Learn anything. Upskill your future.
            </p>
          </div>

          <!-- Dynamic Links -->
          <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Links</h3>
            <ul class="mt-4 space-y-2">
              <li v-for="link in links" :key="link.label">
                <a :href="link.href" class="hover:text-white">{{ link.label }}</a>
              </li>
            </ul>
          </div>

          <!-- Socials -->
          <div>
            <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Follow Us</h3>
            <div class="mt-4 flex space-x-4">
              <a v-for="icon in social" :key="icon.label" :href="icon.href" class="hover:text-white">
                <component :is="icon.icon" class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <div class="mt-6 py-4 text-center text-sm text-gray-500 border-t border-gray-700">
          © {{ year }} Upskillify. All rights reserved.
        </div>
      </div>
    </footer>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Facebook, Twitter, Instagram } from 'lucide-vue-next'

  const year = new Date().getFullYear()

  const links = ref([
    { label: 'Courses', href: '/courses' },
    { label: 'About Us', href: '/about' },
    { label: 'Contact', href: '/contact' },
    { label: 'Terms of Service', href: '/terms' },
  ])

  const social = ref([
    { label: 'Facebook', href: '#', icon: Facebook },
    { label: 'Twitter', href: '#', icon: Twitter },
    { label: 'Instagram', href: '#', icon: Instagram },
  ])
  </script>
