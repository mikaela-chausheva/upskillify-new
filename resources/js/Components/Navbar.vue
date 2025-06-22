<template>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
          <!-- Mobile Menu Button -->
          <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
            <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
              <XMarkIcon v-else class="block size-6" aria-hidden="true" />
            </DisclosureButton>
          </div>

          <!-- Logo + Menu -->
          <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <!-- Logo -->
            <div class="flex shrink-0 items-center">
              <a href="/">
                <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Upskillify" />
              </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:ml-6 sm:block">
              <div class="flex space-x-4">
                <a
                  v-for="item in navigation"
                  :key="item.name"
                  :href="item.href"
                  :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                  :aria-current="item.current ? 'page' : undefined"
                >
                  {{ item.name }}
                </a>
              </div>
            </div>

            <!-- Search Box -->
            <div class="hidden sm:flex sm:ml-6 sm:w-64">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search courses..."
                class="w-full rounded-md bg-gray-700 text-white placeholder-gray-400 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 px-3 py-2 text-sm"
                @keyup.enter="performSearch"
              />
            </div>
          </div>

          <!-- User Section or Login/Register -->
          <div v-if="user" class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <!-- Notification Icon -->
            <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="absolute -inset-1.5" />
              <span class="sr-only">View notifications</span>
              <BellIcon class="size-6" aria-hidden="true" />
            </button>

            <!-- Profile Dropdown -->
            <Menu as="div" class="relative ml-3">
              <div>
                <MenuButton class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                  <span class="absolute -inset-1.5" />
                  <span class="sr-only">Open user menu</span>
                  <img class="size-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                </MenuButton>
              </div>

              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none">
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']">Your Profile</a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <a href="#" :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</a>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <button
                      type="button"
                      @click="logout"
                      :class="[active ? 'bg-gray-100' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']"
                    >
                      Sign out
                    </button>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>

          <!-- If not logged in -->
          <div v-else class="absolute right-0 flex gap-3 pr-2">
            <a href="/login" class="text-sm text-white hover:underline">Login</a>
            <a href="/register" class="text-sm text-white hover:underline">Register</a>
          </div>
        </div>
      </div>

      <!-- Mobile navigation -->
      <DisclosurePanel class="sm:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
          <DisclosureButton
            v-for="item in navigation"
            :key="item.name"
            as="a"
            :href="item.href"
            :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
            :aria-current="item.current ? 'page' : undefined"
          >
            {{ item.name }}
          </DisclosureButton>
        </div>
      </DisclosurePanel>
    </Disclosure>
  </template>


<script setup>
import { computed } from 'vue'
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems
} from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { router, usePage } from '@inertiajs/vue3'

const navigation = computed(() => {
  if (!user) {
    return [
      { name: 'Courses', href: route('courses.list'), current: isCurrent('courses.list') },
    ]
  }

  if (user.role === 'teacher') {
    return [
      { name: 'Courses', href: route('courses.list'), current: isCurrent('courses.list') },
      { name: 'My Courses', href: route().has('courses.mine') ? route('courses.mine') : '#', current: isCurrent('courses.mine') },
      { name: 'Create Course',
        href: user && route().has('course.viewCreate') ? route('course.viewCreate') : '#',
        current: isCurrent('course.viewCreate')  },
    ]
  }
  // Admin
  if (user.role === 'admin') {
    return [
      { name: 'Courses', href: route('courses.list'), current: isCurrent('courses.list') },
      { name: 'My Courses', href: route().has('courses.mine') ? route('courses.mine') : '#', current: isCurrent('courses.mine') },
      { name: 'Create Course',
        href: user && route().has('course.viewCreate') ? route('course.viewCreate') : '#',
        current: isCurrent('course.viewCreate')  },
        { name: 'Admin Dashboard', href:route().has('admin.dashboard') ? route('admin.dashboard') : '#', current: isCurrent('admin.dashboard') },
        { name: 'Users - Roles', href:route().has('admin.users.index') ? route('admin.users.index') : '#', current: isCurrent('admin.users.index') }
    ]

  }

  // Students
  return [
    { name: 'Courses', href: route('courses.list'), current: isCurrent('courses.list') },
    { name: 'My Courses', href: route().has('courses.mine') ? route('courses.mine') : '#', current: isCurrent('courses.mine') },
  ]
})

const page = usePage()
const user = page.props.auth?.user

function isCurrent(name) {
  return route().current(name)
}

function logout() {
  router.post(route('logout'), {}, {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Logged out successfully")
      window.location.reload();
    },
    onError: (errors) => {
      console.error("Logout error:", errors)
    }
  })
}
</script>

