<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Потребители</h1>

      <div v-if="$page.props.flash?.success" class="mb-4 text-green-600">
        {{ $page.props.flash.success }}
      </div>

      <table class="w-full text-left border border-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border-b">Име</th>
            <th class="p-2 border-b">Email</th>
            <th class="p-2 border-b">Роля</th>
            <th class="p-2 border-b">Действия</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t hover:bg-gray-50">
            <td class="p-2">{{ user.name }}</td>
            <td class="p-2">{{ user.email }}</td>
            <td class="p-2 capitalize">{{ user.role }}</td>
            <td class="p-2">
              <select
                v-model="user.role"
                @change="updateRole(user)"
                class="border rounded p-1 text-sm"
              >
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Admin</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script setup>
  import { router } from '@inertiajs/vue3'

  const props = defineProps({
    users: {
      type: Array,
      required: true,
    },
  })

  function updateRole(user) {
    router.patch(`/admin/users/${user.id}/role`, {
      role: user.role,
    }, {
      preserveScroll: true,
    })
  }
  </script>
